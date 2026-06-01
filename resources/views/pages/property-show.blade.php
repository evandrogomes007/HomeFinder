@extends('homefinder')

@section('title', $imovel->titulo)

@section('head')
<style>
    .property-wrap {
        background: var(--gray-100);
        min-height: calc(100vh - 68px);
        padding: 40px 16px 80px;
    }
    .property-header {
        max-width: 1100px;
        margin: 0 auto 40px;
        text-align: center;
    }
    .property-title {
        font-family: var(--font-h);
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--charcoal);
        margin-bottom: 8px;
        line-height: 1.1;
    }
    .property-price {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--brand);
        margin-bottom: 16px;
    }
    .property-meta {
        font-size: .95rem;
        color: var(--gray-600);
        display: flex;
        justify-content: center;
        gap: 24px;
        flex-wrap: wrap;
    }

    .property-content {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 40px;
    }

    .property-gallery {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-xs);
    }
    .main-image {
        width: 100%;
        height: 520px;
        object-fit: cover;
    }
    .gallery-thumbs {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
        padding: 8px;
    }
    .thumb {
        height: 90px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        opacity: 0.85;
        transition: all .2s;
    }
    .thumb:hover {
        opacity: 1;
        transform: scale(1.03);
    }

    .property-info {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-xs);
        padding: 32px;
        height: fit-content;
        position: sticky;
        top: 90px;
    }
    .section-title {
        font-family: var(--font-h);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--charcoal);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--gray-200);
    }

    .details-list {
        list-style: none;
        padding: 0;
        margin: 0 0 28px 0;
    }
    .details-list li {
        padding: 12px 0;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        font-size: 1rem;
    }
    .details-list li:last-child {
        border-bottom: none;
    }
    .details-list strong {
        color: var(--gray-700);
    }

    .btn-interesse {
        width: 100%;
        padding: 16px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: var(--radius);
        margin-top: 12px;
    }

    @media (max-width: 992px) {
        .property-content {
            grid-template-columns: 1fr;
            gap: 32px;
        }
        .main-image {
            height: 420px;
        }
    }
</style>
@endsection

@section('content')
<div class="property-wrap">
    <div class="property-header">
        <h1 class="property-title">{{ $imovel->titulo }}</h1>
        <p class="property-price">{{ number_format($imovel->preco, 0, ',', '.') }} Kz</p>
        <hr>
    </div>

    <div class="property-content">
        
        <!-- Galeria -->
        <div class="property-gallery">
            @if(!empty($imovel->imagens) && count($imovel->imagens) > 0)
                <img id="main-image" 
                     src="{{ asset('storage/'.$imovel->imagens[0]) }}" 
                     class="main-image" 
                     alt="{{ $imovel->titulo }}">

                @if(count($imovel->imagens) > 1)
                    <div class="gallery-thumbs">
                        @foreach($imovel->imagens as $index => $imagem)
                            <img src="{{ asset('storage/'.$imagem) }}" 
                                 class="thumb" 
                                 onclick="changeImage(this)"
                                 alt="Imagem {{ $index + 1 }}">
                        @endforeach
                    </div>
                @endif
            @else
                <div style="height: 520px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; color: var(--gray-400); font-size: 1.1rem;">
                    Sem imagens disponíveis
                </div>
            @endif
        </div>

        <!-- Informações Laterais -->
        <div class="property-info">
            <h3 class="section-title">Detalhes do Imóvel</h3>
            
            <ul class="details-list">
                <li><strong>Tipo</strong> <span>{{ ucfirst($imovel->tipo ?? '—') }}</span></li>
                <li><strong>Localização</strong> <span>{{ $imovel->localizacao }}</span></li>
                @if($imovel->quartos)
                    <li><strong>Quartos</strong> <span>{{ $imovel->quartos }}</span></li>
                @endif
                @if($imovel->banheiros)
                    <li><strong>Banheiros</strong> <span>{{ $imovel->banheiros }}</span></li>
                @endif
                @if($imovel->area_m2)
                    <li><strong>Área</strong> <span>{{ $imovel->area_m2 }} m²</span></li>
                @endif
                @if($imovel->created_at)
                    <li><strong>Publicado</strong> <span>{{ $imovel->created_at->diffForHumans() }}</span></li>
                @endif
                @if($imovel->cliente)
                    <li><strong>Por</strong> <span>{{ $imovel->cliente->primeiro_nome.' '.$imovel->cliente->ultimo_nome ?? 'Vendedor' }}</span></li>
                @endif
            </ul>

            <div style="margin-top: 32px;">
                @auth
                    @if(auth()->id() === $imovel->cliente_id)
                        <a href="{{ route('imoveis.edit', $imovel) }}" class="btn" style="width:100%; text-align:center;">
                            Editar Imóvel
                        </a>
                    @else
                        <a href="{{ route('conversas.imovel', $imovel) }}" class="btn btn-brand btn-interesse">
                            Enviar Mensagem
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-brand btn-interesse">
                        Entrar para enviar mensagem
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Descrição -->
    @if($imovel->descricao)
        <div style="max-width: 1100px; margin: 50px auto 0; background: var(--white); border-radius: var(--radius); padding: 40px;">
            <h3 class="section-title">Descrição</h3>
            <p style="line-height: 1.8; color: var(--gray-700); font-size: 1.02rem;">
                {{ $imovel->descricao }}
            </p>
        </div>
    @endif
</div>

<script>
    function changeImage(thumb) {
        document.getElementById('main-image').src = thumb.src;
    }
</script>
@endsection
