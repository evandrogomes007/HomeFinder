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
        margin-bottom: 20px;
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

    .notification-badge {
        background: #ef4444;
        color: white;
        font-size: .68rem;
        padding: 2px 9px;
        border-radius: 9999px;
        font-weight: 600;
    }

    .grid-conversas {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 22px;
    }

    @media (max-width: 640px) {
        .grid-conversas {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="conversas-wrap">

    <div class="conversas-header">
        <span class="card-eyebrow" style="display:block; margin-bottom:6px;">Painel de Mensagens</span>
        <h1 style="font-family:var(--font-h); font-size:1.9rem; font-weight:900; color:var(--charcoal); margin-bottom:8px;">
            Minhas Conversas
        </h1>
        <p style="font-size:.88rem; color:var(--gray-600);">
            Gerencie todas as suas conversas com clientes e vendedores
        </p>
    </div>

    <div style="max-width: 1160px; margin: 0 auto; padding: 0 20px;">
        @if($conversas->isEmpty())
            <div style="background: var(--white); border-radius: var(--radius); padding: 90px 24px; text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 50%; margin: 0 auto 24px; display: flex; align-items: center; justify-content: center; font-size: 36px;">
                    💬
                </div>
                <h3 style="font-family:var(--font-h); font-size:1.5rem; margin-bottom:12px;">Nenhuma conversa ainda</h3>
                <p style="color: var(--gray-600); max-width: 420px; margin: 0 auto 28px;">
                    Quando você demonstrar interesse em um imóvel ou um cliente entrar em contato, as conversas aparecerão aqui.
                </p>
                <a href="{{ route('home') }}" class="btn btn-brand">Explorar Imóveis</a>
            </div>
        @else
            <div class="grid-conversas">
                @foreach($conversas as $conversa)
                    <a href="{{ route('conversas.show', $conversa) }}" class="conversa-card">
                        <div class="conversa-header">
                            <div style="flex: 1; min-width: 0;">
                                <h3 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 4px;">
                                    {{ $conversa->imovel->titulo ?? 'Imóvel sem título' }}
                                </h3>
                                <p style="font-size: .85rem; color: var(--gray-600);">
                                    @if($conversa->vendedor_id === auth()->id())
                                        Cliente: {{ $conversa->cliente->primeiro_nome.' '.$conversa->cliente->ultimo_nome ?? '' }}
                                    @else
                                        Vendedor: {{ $conversa->vendedor->primeiro_nome.' '.$conversa->vendedor->ultimo_nome ?? '' }}
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
                                <p style="color: var(--gray-400); font-style: italic;">Iniciar conversa...</p>
                            @endif
                        </div>

                        <div class="conversa-footer">
                            <span>
                                {{ $conversa->mensagens->first()?->created_at->diffForHumans() ?? 'Nova' }}
                            </span>
                            
                            @php
                                $naoLidas = $conversa->mensagens->where('lida', false)
                                    ->where('remetente_id', '!=', auth()->id())->count();
                            @endphp
                            @if($naoLidas > 0)
                                <span class="notification-badge">{{ $naoLidas }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection