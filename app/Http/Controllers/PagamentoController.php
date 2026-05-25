<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagamentoRequest;
use App\Models\Pagamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PagamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $pagamentos = Pagamento::query()
            ->when($request->filled('status'), fn($q) =>
                $q->where('status', $request->status)
            )
            ->when($request->filled('metodo'), fn($q) =>
                $q->where('metodo', $request->metodo)
            )
            ->when($request->filled('cliente_id'), fn($q) =>
                $q->where('cliente_id', $request->cliente_id)
            )
            ->when($request->filled('data_inicio'), fn($q) =>
                $q->where('data_pagamento', '>=', $request->data_inicio)
            )
            ->when($request->filled('data_fim'), fn($q) =>
                $q->where('data_pagamento', '<=', $request->data_fim)
            )
            ->with(['cliente', 'assinatura.plano', 'aprovadoPor'])
            ->latest('data_pagamento')
            ->paginate(15)
            ->withQueryString();

        $totais = [
            'pendentes_count' => Pagamento::pendentes()->count(),
            'aprovados_mes'   => Pagamento::aprovados()->doMes()->sum('valor'),
            'total_mes'       => Pagamento::aprovados()->doMes()->count(),
        ];

        return view('pagamentos.index', compact('pagamentos', 'totais'));
    }

    // ── CREATE ────────────────────────────────────────────────────────────────

    public function create(Request $request): View
    {
        // Pré-seleccionar assinatura via query string
        $assinaturaId = $request->query('assinatura_id');

        return view('pagamentos.create', compact('assinaturaId'));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────

    public function store(StorePagamentoRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        // Processar comprovativo, se enviado
        if ($request->hasFile('comprovativo')) {
            $dados['comprovativo'] = $request->file('comprovativo')
                ->store("comprovativos/{$request->assinatura_id}", 'private');
        }

        $dados['cliente_id'] = \App\Models\Assinatura::findOrFail($request->assinatura_id)->cliente_id;
        $dados['status']     = 'pendente';

        $pagamento = Pagamento::create($dados);

        return redirect()
            ->route('pagamentos.show', $pagamento)
            ->with('success', "Pagamento registado com referência {$pagamento->referencia}.");
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(Pagamento $pagamento): View
    {
        $pagamento->load(['cliente', 'assinatura.plano', 'aprovadoPor']);

        return view('pagamentos.show', compact('pagamento'));
    }

    // ── EDIT ──────────────────────────────────────────────────────────────────

    public function edit(Pagamento $pagamento): View
    {
        abort_if(
            $pagamento->status === 'aprovado',
            403,
            'Pagamentos aprovados não podem ser editados.'
        );

        return view('pagamentos.edit', compact('pagamento'));
    }

    // ── UPDATE ────────────────────────────────────────────────────────────────

    public function update(Request $request, Pagamento $pagamento): RedirectResponse
    {
        abort_if(
            $pagamento->status === 'aprovado',
            403,
            'Pagamentos aprovados não podem ser editados.'
        );

        $request->validate([
            'data_pagamento' => ['required', 'date'],
            'valor'          => ['required', 'numeric', 'min:0.01'],
            'metodo'         => ['required', 'in:transferencia_bancaria,multicaixa_express,internet_banking,cartao_credito,cartao_debito,outro'],
            'comprovativo'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'observacoes'    => ['nullable', 'string', 'max:500'],
        ]);

        $dados = $request->only(['data_pagamento', 'valor', 'metodo', 'observacoes']);

        if ($request->hasFile('comprovativo')) {
            // Apagar comprovativo antigo
            if ($pagamento->comprovativo) {
                Storage::disk('private')->delete($pagamento->comprovativo);
            }
            $dados['comprovativo'] = $request->file('comprovativo')
                ->store("comprovativos/{$pagamento->assinatura_id}", 'private');
        }

        $pagamento->update($dados);

        return redirect()
            ->route('pagamentos.show', $pagamento)
            ->with('success', 'Pagamento actualizado com sucesso.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(Pagamento $pagamento): RedirectResponse
    {
        abort_unless(auth()->user()->is_admin, 403);

        abort_if(
            $pagamento->status === 'aprovado',
            422,
            'Não é possível remover um pagamento aprovado.'
        );

        if ($pagamento->comprovativo) {
            Storage::disk('private')->delete($pagamento->comprovativo);
        }

        $pagamento->delete();

        return redirect()
            ->route('pagamentos.index')
            ->with('success', 'Pagamento removido com sucesso.');
    }

    // ── ACÇÕES EXTRA ──────────────────────────────────────────────────────────

    /**
     * Aprovar pagamento e activar assinatura (admin).
     */
    public function aprovar(Pagamento $pagamento): RedirectResponse
    {
        abort_unless(auth()->user()->is_admin, 403);

        abort_if(
            !in_array($pagamento->status, ['pendente']),
            422,
            'Este pagamento não pode ser aprovado.'
        );

        $pagamento->aprovar(auth()->id());

        return redirect()
            ->route('pagamentos.show', $pagamento)
            ->with('success', 'Pagamento aprovado. Assinatura activada com sucesso.');
    }

    /**
     * Recusar pagamento (admin).
     */
    public function recusar(Request $request, Pagamento $pagamento): RedirectResponse
    {
        abort_unless(auth()->user()->is_admin, 403);

        $request->validate([
            'motivo' => ['required', 'string', 'max:500'],
        ]);

        $pagamento->recusar($request->motivo);

        return redirect()
            ->route('pagamentos.show', $pagamento)
            ->with('success', 'Pagamento recusado.');
    }

    /**
     * Download do comprovativo (admin ou dono).
     */
    public function comprovativo(Pagamento $pagamento)
    {
        abort_if(!$pagamento->comprovativo, 404, 'Comprovativo não encontrado.');

        $extensao = pathinfo($pagamento->comprovativo, PATHINFO_EXTENSION);

        return Storage::disk('private')->download(
            $pagamento->comprovativo,
            "comprovativo-{$pagamento->referencia}.{$extensao}"
        );
    }

    /**
     * Relatório financeiro (admin).
     */
    public function relatorio(Request $request): View
    {
        abort_unless(auth()->user()->is_admin, 403);

        $request->validate([
            'data_inicio' => ['nullable', 'date'],
            'data_fim'    => ['nullable', 'date', 'after_or_equal:data_inicio'],
        ]);

        $inicio = $request->date('data_inicio', now()->startOfMonth());
        $fim    = $request->date('data_fim', now()->endOfMonth());

        $pagamentos = Pagamento::aprovados()
            ->whereBetween('data_pagamento', [$inicio->toDateString(), $fim->toDateString()])
            ->with(['cliente', 'assinatura.plano'])
            ->get();

        $relatorio = [
            'total_arrecadado' => $pagamentos->sum('valor'),
            'total_pagamentos' => $pagamentos->count(),
            'por_metodo'       => $pagamentos->groupBy('metodo')->map->count(),
            'por_plano'        => $pagamentos->groupBy('assinatura.plano.nome')->map->sum('valor'),
            'pagamentos'       => $pagamentos,
        ];

        return view('pagamentos.relatorio', compact('relatorio', 'inicio', 'fim'));
    }
}
