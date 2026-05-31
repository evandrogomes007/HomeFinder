<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'HomeFinder — Imóveis em Angola'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Compre, venda ou arrende imóveis em Angola com a HomeFinder.'); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">

    <style>
        /* ─── DESIGN TOKENS ────────────────────────────────────────── */
        :root {
            --brand:       #C8A96B;   /* terra-cotta angolana */
            --brand-dark:  #06B6D4;
            --brand-light: #FFF0EB;
            --accent:      #F4A642;   /* dourado quente */
            --charcoal:    #2563EB;
            --ink:         #bbbbbb;
            --gray-600:    #0F172A;
            --gray-400:    #9CA3AF;
            --gray-200:    #e5e7eb8c;
            --gray-100:    #F3F4F6;
            --cream:       #FDFAF7;
            --white:       #FFFFFF;

            --shadow-xs: 0 1px 3px rgba(0,0,0,.08);
            --shadow-sm: 0 4px 12px rgba(0,0,0,.08);
            --shadow-md: 0 8px 30px rgba(0,0,0,.12);
            --shadow-lg: 0 20px 60px rgba(0,0,0,.15);

            --radius:    16px;
            --radius-sm: 10px;
            --radius-xs: 6px;

            --font-h: 'Playfair Display', Georgia, serif;
            --font-b: 'Sora', system-ui, sans-serif;

            --header-h: 68px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-b);
            background: var(--cream);
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }

        /* ─── HEADER ─────────────────────────────────────────────── */
        .site-header {
            background: var(--charcoal);
            height: var(--header-h);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: 0 2px 24px rgba(0,0,0,.35);
        }

        .logo {
            font-family: var(--font-h);
            font-size: 1.6rem;
            font-weight: 900;
            color: var(--white);
            letter-spacing: -.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .logo-dot { color: var(--brand); }
        .logo-badge {
            font-family: var(--font-b);
            font-size: .6rem;
            font-weight: 700;
            background: var(--brand);
            color: #fff;
            padding: 2px 7px;
            border-radius: 20px;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-left: 2px;
            align-self: flex-start;
            margin-top: 6px;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link {
            font-size: .82rem;
            font-weight: 500;
            color: rgba(255,255,255,.75);
            padding: 7px 16px;
            border-radius: 40px;
            border: 1.5px solid transparent;
            transition: all .18s ease;
            cursor: pointer;
            background: transparent;
            font-family: var(--font-b);
            white-space: nowrap;
        }
        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.15);
        }
        .nav-cta {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff !important;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .nav-cta:hover {
            background: var(--brand-dark) !important;
            border-color: var(--brand-dark) !important;
        }
        .header-nav form { margin: 0; }

        /* ─── TOAST ───────────────────────────────────────────────── */
        #toast {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            padding: 13px 28px;
            border-radius: 50px;
            font-size: .875rem;
            font-weight: 600;
            z-index: 9999;
            opacity: 0;
            transition: all .4s cubic-bezier(.34,1.56,.64,1);
            pointer-events: none;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: calc(100vw - 48px);
        }
        #toast.success { background: #059669; color: #fff; }
        #toast.error   { background: var(--brand); color: #fff; }
        #toast.show    { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* ─── SHARED FORM ATOMS ───────────────────────────────────── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            padding: 40px 38px;
            box-shadow: var(--shadow-sm);
        }

        .card-eyebrow {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--brand);
            margin-bottom: 8px;
        }
        .card-title {
            font-family: var(--font-h);
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--charcoal);
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .card-sub {
            font-size: .88rem;
            color: var(--gray-600);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: .72rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-family: var(--font-b);
            font-size: .9rem;
            background: var(--gray-100);
            color: var(--ink);
            transition: border-color .18s, background .18s, box-shadow .18s;
            outline: none;
            appearance: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--brand);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(217,65,30,.12);
        }
        input::placeholder, textarea::placeholder { color: var(--gray-400); }
        select { cursor: pointer; }
        textarea { resize: vertical; min-height: 100px; line-height: 1.6; }

        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: var(--font-b);
            font-size: .9rem;
            font-weight: 700;
            padding: 13px 26px;
            border-radius: 50px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all .2s ease;
            width: 100%;
            letter-spacing: .2px;
            margin-top: 10px;
        }
        .btn-brand {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }
        .btn-brand:hover {
            background: var(--brand-dark);
            border-color: var(--brand-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(217,65,30,.3);
        }
        .btn-ghost {
            background: transparent;
            color: var(--ink);
            border-color: var(--gray-200);
        }
        .btn-ghost:hover { background: var(--gray-100); }

        .divider {
            border: none;
            border-top: 1px solid var(--gray-200);
            margin: 26px 0;
        }
        .link-row {
            text-align: center;
            font-size: .85rem;
            color: var(--gray-600);
            margin-top: 18px;
        }
        .link-row a { color: var(--brand); font-weight: 700; }
        .link-row a:hover { text-decoration: underline; }

        /* ─── ALERT / VALIDATION ──────────────────────────────────── */
        .alert {
            background: #FFF1EE;
            border: 1.5px solid #FECDB8;
            border-left: 4px solid var(--brand);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            margin-top: 16px;
        }
        .alert-title {
            font-size: .83rem;
            font-weight: 700;
            color: var(--brand);
            margin-bottom: 6px;
        }
        .alert ul { padding-left: 18px; font-size: .84rem; color: #7C2D12; line-height: 1.6; }
        .alert li { margin-bottom: 3px; }

        /* ─── FOOTER ──────────────────────────────────────────────── */
        .site-footer {
            background: var(--charcoal);
            color: rgba(255,255,255,.4);
            padding: 52px 32px 40px;
            margin-top: 100px;
        }
        .footer-inner {
            max-width: 960px;
            margin: 0 auto;
        }
        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            flex-wrap: wrap;
            padding-bottom: 32px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            margin-bottom: 28px;
        }
        .footer-brand .logo {
            font-size: 1.4rem;
            margin-bottom: 10px;
        }
        .footer-tagline {
            font-size: .82rem;
            line-height: 1.7;
            color: rgba(255,255,255,.38);
            max-width: 260px;
        }
        .footer-contact {
            text-align: right;
        }
        .footer-contact p {
            font-size: .8rem;
            line-height: 1.9;
            color: rgba(255,255,255,.38);
        }
        .footer-contact strong { color: rgba(255,255,255,.7); }
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            font-size: .76rem;
        }
        .footer-credits { color: rgba(255,255,255,.32); }
        .footer-credits strong { color: rgba(255,255,255,.6); }
        .footer-copy { color: rgba(255,255,255,.22); }

        main { min-height: calc(100vh - var(--header-h) - 360px); }

        @media (max-width: 600px) {
            .site-header { padding: 0 16px; }
            .logo-badge { display: none; }
            .nav-link { padding: 6px 12px; }
            .card { padding: 28px 20px; }
            .footer-top { flex-direction: column; }
            .footer-contact { text-align: left; }
            .footer-bottom { flex-direction: column; text-align: center; }
            .input-row { grid-template-columns: 1fr; }
        }
    </style>

    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>

