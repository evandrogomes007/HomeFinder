@extends('homefinder')

@section('title', 'Minhas Conversas — HomeFinder')

@section('head')
<style>
    .conversas-wrap {
        background: var(--gray-100);
        min-height: calc(100vh - 68px);
        padding: 48px 16px 80px;
    }
    .conversas-header {
        max-width: 760px;
        margin: 0 auto 32px;
        text-align: center;
    }

    .conversa-card {
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        box-shadow: var(--shadow-xs);
        transition: all .22s ease;
        display: flex;
        flex-direction: column;
    }
    .conversa-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .conversa-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .conversa-body {
        padding: 20px 24px;
        flex: 1;
    }

    .conversa-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--gray-100);
        font-size: .78rem;
        color: var(--gray-500);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .last-message {
        font-size: .9rem;
        color: var(--gray-700);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .unread {
        background: var(--brand);
        color: white;
        font-size: .68rem;
        padding: 2px 8px;
        border-radius: 9999px;
    }
</style>
@endsection

@section('content')
<div class="conversas-wrap">

    <div class="conversas-header">
        <span class="card-eyebrow">Painel de Mensagens</span>
        <h1 style="font-family:var(--font-h); font-size:1.9rem; font-weight:900; color:var(--charcoal); margin-bottom:8px;">
            Minhas Conversas
        </h1>
        <p style="font-size:.88rem; color:var(--gray-600);">
            Gerencie todas as suas conversas com clientes e vendedores
        </p>
    </div>

    <div class="max-w-[1160px] mx-auto px-5">
        @if($conversas->isEmpty())
            <div class="bg-white rounded-2xl py-20 text-center">
                <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    💬
                </div>
                <h3 class="text-2xl font-semibold mb-3">Nenhuma conversa ainda</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Quando você demonstrar interesse em um imóvel ou um cliente entrar em contato, as conversas aparecerão aqui.
                </p>
                <a href="{{ route('home') }}" class="btn btn-brand">
                    Explorar Imóveis
                </a>
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach($conversas as $conversa)
                    <a href="{{ route('conversas.show', $conversa) }}" class="conversa-card">
                        <div class="conversa-header">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-lg truncate">
                                    {{ $conversa->imovel->titulo ?? 'Imóvel sem título' }}
                                </h3>
                                <p class="text-sm text-gray-600">
                                    @if($conversa->vendedor_id === auth()->id())
                                        Cliente: {{ $conversa->cliente->nome ?? 'Cliente' }}
                                    @else
                                        Vendedor: {{ $conversa->vendedor->nome ?? 'Vendedor' }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="conversa-body">
                            @if($conversa->mensagens->first())
                                <p class="last-message">
                                    {{ Str::limit($conversa->mensagens->first()->mensagem, 110) }}
                                </p>
                            @else
                                <p class="text-gray-400 italic">Iniciar conversa...</p>
                            @endif
                        </div>

                        <div class="conversa-footer">
                            <span>
                                {{ $conversa->mensagens->first()?->created_at->diffForHumans() ?? 'Nova' }}
                            </span>
                            @if($conversa->mensagens->where('lida', false)->where('remetente_id', '!=', auth()->id())->count() > 0)
                                <span class="unread">Nova</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection