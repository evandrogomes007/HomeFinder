<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImovelRequest;
use App\Models\Imovel;
use Illuminate\Http\RedirectResponse;
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
    public function create(): View
    {
        return view('pages.seller-dashboard');
    }

    // Salvar imóvel + imagens
    public function store(StoreImovelRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['cliente_id'] = Auth::id();
        $data['status']     = 'disponivel';
        $data['ativo']      = true;

        // Upload de múltiplas imagens
        if ($request->hasFile('imagens')) {
            $imagens = [];
            foreach ($request->file('imagens') as $imagem) {
                $path = $imagem->store('imoveis', 'public');
                $imagens[] = $path;
            }
            $data['imagens'] = $imagens;
        }

        Imovel::create($data);

        return redirect()
            ->route('HomeFinder')
            ->with('success', 'Imóvel publicado com sucesso! Já está visível no feed.');
    }
}
