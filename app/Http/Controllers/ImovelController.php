<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImovelRequest;
use App\Http\Requests\UpdateImovelRequest;
use App\Models\Imovel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ImovelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Formulário de publicação
    public function create()
    {
        return view('pages.seller-dashboard', [
            'modoEdicao' => false
        ]);
    }

    // Salvar imóvel + imagens
    public function store(StoreImovelRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['cliente_id'] = Auth::id();
        $data['status']     = 'disponivel';
        $data['ativo']      = true;

        // Upload de múltiplas imagens
        $imagensPaths = [];

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                if ($imagem->isValid()) {
                    $path = $imagem->store('imoveis', 'public');
                    $imagensPaths[] = $path;
                }
            }
        }

        $data['imagens'] = $imagensPaths;

        Imovel::create($data);

        return redirect()
            ->route('HomeFinder')
            ->with('success', 'Imóvel publicado com sucesso! Já está visível no feed.');
    }

    public function show(Imovel $imovel)
    {
        return view('pages.property-show', compact('imovel'));
    }

    public function edit(Imovel $imovel)
    {
        if ($imovel->cliente_id !== Auth::id()) {
            abort(403);
        }

        return view('pages.seller-dashboard', [
            'imovel' => $imovel,
            'modoEdicao' => true
        ]);
    }

    public function update(UpdateImovelRequest $request, Imovel $imovel)
    {
        if ($imovel->cliente_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();

        $imovel->update($data);

        return redirect()
            ->route('imoveis.show', $imovel)
            ->with('success', 'Imóvel atualizado com sucesso.');
    }


    public function meusImoveis()
    {
        $imoveis = Imovel::where('cliente_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pages.my-properties', compact('imoveis'));
    }

    /**
     * Excluir Imóvel
     */
    public function destroy(Imovel $imovel)
    {
        // Verifica se o imóvel pertence ao usuário logado
        if ($imovel->cliente_id !== Auth::id()) {
            abort(403, 'Não autorizado.');
        }

        // Deletar imagens do storage
        if (!empty($imovel->imagens)) {
            foreach ($imovel->imagens as $imagem) {
                Storage::disk('public')->delete($imagem);
            }
        }

        $imovel->delete();

        return redirect()
            ->route('imoveis.meu')
            ->with('success', 'Imóvel excluído com sucesso!');
    }
}
