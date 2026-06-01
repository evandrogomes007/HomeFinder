@extends('homefinder')

@section('title', request('busca') ? '"'.request('busca').'" — HomeFinder' : 'Imóveis em Angola — HomeFinder')

@section('head')
<style>
    /* ─── HERO ──────────────────────────────────────────── */
    .feed-hero {
        background: var(--charcoal);
        padding: 64px 24px 52px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .feed-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(217,65,30,.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--brand);
        background: rgba(217,65,30,.12);
        border: 1px solid rgba(217,65,30,.25);
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 18px;
    }
    .hero-eyebrow span { color: var(--accent); }
    .feed-hero h1 {
        font-family: var(--font-h);
        font-size: clamp(1.9rem, 5vw, 3rem);
        font-weight: 900;
        color: var(--white);
        margin-bottom: 12px;
        line-height: 1.15;
        position: relative;
    }
    .feed-hero p {
        font-size: .95rem;
        color: rgba(255,255,255,.45);
        margin-bottom: 32px;
        position: relative;
    }

    /* ─── SEARCH BAR ─────────────────────────────────────── */
    .search-bar {
        max-width: 580px;
        margin: 0 auto;
        display: flex;
        gap: 0;
        background: rgba(255,255,255,.07);
        border: 1.5px solid rgba(255,255,255,.12);
        border-radius: 50px;
        padding: 6px;
        backdrop-filter: blur(8px);
        position: relative;
    }
    .search-bar input {
        flex: 1;
        padding: 12px 20px;
        border-radius: 50px;
        border: none;
        background: transparent;
        color: var(--white);
        font-size: .92rem;
        font-family: var(--font-b);
        outline: none;
        box-shadow: none;
    }
    .search-bar input::placeholder { color: rgba(255,255,255,.32); }
    .search-bar input:focus { background: transparent; }
    .search-bar button {
        padding: 12px 26px;
        border-radius: 50px;
        border: none;
        background: var(--brand);
        color: #fff;
        font-size: .88rem;
        font-weight: 700;
        cursor: pointer;
        font-family: var(--font-b);
        transition: background .18s, transform .18s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 7px;
        flex-shrink: 0;
    }
    .search-bar button:hover {
        background: var(--brand-dark);
    }

    /* ─── STATS BAR ──────────────────────────────────────── */
    .feed-stats {
        background: var(--white);
        border-bottom: 1px solid var(--gray-200);
        padding: 0 24px;
    }
    .feed-stats-inner {
        max-width: 1160px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 52px;
        gap: 16px;
    }
    .feed-meta {
        font-size: .82rem;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .feed-meta strong { color: var(--ink); font-weight: 700; }
    .feed-meta a { color: var(--brand); font-weight: 600; }
    .feed-meta a:hover { text-decoration: underline; }
    .feed-filters {
        display: flex;
        gap: 6px;
    }
    .filter-chip {
        font-size: .76rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        cursor: pointer;
        transition: all .15s;
        background: transparent;
        font-family: var(--font-b);
        white-space: nowrap;
    }
    .filter-chip:hover, .filter-chip.active {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }

    /* ─── GRID ───────────────────────────────────────────── */
    .feed-section {
        max-width: 1160px;
        margin: 0 auto;
        padding: 36px 20px 60px;
    }
    .imoveis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 22px;
    }

    /* ─── CARD IMÓVEL ─────────────────────────────────────── */
    .imovel-card {
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        box-shadow: var(--shadow-xs);
        transition: transform .22s ease, box-shadow .22s ease;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }
    .imovel-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }
    .imovel-img-wrap {
        position: relative;
        overflow: hidden;
    }
    .imovel-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: var(--gray-100);
        display: block;
        transition: transform .4s ease;
    }
    .imovel-card:hover .imovel-img {
        transform: scale(1.04);
    }
    .imovel-img-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--gray-400);
        gap: 6px;
    }
    .imovel-tipo-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .8px;
        text-transform: uppercase;
        color: var(--white);
        background: var(--brand);
        padding: 4px 12px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,.2);
    }
    .imovel-body {
        padding: 20px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .imovel-titulo {
        font-family: var(--font-h);
        font-size: 1rem;
        font-weight: 700;
        color: var(--charcoal);
        margin-bottom: 6px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .imovel-local {
        font-size: .8rem;
        color: var(--gray-600);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .imovel-preco {
        font-size: 1.18rem;
        font-weight: 800;
        color: var(--brand);
        margin-top: auto;
        margin-bottom: 14px;
    }
    .imovel-preco small {
        font-size: .72rem;
        font-weight: 400;
        color: var(--gray-400);
        margin-left: 2px;
    }
    .imovel-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--gray-100);
        padding-top: 12px;
    }
    .imovel-attrs {
        display: flex;
        gap: 12px;
    }
    .attr-pill {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .76rem;
        color: var(--gray-600);
        background: var(--gray-100);
        padding: 3px 9px;
        border-radius: 20px;
    }
    .imovel-vendedor {
        font-size: .74rem;
        color: var(--gray-400);
        font-style: italic;
    }

    /* ─── EMPTY STATE ─────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 90px 24px;
        grid-column: 1 / -1;
    }
    .empty-icon {
        width: 72px;
        height: 72px;
        background: var(--gray-100);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: var(--gray-400);
    }
    .empty-state h3 {
        font-family: var(--font-h);
        font-size: 1.2rem;
        color: var(--ink);
        margin-bottom: 8px;
    }
    .empty-state p { font-size: .88rem; color: var(--gray-600); }

    /* ─── PAGINATION ──────────────────────────────────────── */
    .pagination-wrap {
        text-align: center;
        margin-top: 48px;
    }
    .pagination-wrap nav { display: inline-block; }

    @media (max-width: 640px) {
        .feed-stats-inner { flex-direction: column; height: auto; padding: 12px 0; gap: 8px; }
        .feed-filters { flex-wrap: wrap; }
        .imoveis-grid { grid-template-columns: 1fr; }
        .feed-hero { padding: 44px 16px 36px; }
    }
</style>
@endsection

@section('content')

{{-- HERO ───────────────────────────────────────────────── --}}
<section class="feed-hero">
    <h1>Encontre o seu imóvel ideal</h1>
    <p>Casas, apartamentos, terrenos e muito mais em todo Angola</p>

    <form class="search-bar" action="{{ route('HomeFinder') }}" method="GET">
        <input type="text" name="busca"
               placeholder="Pesquisar por localização, título ou tipo..."
               value="{{ request('busca') }}"
               autocomplete="off">
        <button type="submit">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Pesquisar
        </button>
    </form>
</section>

{{-- STATS BAR ───────────────────────────────────────────── --}}
<div class="feed-stats">
    <div class="feed-stats-inner">
        <p class="feed-meta">
            @if(request('busca'))
                Resultados para <strong>"{{ request('busca') }}"</strong>
                — <strong>{{ $imoveis->total() }}</strong> imóvel(is) encontrado(s)
                &nbsp;·&nbsp;
                <a href="{{ route('HomeFinder') }}">✕ Limpar</a>
            @else
                <strong>{{ $imoveis->total() }}</strong> imóveis publicados
            @endif
        </p>
        <div class="feed-filters">
            <a href="{{ route('HomeFinder', ['tipo' => 'casa']) }}"
               class="filter-chip {{ request('tipo') === 'casa' ? 'active' : '' }}">Casa</a>
            <a href="{{ route('HomeFinder', ['tipo' => 'apartamento']) }}"
               class="filter-chip {{ request('tipo') === 'apartamento' ? 'active' : '' }}">Apartamento</a>
            <a href="{{ route('HomeFinder', ['tipo' => 'terreno']) }}"
               class="filter-chip {{ request('tipo') === 'terreno' ? 'active' : '' }}">Terreno</a>
            <a href="{{ route('HomeFinder', ['tipo' => 'comercial']) }}"
               class="filter-chip {{ request('tipo') === 'comercial' ? 'active' : '' }}">Comercial</a>
        </div>
    </div>
</div>

{{-- GRID ───────────────────────────────────────────────── --}}
<section class="feed-section">
    
    <div class="imoveis-grid">
        @forelse($imoveis as $imovel)
        <a href="{{ route('imoveis.show', $imovel) }}" class="property-card-link"> 
            <article class="imovel-card">

                             
                    <div class="imovel-img-wrap">
                        @if(!empty($imovel->imagens) && count($imovel->imagens) > 0)
                            <img src="{{ Storage::url($imovel->imagens[0]) }}" 
                                class="imovel-img" 
                                alt="{{ $imovel->titulo }}"
                                onerror="this.src='https://via.placeholder.com/600x400?text=Sem+Imagem'">
                        @else
                            <div class="imovel-img-placeholder">
                                <span>Sem imagem</span>
                            </div>
                        @endif>
                        <span class="imovel-tipo-badge">{{ ucfirst($imovel->tipo ?? 'Imóvel') }}</span>
                    </div>

                <div class="imovel-body">
                    <h3 class="imovel-titulo">{{ $imovel->titulo }}</h3>

                    <p class="imovel-local">
                        {{ $imovel->localizacao }}
                    </p>

                    <p class="imovel-preco">
                        {{ number_format($imovel->preco, 0, ',', '.') }} Kz
                        <small>/ negociável</small>
                    </p>

                    <div class="imovel-footer">
                        <div class="imovel-attrs">
                            @if($imovel->quartos)
                                <span class="attr-pill">{{ $imovel->quartos }} Quartos</span>
                            @endif
                            @if($imovel->banheiros)
                                <span class="attr-pill">{{ $imovel->banheiros }} Banheiros</span>
                            @endif
                            @if($imovel->area_m2)
                                <span class="attr-pill">{{ $imovel->area_m2 }} m²</span>
                            @endif
                        </div>
                        <span class="imovel-vendedor">
                            {{ $imovel->cliente->primeiro_nome ?? 'Vendedor' }}
                        </span>
                    </div>
                </div>
            </article>  
        </a>
        @empty
            <div class="empty-state">
                <h3>Nenhum imóvel encontrado</h3>
                <p>Tente outra pesquisa.</p>
            </div>
        @endforelse
    </div>

    @if($imoveis->hasPages())
        <div class="pagination-wrap">
            {{ $imoveis->appends(request()->query())->links() }}
        </div>
    @endif
</section>

@endsection