<header class="site-header">
    <a href="<?php echo e(route('HomeFinder')); ?>" class="logo">
        Home<span class="logo-dot">Finder</span>
        <span class="logo-badge">AO</span>
    </a>
    <nav class="header-nav">
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('imoveis.meu')); ?>" class="nav-link nav-cta">Meus Imóveis</a>
            <a href="<?php echo e(route('imoveis.create')); ?>" class="nav-link nav-cta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Publicar Imóvel
            </a>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-link">Sair</button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="nav-link">Entrar</a>
            <a href="<?php echo e(route('clientes.create')); ?>" class="nav-link nav-cta">
                Criar conta
            </a>
        <?php endif; ?>
    </nav>
</header>

<?php if(session('success')): ?>
    <div id="toast" class="success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        <?php echo e(session('success')); ?>

    </div>
<?php elseif(session('error')): ?>
    <div id="toast" class="error">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<main>
    <?php echo $__env->yieldContent('content'); ?>
    <!-- MODAL DE GALERIA DE IMAGENS -->
    <div id="imageModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:10000; align-items:center; justify-content:center;">
    <div style="max-width:95%; max-height:95%; position:relative;">
            <button onclick="closeModal()" 
                    style="position:absolute; top:-50px; right:10px; color:white; font-size:40px; background:none; border:none; cursor:pointer;">×</button>
            <div id="modalImages" style="display:flex; gap:15px; overflow-x:auto; padding:10px;"></div>
        </div>
    </div>
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="logo">Home<span class="logo-dot">Finder</span></div>
                <p class="footer-tagline">Plataforma digital para compra, venda e arrendamento de imóveis em Angola.</p>
            </div>
            <div class="footer-contact">
                <p>Problemas ou suporte?</p>
                <p><strong>948 548 637</strong></p>
                <p><strong>948 713 976</strong></p>
                <p><strong>925 198 671</strong></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="footer-credits">
                Desenvolvido por <strong>Ntela João, Gabriel Francisco & Evandro Gomes</strong>
                &nbsp;·&nbsp; Ideia: <strong>Martinho Numa</strong>
            </p>
            <p class="footer-copy">© 2025 HomeFinder · Todos os direitos reservados</p>
        </div>
    </div>
</footer>

<script>
    let currentImoveis = <?php echo json_encode($currentImoveis ?? [], 15, 512) ?>;

    function showImageGallery(imovelId) {
        const imovel = currentImoveis.find(i => i.id == imovelId);
        
        if (!imovel || !imovel.imagens || imovel.imagens.length === 0) {
            alert("Este imóvel não possui outras imagens.");
            return;
        }

        const container = document.getElementById('modalImages');
        container.innerHTML = '';

        imovel.imagens.forEach((path, index) => {
            const div = document.createElement('div');
            div.style.minWidth = '300px';
            div.style.textAlign = 'center';
            
            const img = document.createElement('img');
            img.src = '/storage/' + path;
            img.style.maxWidth = '75vh';
            img.style.borderRadius = '8px';
            img.style.boxShadow = '0 4px 15px rgba(0,0,0,0.5)';
            
            const caption = document.createElement('p');
            caption.textContent = `Imagem ${index + 1} de ${imovel.imagens.length}`;
            caption.style.color = '#ddd';
            caption.style.marginTop = '8px';
            
            div.appendChild(img);
            div.appendChild(caption);
            container.appendChild(div);
        });

        document.getElementById('imageModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Fechar ao clicar fora
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    const toast = document.getElementById('toast');
    if (toast) {
        requestAnimationFrame(() => {
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => toast.classList.remove('show'), 4000);
        });
    }
</script>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\jacir\Documents\gabi\HomeFinder\resources\views/homefinder.blade.php ENDPATH**/ ?>