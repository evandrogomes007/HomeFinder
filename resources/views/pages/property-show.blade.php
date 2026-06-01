@extends('homefinder')

@section('title', $imovel->titulo)

@section('head')
<style>
    .property-wrap {
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
        min-height: calc(100vh - 68px);
        padding: 40px 16px 80px;
    }

    .property-header {
        background:var(--charcoal);
        border-radius: 12px;
        padding: 40px 32px;
        margin-bottom: 32px;
        color: var(--white);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .property-title {
        font-family: var(--font-h);
        font-size: 2.2rem;
        font-weight: 900;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .property-price {
        font-size: 2rem;
        color: var(--white);
        font-weight: 800;
        margin-bottom: 20px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .property-description {
        font-size: 1.05rem;
        line-height: 1.6;
        color: #e0e0e0;
        margin-bottom: 28px;
    }

    .property-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    .feature-card {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 16px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-2px);
        border-color: rgba(255,255,255,0.3);
    }

    .feature-label {
        font-size: 0.85rem;
        color: #b0b0b0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .feature-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--white);
    }

    .gallery-container {
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        margin-bottom: 32px;
    }

    .gallery-main {
        position: relative;
        width: 100%;
        max-height: 600px;
        background: #f0f0f0;
        overflow: hidden;
    }

    .gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-thumbnails {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 8px;
        padding: 12px;
        background: #f9f9f9;
        border-top: 1px solid #e0e0e0;
    }

    .gallery-thumb {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }

    .gallery-thumb:hover {
        border-color: var(--brand);
    }

    .gallery-thumb.active {
        border-color: var(--brand);
        box-shadow: 0 0 8px rgba(var(--brand-rgb), 0.3);
    }

    .property-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        flex-wrap: wrap;
    }

    .property-actions .btn {
        margin-top: 0;
        padding: 14px 28px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        flex: 1;
        min-width: 160px;
    }

    .btn-edit {
        background: var(--brand);
        color: var(--white);
        border: none;
    }

    .btn-edit:hover {
        background: #e63900;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(230, 57, 0, 0.3);
    }

    .btn-interested {
        background: transparent;
        color: var(--brand);
        border: 2px solid var(--brand);
    }

    .btn-interested:hover {
        background: var(--brand);
        color: var(--white);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .property-title {
            font-size: 1.6rem;
        }

        .property-price {
            font-size: 1.5rem;
        }

        .property-header {
            padding: 28px 20px;
        }

        .property-features {
            grid-template-columns: repeat(2, 1fr);
        }

        .gallery-thumbnails {
            grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        }

        .gallery-thumb {
            height: 70px;
        }

        .property-actions {
            flex-direction: column;
        }

        .property-actions .btn {
            flex: none;
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .property-wrap {
            padding: 20px 12px 60px;
        }

        .property-title {
            font-size: 1.4rem;
        }

        .property-price {
            font-size: 1.3rem;
        }

        .property-description {
            font-size: 0.95rem;
        }

        .property-features {
            grid-template-columns: 1fr;
        }

        .gallery-main {
            max-height: 400px;
        }

        .gallery-thumbnails {
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            padding: 8px;
            gap: 6px;
        }

        .gallery-thumb {
            height: 60px;
        }
    }
</style>
@endsection

@section('content')
<div class="property-wrap">
    <div style="max-width: 1000px; margin: 0 auto;">
        <!-- Header Section -->
        <div class="property-header">
            <h1 class="property-title">{{ $imovel->titulo }}</h1>
            <div class="property-price">{{ number_format($imovel->preco, 2, ',', '.') }} Kz</div>
            <p class="property-description">{{ $imovel->descricao }}</p>

            <!-- Features Grid -->
            <div class="property-features">
                <div class="feature-card">
                    <div class="feature-label">Localização</div>
                    <div class="feature-value">{{ $imovel->localizacao }}</div>
                </div>
                <div class="feature-card">
                    <div class="feature-label">Tipo</div>
                    <div class="feature-value">{{ $imovel->tipo }}</div>
                </div>
                <div class="feature-card">
                    <div class="feature-label">Quartos</div>
                    <div class="feature-value">{{ $imovel->quartos }}</div>
                </div>
                <div class="feature-card">
                    <div class="feature-label">Banheiros</div>
                    <div class="feature-value">{{ $imovel->banheiros }}</div>
                </div>
                <div class="feature-card">
                    <div class="feature-label">Área</div>
                    <div class="feature-value">{{ $imovel->area_m2 }} m²</div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        @if(!empty($imovel->imagens))
            <div class="gallery-container">
                <div class="gallery-main">
                    <img id="mainImage" src="{{ asset('storage/'.$imovel->imagens[0]) }}" alt="{{ $imovel->titulo }}">
                </div>
                @if(count($imovel->imagens) > 1)
                    <div class="gallery-thumbnails">
                        @foreach ($imovel->imagens as $index => $imagem)
                            <img class="gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                                 src="{{ asset('storage/'.$imagem) }}"
                                 alt="Imagem {{ $index + 1 }}"
                                 onclick="document.getElementById('mainImage').src = this.src; document.querySelectorAll('.gallery-thumb').forEach(el => el.classList.remove('active')); this.classList.add('active');">
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- Actions Section -->
        <div class="property-actions">
            @auth
                @if(auth()->id() === $imovel->cliente_id)
                    <a href="{{ route('imoveis.edit', $imovel) }}" class="btn btn-edit">
                        Editar Imóvel
                    </a>
                @else
                    <a href="#" class="btn btn-interested">
                        Estou Interessado
                    </a>
                @endif
            @endauth
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
        thumb.addEventListener('click', function() {
            document.getElementById('mainImage').src = this.src;
            document.querySelectorAll('.gallery-thumb').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endsection
