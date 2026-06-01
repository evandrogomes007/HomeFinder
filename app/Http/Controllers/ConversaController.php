<?php

namespace App\Http\Controllers;

use App\Models\Conversa;
use App\Models\Mensagem;
use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ConversaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $conversas = Conversa::where('cliente_id', $user->id)
            ->orWhere('vendedor_id', $user->id)
            ->with([
                'mensagens' => function($q) {
                    $q->latest()->limit(1);
                },
                'imovel',
                'cliente',
                'vendedor'
            ])
            ->latest()
            ->get();

        // Contar mensagens não lidas
        $naoLidas = Mensagem::whereHas('conversa', function($q) use ($user) {
            $q->where('cliente_id', $user->id)->orWhere('vendedor_id', $user->id);
        })
        ->where('lida', false)
        ->where('remetente_id', '!=', $user->id)
        ->count();

        return view('pages.conversas', compact('conversas', 'naoLidas'));
    }

    public function showOrCreate(Imovel $imovel)
    {
        $cliente = Auth::user();

        $conversa = Conversa::firstOrCreate([
            'cliente_id' => $cliente->id,
            'imovel_id'  => $imovel->id,
        ], [
            'vendedor_id' => $imovel->user_id ?? $imovel->cliente_id, // ajuste conforme seu modelo
        ]);

        return redirect()->route('conversas.show', $conversa);
    }

    public function show(Conversa $conversa)
    {
        $user = Auth::user();

        if ($conversa->cliente_id !== $user->id && $conversa->vendedor_id !== $user->id) {
            abort(403);
        }

        // Marcar mensagens como lidas
        Mensagem::where('conversa_id', $conversa->id)
                ->where('remetente_id', '!=', $user->id)
                ->where('lida', false)
                ->update(['lida' => true]);

        $mensagens = $conversa->mensagens()->with('remetente')->orderBy('created_at')->get();

        return view('pages.conversa-show', compact('conversa', 'mensagens'));
    }

    public function store(Request $request, Conversa $conversa)
    {
        $user = Auth::user();

        if ($conversa->cliente_id !== $user->id && $conversa->vendedor_id !== $user->id) {
            abort(403);
        }

        $request->validate(['mensagem' => 'required|string|max:1000']);

        Mensagem::create([
            'conversa_id' => $conversa->id,
            'remetente_id' => $user->id,
            'mensagem' => $request->mensagem,
            'lida' => false,
        ]);

        return redirect()->route('conversas.show', $conversa)
                         ->with('success', 'Mensagem enviada!');
    }
}