@extends('homefinder')

@section('title', $imovel->titulo)

@section('head')
<style>
    .publish-wrap {
        background: var(--gray-100);
        min-height: calc(100vh - 68px);
        padding: 48px 16px 80px;
    }
    .publish-header {
        max-width: 760px;
        margin: 0 auto 32px;
        text-align: center;
    }
    .section-block {
        background: var(--charcoal);
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        padding: 30px 32px;
        margin-bottom: 18px;
    }
    .section-block-title {
        font-family: var(--font-h);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .price {
        color: var(--brand);
    }
    
    .input-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }
    .publish-actions {
        max-width: 760px;
        margin: 0 auto;
        display: flex;
        gap: 12px;
    }
    .publish-actions .btn { margin-top: 0; }
    @media (max-width: 600px) {
        .input-row-3 { grid-template-columns: 1fr; }
        .section-block { padding: 22px 18px; }
        .publish-actions { flex-direction: column; }
    }
</style>
@endsection

@section('content')
<div class="container publish-wrap" style="max-width:1000px;margin:40px auto;">
    <div class="publish-header">
        <h1 style="font-family:var(--font-h); font-size:1.9rem; font-weight:900; color:var(--charcoal); margin-bottom:8px;">
            {{ $imovel->titulo }}
        </h1>

        <h2 class="price">{{ number_format($imovel->preco, 2, ',', '.') }} Kz</h2>

        <p style="color:var(--gray-600);">
            {{ $imovel->descricao }}
        </p>

        <ul style="color:var(--gray-600); font-size:.88rem;">
            <li>Localização: {{ $imovel->localizacao }}</li>
            <li>Tipo: {{ $imovel->tipo }}</li>
            <li>Quartos: {{ $imovel->quartos }}</li>
            <li>Banheiros: {{ $imovel->banheiros }}</li>
            <li>Área: {{ $imovel->area_m2 }} m²</li>
        </ul>
    </div>

    <hr><br>

    @if(!empty($imovel->imagens))
        @foreach ($imovel->imagens as $imagem)
            <img src="{{ asset('storage/'.$imagem) }}"
             style="width:100%;max-height:500px;object-fit:cover;">
             <br>
             <hr>
        @endforeach
    @endif

    @auth
        @if(auth()->id() === $imovel->cliente_id)
            <a href="{{ route('imoveis.edit', $imovel) }}" class="btn">
                Editar imóvel
            </a>
        @endif
    @endauth
</div>
@endsection
