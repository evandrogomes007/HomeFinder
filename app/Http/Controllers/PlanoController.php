<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlanoController extends Controller
{
    public function __construct()
    {
        // Listagem e detalhe são públicos; gestão só para admin
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('admin')->only('create', 'store', 'edit', 'update', 'destroy');
    }

    public function index(): View
    {
        $planos = Plano::ativos()->withCount('assinaturasAtivas')->get();

        return view('planos.index', compact('planos'));
    }

    public function show(Plano $plano): View
    {
        $plano->loadCount('assinaturasAtivas');

        return view('planos.show', compact('plano'));
    }

    public function create(): View
    {
        return view('planos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome'           => ['required', 'string', 'max:100'],
            'descricao'      => ['nullable', 'string'],
            'preco'          => ['required', 'numeric', 'min:0'],
            'duracao_dias'   => ['required', 'integer', 'min:1'],
            'limite_imoveis' => ['required', 'integer', 'min:0'],
            'ativo'          => ['boolean'],
            'ordem'          => ['integer', 'min:0'],
        ]);

        $dados['slug'] = Str::slug($dados['nome']);

        Plano::create($dados);

        return redirect()->route('planos.index')->with('success', 'Plano criado.');
    }

    public function edit(Plano $plano): View
    {
        return view('planos.edit', compact('plano'));
    }

    public function update(Request $request, Plano $plano): RedirectResponse
    {
        $dados = $request->validate([
            'nome'           => ['required', 'string', 'max:100'],
            'descricao'      => ['nullable', 'string'],
            'preco'          => ['required', 'numeric', 'min:0'],
            'duracao_dias'   => ['required', 'integer', 'min:1'],
            'limite_imoveis' => ['required', 'integer', 'min:0'],
            'ativo'          => ['boolean'],
            'ordem'          => ['integer', 'min:0'],
        ]);

        $plano->update($dados);

        return redirect()->route('planos.index')->with('success', 'Plano actualizado.');
    }

    public function destroy(Plano $plano): RedirectResponse
    {
        abort_if(
            $plano->assinaturasAtivas()->exists(),
            422,
            'Não é possível remover um plano com assinaturas activas.'
        );

        $plano->delete();

        return redirect()->route('planos.index')->with('success', 'Plano removido.');
    }
}
