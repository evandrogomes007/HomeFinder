

<?php $__env->startSection('title', 'Meus Imóveis — HomeFinder'); ?>

<?php $__env->startSection('head'); ?>
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
        text-decoration: none;
    }
    .filter-chip:hover, .filter-chip.active {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }

    /* ─── GRID SECTION ───────────────────────────────────── */
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

    /* ─── CARD IMOVEL ─────────────────────────────────────── */
    .imovel-card {
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        box-shadow: var(--shadow-xs);
        transition: transform .22s ease, box-shadow .22s ease;
        display: flex;
        flex-direction: column;
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
    .imovel-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--gray-100);
        padding-top: 12px;
    }
    .imovel-attrs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
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

    /* ─── CARD ACTIONS ────────────────────────────────────── */
    .imovel-actions {
        display: flex;
        gap: 8px;
        padding: 0 22px 20px;
    }
    .btn-action {
        flex: 1;
        padding: 9px 10px;
        font-size: .78rem;
        font-weight: 700;
        font-family: var(--font-b);
        border-radius: var(--radius-sm);
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: opacity .15s, transform .1s;
        white-space: nowrap;
    }
    .btn-action:active { transform: scale(.97); }
    .btn-action-view {
        background: var(--gray-100);
        color: var(--gray-600);
        border-color: var(--gray-200);
    }
    .btn-action-view:hover { background: var(--gray-200); color: var(--ink); }
    .btn-action-edit {
        background: rgba(245,158,11,.1);
        color: #d97706;
        border-color: rgba(245,158,11,.25);
    }
    .btn-action-edit:hover { background: rgba(245,158,11,.2); }
    .btn-action-delete {
        background: rgba(239,68,68,.08);
        color: #dc2626;
        border-color: rgba(239,68,68,.2);
    }
    .btn-action-delete:hover { background: rgba(239,68,68,.16); }

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
    .empty-state p {
        font-size: .88rem;
        color: var(--gray-600);
        margin-bottom: 24px;
    }

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
        .myprop-hero { padding: 44px 16px 36px; }
        .imovel-actions { flex-wrap: wrap; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="publish-wrap">

    <div class="publish-header">
            <span class="card-eyebrow" style="display:block; margin-bottom:6px;">Painel do vendedor</span>
            <h1 style="font-family:var(--font-h); font-size:1.9rem; font-weight:900; color:var(--charcoal); margin-bottom:8px;">
                Meus Imóveis Publicados
            </h1>
            <p style="font-size:.88rem; color:var(--gray-600);">
                Gerencie, edite e acompanhe todos os seus anúncios em um só lugar
            </p>
        </div>

    
    <div class="feed-stats">
        <div class="feed-stats-inner">
            <p class="feed-meta">
                <?php if($imoveis->isEmpty()): ?>
                    Nenhum imóvel publicado ainda
                <?php else: ?>
                    <strong><?php echo e($imoveis->total()); ?></strong> imóvel(is) publicado(s)
                    <?php if(request('tipo')): ?>
                        &nbsp;·&nbsp;
                        <a href="<?php echo e(route('imoveis.index')); ?>">✕ Limpar filtro</a>
                    <?php endif; ?>
                <?php endif; ?>
            </p>

            <div class="feed-filters">
                <a href="<?php echo e(route('HomeFinder', ['tipo' => 'casa'])); ?>"
                class="filter-chip <?php echo e(request('tipo') === 'casa' ? 'active' : ''); ?>">Casa</a>
                <a href="<?php echo e(route('HomeFinder', ['tipo' => 'apartamento'])); ?>"
                class="filter-chip <?php echo e(request('tipo') === 'apartamento' ? 'active' : ''); ?>">Apartamento</a>
                <a href="<?php echo e(route('HomeFinder', ['tipo' => 'terreno'])); ?>"
                class="filter-chip <?php echo e(request('tipo') === 'terreno' ? 'active' : ''); ?>">Terreno</a>
                <a href="<?php echo e(route('HomeFinder', ['tipo' => 'comercial'])); ?>"
                class="filter-chip <?php echo e(request('tipo') === 'comercial' ? 'active' : ''); ?>">Comercial</a>
            </div>
        </div>
    </div>

    
    <section class="feed-section">
        <div class="imoveis-grid">
            <?php $__empty_1 = true; $__currentLoopData = $imoveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="imovel-card">

                    
                    <div class="imovel-img-wrap">
                        <?php if(!empty($imovel->imagens) && count($imovel->imagens) > 0): ?>
                            <img src="<?php echo e(Storage::url($imovel->imagens[0])); ?>"
                                class="imovel-img"
                                alt="<?php echo e($imovel->titulo); ?>">
                        <?php else: ?>
                            <div class="imovel-img-placeholder">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <span style="font-size:.78rem; font-family:var(--font-b);">Sem foto</span>
                            </div>
                        <?php endif; ?>
                        <span class="imovel-tipo-badge"><?php echo e(ucfirst($imovel->tipo ?? 'Imóvel')); ?></span>
                    </div>

                    
                    <div class="imovel-body">
                        <h3 class="imovel-titulo"><?php echo e($imovel->titulo); ?></h3>

                        <p class="imovel-local">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo e($imovel->localizacao); ?>

                        </p>

                        <p class="imovel-preco">
                            <?php echo e(number_format($imovel->preco, 0, ',', '.')); ?> Kz
                        </p>

                        <div class="imovel-footer">
                            <div class="imovel-attrs">
                                <?php if($imovel->quartos): ?>
                                    <span class="attr-pill"><?php echo e($imovel->quartos); ?> Qts</span>
                                <?php endif; ?>
                                <?php if($imovel->banheiros): ?>
                                    <span class="attr-pill"><?php echo e($imovel->banheiros); ?> Ban</span>
                                <?php endif; ?>
                                <?php if($imovel->area_m2): ?>
                                    <span class="attr-pill"><?php echo e($imovel->area_m2); ?> m²</span>
                                <?php endif; ?>
                            </div>
                            <span style="font-size:.72rem; color:var(--gray-400); font-style:italic;">
                                <?php echo e($imovel->created_at?->diffForHumans()); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="imovel-actions">
                        <a href="<?php echo e(route('imoveis.show', $imovel)); ?>" class="btn-action btn-action-view">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Ver
                        </a>
                        <a href="<?php echo e(route('imoveis.edit', $imovel)); ?>" class="btn-action btn-action-edit">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Editar
                        </a>
                        <form action="<?php echo e(route('imoveis.destroy', $imovel)); ?>" method="POST"
                            style="flex:1;"
                            onsubmit="return confirm('Tem certeza que deseja excluir este imóvel?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-action btn-action-delete" style="width:100%;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                Excluir
                            </button>
                        </form>
                    </div>

                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <h3>Nenhum imóvel publicado ainda</h3>
                    <p>
                        <?php if(request('tipo')): ?>
                            Sem imóveis do tipo "<?php echo e(request('tipo')); ?>" publicados.
                        <?php else: ?>
                            Comece a vender ou alugar o seu imóvel agora mesmo.
                        <?php endif; ?>
                    </p>
                    <?php if(request('tipo')): ?>
                        <a href="#" class="btn btn-ghost" style="width:auto; display:inline-flex; padding:11px 24px; margin:0 8px 0 0;">
                            Ver todos
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('imoveis.create')); ?>" class="btn btn-brand" style="width:auto; display:inline-flex; padding:11px 24px; margin:0;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Publicar Primeiro Imóvel
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if($imoveis->hasPages()): ?>
            <div class="pagination-wrap">
                <?php echo e($imoveis->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </section>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('homefinder', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jacir\Documents\gabi\HomeFinder\resources\views/pages/my-properties.blade.php ENDPATH**/ ?>