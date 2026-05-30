<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\Imovel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create', 'store', 'index']);
    }

    // ── Feed público de imóveis ───────────────────────────────────────────────
    public function index(Request $request): View
    {
        $imoveis = Imovel::with('cliente')
            ->ativos()
            ->when($request->filled('busca'), function ($q) use ($request) {
                $busca = $request->busca;
                $q->where(function ($q2) use ($busca) {
                    $q2->where('titulo', 'like', "%{$busca}%")
                       ->orWhere('descricao', 'like', "%{$busca}%")
                       ->orWhere('localizacao', 'like', "%{$busca}%")
                       ->orWhere('tipo', 'like', "%{$busca}%");
                });
            })
            ->when($request->filled('tipo'), fn ($q) => $q->where('tipo', $request->tipo))
            ->latest()
            ->paginate(12);

        return view('pages.feed', [
        'imoveis' => $imoveis,
        'currentImoveis' => $imoveis->items()
    ]   );
    }

    // ── Formulário de registo ─────────────────────────────────────────────────
    public function create(): View
    {
        return view('pages.client-register');
    }

    // ── Criar cliente ─────────────────────────────────────────────────────────
    public function store(StoreClienteRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $nomeCompleto = trim($data['nome']);
        $partes = explode(' ', $nomeCompleto, 2);

        $data['primeiro_nome'] = $partes[0];
        $data['ultimo_nome']   = $partes[1] ?? $partes[0];

        unset($data['nome'], $data['password_confirmation']);

        $data['password'] = bcrypt($data['password']);

        Cliente::create($data);

        return redirect()
            ->route('login')
            ->with('success', 'Conta criada com sucesso! Faça login para continuar.');
    }

    // ── Perfil ────────────────────────────────────────────────────────────────
    public function show(Cliente $cliente): View
    {
        $cliente->load([
            'assinaturas.plano',
            'pagamentos' => fn ($q) => $q->latest()->limit(5),
            'imoveis'    => fn ($q) => $q->latest()->limit(6),
        ]);

        return view('pages.perfil', compact('cliente'));
    }

    // ── Editar ────────────────────────────────────────────────────────────────
    public function edit(Cliente $cliente): View
    {
        abort_unless(Auth::id() === $cliente->id, 403);
        return view('pages.cliente-edit', compact('cliente'));
    }

    // ── Actualizar ────────────────────────────────────────────────────────────
    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        abort_unless(Auth::id() === $cliente->id, 403);
        $cliente->update($request->validated());

        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Dados actualizados com sucesso.');
    }

    // ── Remover ───────────────────────────────────────────────────────────────
    public function destroy(Cliente $cliente): RedirectResponse
    {
        abort_unless(Auth::id() === $cliente->id, 403);
        abort_if(
            $cliente->tem_assinatura_ativa,
            422,
            'Não é possível remover uma conta com assinatura activa.'
        );

        Auth::logout();
        $cliente->delete();

        return redirect()->route('HomeFinder')
            ->with('success', 'Conta removida com sucesso.');
    }
}
