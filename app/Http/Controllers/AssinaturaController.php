<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssinaturaRequest;
use App\Models\Assinatura;
use App\Models\Cliente;
use App\Models\Pagamento;
use App\Models\Plano;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AssinaturaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $assinaturas = Assinatura::query()
            ->when($request->filled('status'), fn($q) =>
                $q->where('status', $request->status)
            )
            ->when($request->filled('plano_id'), fn($q) =>
                $q->where('plano_id', $request->plano_id)
            )
            ->when($request->filled('cliente_id'), fn($q) =>
                $q->where('cliente_id', $request->cliente_id)
            )
            ->with(['cliente', 'plano'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $planos = Plano::ativos()->get();

        $resumo = [
            'ativas'    => Assinatura::ativas()->count(),
            'pendentes' => Assinatura::pendentes()->count(),
            'a_vencer'  => Assinatura::ativas()
                ->where('data_fim', '<=', now()->addDays(7)->toDateString())
                ->count(),
        ];

        return view('assinaturas.index', compact('assinaturas', 'planos', 'resumo'));
    }

    // ── CREATE ────────────────────────────────────────────────────────────────

    public function create(Request $request): View
    {
        $planos   = Plano::ativos()->get();
        $clientes = Cliente::ativos()->get();
        $clienteSeleccionado = $request->query('cliente_id');

        return view('assinaturas.create', compact('planos', 'clientes', 'clienteSeleccionado'));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────

    public function store(StoreAssinaturaRequest $request): RedirectResponse
    {
        $cliente = Cliente::findOrFail($request->cliente_id);
        $plano   = Plano::findOrFail($request->plano_id);

        abort_if(!$plano->ativo, 422, 'Este plano não está disponível.');

        return DB::transaction(function () use ($request, $cliente, $plano) {

            // Cancelar assinatura activa anterior
            $ativa = $cliente->assinaturas()->ativas()->first();
            $ativa?->cancelar('Substituída por nova assinatura');

            // Criar assinatura com os atributos do enunciado
            $assinatura = Assinatura::create([
                'data_inicio'          => $request->data_inicio,
                'data_fim'             => $request->data_fim,
                'valor'                => $request->valor,
                'cliente_id'           => $cliente->id,
                'plano_id'             => $plano->id,
                'status'               => 'pendente',
                'renovacao_automatica' => $request->boolean('renovacao_automatica', true),
            ]);

            // Criar pagamento inicial com os atributos do enunciado
            Pagamento::create([
                'data_pagamento' => now()->toDateString(),
                'valor'          => $assinatura->valor,
                'assinatura_id'  => $assinatura->id,
                'cliente_id'     => $cliente->id,
                'metodo'         => $request->metodo_pagamento,
                'status'         => 'pendente',
            ]);

            return redirect()
                ->route('assinaturas.show', $assinatura)
                ->with('success', 'Assinatura criada! Efectue o pagamento para activar.');
        });
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(Assinatura $assinatura): View
    {
        $assinatura->load(['cliente', 'plano', 'pagamentos' => fn($q) => $q->latest()]);

        return view('assinaturas.show', compact('assinatura'));
    }

    // ── EDIT ──────────────────────────────────────────────────────────────────

    public function edit(Assinatura $assinatura): View
    {
        $planos = Plano::ativos()->get();

        return view('assinaturas.edit', compact('assinatura', 'planos'));
    }

    // ── UPDATE ────────────────────────────────────────────────────────────────

    public function update(Request $request, Assinatura $assinatura): RedirectResponse
    {
        $request->validate([
            'data_inicio'          => ['required', 'date'],
            'data_fim'             => ['required', 'date', 'after:data_inicio'],
            'valor'                => ['required', 'numeric', 'min:0'],
            'status'               => ['required', 'in:pendente,ativa,cancelada,expirada'],
            'renovacao_automatica' => ['boolean'],
        ]);

        $assinatura->update($request->only([
            'data_inicio', 'data_fim', 'valor', 'status', 'renovacao_automatica',
        ]));

        return redirect()
            ->route('assinaturas.show', $assinatura)
            ->with('success', 'Assinatura actualizada com sucesso.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(Assinatura $assinatura): RedirectResponse
    {
        abort_if(
            $assinatura->status === 'ativa',
            422,
            'Cancele a assinatura antes de a remover.'
        );

        $assinatura->delete();

        return redirect()
            ->route('assinaturas.index')
            ->with('success', 'Assinatura removida com sucesso.');
    }

    // ── ACÇÕES EXTRA ──────────────────────────────────────────────────────────

    /**
     * Cancelar assinatura.
     */
    public function cancelar(Request $request, Assinatura $assinatura): RedirectResponse
    {
        $request->validate([
            'motivo' => ['nullable', 'string', 'max:500'],
        ]);

        abort_if(
            !in_array($assinatura->status, ['ativa', 'pendente']),
            422,
            'Esta assinatura não pode ser cancelada.'
        );

        $assinatura->cancelar($request->motivo);

        return redirect()
            ->route('assinaturas.show', $assinatura)
            ->with('success', 'Assinatura cancelada com sucesso.');
    }

    /**
     * Renovar assinatura manualmente.
     */
    public function renovar(Assinatura $assinatura): RedirectResponse
    {
        abort_unless(auth()->user()->is_admin, 403);

        $novaInicio = $assinatura->data_fim->addDay();
        $novaFim    = $novaInicio->copy()->addDays(
            $assinatura->data_inicio->diffInDays($assinatura->data_fim)
        );

        $nova = DB::transaction(function () use ($assinatura, $novaInicio, $novaFim) {
            $assinatura->update(['status' => 'expirada']);

            $nova = Assinatura::create([
                'data_inicio'          => $novaInicio->toDateString(),
                'data_fim'             => $novaFim->toDateString(),
                'valor'                => $assinatura->valor,
                'cliente_id'           => $assinatura->cliente_id,
                'plano_id'             => $assinatura->plano_id,
                'status'               => 'pendente',
                'renovacao_automatica' => $assinatura->renovacao_automatica,
            ]);

            Pagamento::create([
                'data_pagamento' => now()->toDateString(),
                'valor'          => $nova->valor,
                'assinatura_id'  => $nova->id,
                'cliente_id'     => $nova->cliente_id,
                'metodo'         => $assinatura->pagamentos()->latest()->first()?->metodo ?? 'outro',
                'status'         => 'pendente',
            ]);

            return $nova;
        });

        return redirect()
            ->route('assinaturas.show', $nova)
            ->with('success', 'Assinatura renovada. Aguarda pagamento.');
    }
}
