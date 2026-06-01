@extends('homefinder')

@section('title', 'Conversa — HomeFinder')

@section('head')
<style>
    .chat-wrap {
        background: var(--gray-100);
        min-height: calc(100vh - 68px);
        padding: 32px 16px;
    }
    .chat-box {
        max-width: 860px;
        margin: 0 auto;
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 85vh;
    }
    .chat-header {
        padding: 20px 28px;
        border-bottom: 1px solid var(--gray-200);
        background: var(--gray-900);
        color: white;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .chat-header h2 {
        color:var(--charcoal);
    }
    .chat-header p {
        color:var(--gray-600);
    }
    .chat-header a{
        color:var(--charcoal);
    }
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 28px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .message {
        max-width: 75%;
        padding: 14px 20px;
        border-radius: 18px;
        line-height: 1.5;
    }
    .message.sent {
        align-self: flex-end;
        background: var(--brand);
        color: white;
        border-bottom-right-radius: 4px;
    }
    .message.received {
        align-self: flex-start;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-bottom-left-radius: 4px;
    }
    .message-time {
        font-size: 0.72rem;
        opacity: 0.75;
        margin-top: 6px;
        text-align: right;
    }
</style>
@endsection

@section('content')
<div class="chat-wrap">
    <div class="chat-box">
        <!-- Header -->
        <div class="chat-header">
            <a href="{{ route('conversas.index') }}" style="color: white; font-size: 1.4rem; text-decoration: none;">←</a>
            <div style="flex: 1;">
                <h2 style="margin: 0; font-size: 1.25rem;">{{ $conversa->imovel->titulo ?? 'Conversa' }}</h2>
                <p style="margin: 4px 0 0; font-size: .9rem; opacity: 0.85;">
                    @if($conversa->vendedor_id === auth()->id())
                        Cliente: {{ $conversa->cliente->primeiro_nome.' '.$conversa->cliente->ultimo_nome ?? '' }}
                    @else
                        Vendedor: {{ $conversa->vendedor->primeiro_nome.' '.$conversa->vendedor->ultimo_nome ?? '' }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Mensagens -->
        <div id="chat-messages" class="chat-messages">
            @foreach($mensagens as $mensagem)
                <div style="display: flex; {{ $mensagem->remetente_id === auth()->id() ? 'justify-content: flex-end;' : 'justify-content: flex-start;' }}">
                    <div class="message {{ $mensagem->remetente_id === auth()->id() ? 'sent' : 'received' }}">
                        <p style="margin: 0;">{{ $mensagem->mensagem }}</p>
                        <p class="message-time">
                            {{ $mensagem->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Formulário de envio -->
        <form action="{{ route('conversas.mensagens.store', $conversa) }}" 
              method="POST" 
              style="padding: 20px; border-top: 1px solid var(--gray-200); background: var(--white);">
            @csrf
            <div style="display: flex; gap: 12px;">
                <input type="text" 
                       name="mensagem" 
                       id="mensagem-input"
                       placeholder="Digite sua mensagem..." 
                       style="flex: 1; border: 1px solid var(--gray-300); border-radius: 9999px; padding: 14px 24px; font-size: 1rem;"
                       required>
                <button type="submit"
                        style="background: var(--brand); color: white; border: none; padding: 0 32px; border-radius: 9999px; font-weight: 600; cursor: pointer;">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Scroll automático para o final
    document.addEventListener('DOMContentLoaded', function() {
        const chat = document.getElementById('chat-messages');
        if (chat) chat.scrollTop = chat.scrollHeight;
    });
</script>
@endsection