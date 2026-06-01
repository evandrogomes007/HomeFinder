@extends('homefinder')

@section('title', 'Conversa — HomeFinder')

@section('head')
<style>
    .chat-container {
        background: var(--gray-100);
        min-height: calc(100vh - 68px);
        padding: 32px 16px;
    }
    .chat-box {
        max-width: 860px;
        margin: 0 auto;
        background: white;
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
        background: white;
        border: 1px solid var(--gray-200);
        border-bottom-left-radius: 4px;
    }
    .message-time {
        font-size: 0.72rem;
        opacity: 0.8;
        margin-top: 6px;
    }
    .chat-header{
        color: var(--gray-600);
    }
    .flex-1 h2{
        color:var(--charcoal);
    }
</style>
@endsection

@section('content')
<div class="chat-container">
    <div class="chat-box">
        <!-- Header -->
        <div class="chat-header flex items-center gap-4">
            <a href="{{ route('conversas.index') }}">Voltar</a>
            <div class="flex-1">
                <h2 class="font-semibold text-lg">{{ $conversa->imovel->titulo ?? 'Conversa' }}</h2>
                <p class="text-sm opacity-75">
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
                <div class="flex {{ $mensagem->remetente_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="message {{ $mensagem->remetente_id === auth()->id() ? 'sent' : 'received' }}">
                        <p>{{ $mensagem->mensagem }}</p>
                        <p class="message-time">
                            {{ $mensagem->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Formulário -->
        <form action="{{ route('conversas.mensagens.store', $conversa) }}" 
              method="POST" 
              class="p-6 border-t bg-white">
            @csrf
            <div class="flex gap-3">
                <input type="text" 
                       name="mensagem" 
                       id="mensagem-input"
                       placeholder="Digite sua mensagem..." 
                       class="flex-1 border border-gray-300 rounded-2xl px-6 py-4 focus:outline-none focus:border-brand"
                       autocomplete="off"
                       required>
                <button type="submit"
                        class="bg-brand hover:bg-brand/90 text-white px-10 rounded-2xl font-semibold transition">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Scroll automático para o final
    document.addEventListener('DOMContentLoaded', () => {
        const chat = document.getElementById('chat-messages');
        chat.scrollTop = chat.scrollHeight;
    });
</script>
@endsection