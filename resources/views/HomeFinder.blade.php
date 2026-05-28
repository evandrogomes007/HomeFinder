<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeFinder — Imóveis em Angola</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

    <style>
        /* ─── TOKENS ───────────────────────────────────────────────── */
        :root {
            --red:       #ffffff;
            --red-dark:  #ceb8b6;
            --cream:     #d8924c;
            --sand:      #a79f94;
            --charcoal:  #1C1C1E;
            --gray:      #6B6B6B;
            --border:    #D9D3CB;
            --white:     #FFFFFF;
            --shadow-sm: 0 2px 8px rgba(0,0,0,.08);
            --shadow-md: 0 8px 32px rgba(0,0,0,.12);
            --radius:    14px;
            --radius-sm: 8px;
            --font-d: 'Playfair Display', Georgia, serif;
            --font-b: 'DM Sans', system-ui, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-b);
            background: var(--cream);
            color: var(--charcoal);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }

        /* ─── HEADER ─────────────────────────────────────────────── */
        .site-header {
            background: var(--charcoal);
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,0,0,.3);
        }
        .logo {
            font-family: var(--font-d);
            font-size: 1.55rem;
            font-weight: 900;
            color: var(--white);
            letter-spacing: -.5px;
        }
        .logo span { color: var(--red); }

        .header-nav {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .header-nav a,
        .header-nav button {
            font-family: var(--font-b);
            font-size: .85rem;
            font-weight: 500;
            padding: 8px 18px;
            border-radius: 40px;
            border: 1.5px solid rgba(255,255,255,.2);
            background: transparent;
            color: var(--white);
            cursor: pointer;
            transition: all .18s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .header-nav a:hover,
        .header-nav button:hover {
            background: rgba(255,255,255,.1);
            border-color: rgba(255,255,255,.35);
        }
        .header-nav .btn-primary {
            background: var(--red);
            border-color: var(--red);
        }
        .header-nav .btn-primary:hover {
            background: var(--red-dark);
            border-color: var(--red-dark);
        }
        .header-nav form { margin: 0; }

        /* ─── TOAST ───────────────────────────────────────────────── */
        #toast {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            padding: 12px 26px;
            border-radius: 40px;
            font-size: .88rem;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transition: all .35s cubic-bezier(.34,1.56,.64,1);
            pointer-events: none;
            box-shadow: var(--shadow-md);
        }
        #toast.success { background: #27AE60; color: #fff; }
        #toast.error   { background: var(--red); color: #fff; }
        #toast.show    { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* ─── SHARED FORM ELEMENTS ────────────────────────────────── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 38px 36px;
            box-shadow: var(--shadow-sm);
        }
        .card-title {
            font-family: var(--font-d);
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--charcoal);
            margin-bottom: 4px;
        }
        .card-sub {
            font-size: .9rem;
            color: var(--gray);
            margin-bottom: 28px;
        }
        .form-group { margin-bottom: 14px; }
        .form-label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--charcoal);
            margin-bottom: 5px;
            letter-spacing: .4px;
            text-transform: uppercase;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: var(--font-b);
            font-size: .95rem;
            background: var(--cream);
            color: var(--charcoal);
            transition: border-color .18s, box-shadow .18s;
            outline: none;
            appearance: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--red);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(192,57,43,.1);
        }
        textarea { resize: vertical; min-height: 90px; line-height: 1.5; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: var(--font-b);
            font-size: .92rem;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 40px;
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: all .18s ease;
            width: 100%;
            letter-spacing: .15px;
            margin-top: 8px;
        }
        .btn-red  { background: var(--red); color: #fff; border-color: var(--red); }
        .btn-red:hover { background: var(--red-dark); border-color: var(--red-dark); }
        .btn-ghost { background: transparent; color: var(--charcoal); border-color: var(--border); }
        .btn-ghost:hover { background: var(--sand); }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 24px 0;
        }
        .link-row {
            text-align: center;
            font-size: .88rem;
            color: var(--gray);
            margin-top: 16px;
        }
        .link-row a { color: var(--red); font-weight: 600; }

        /* ─── ALERT ───────────────────────────────────────────────── */
        .alert {
            background: #FEF2F2;
            border: 1.5px solid #FECACA;
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            margin-top: 14px;
        }
        .alert-title {
            font-size: .88rem;
            font-weight: 700;
            color: var(--red);
            margin-bottom: 6px;
        }
        .alert ul { padding-left: 18px; font-size: .87rem; color: #7F1D1D; }
        .alert li { margin-bottom: 3px; }

        /* ─── FOOTER ──────────────────────────────────────────────── */
        .site-footer {
            background: var(--charcoal);
            color: rgba(255,255,255,.45);
            padding: 40px 28px;
            text-align: center;
            font-size: .82rem;
            line-height: 1.8;
            margin-top: 80px;
        }
        .footer-logo {
            font-family: var(--font-d);
            font-size: 1.3rem;
            color: var(--white);
            margin-bottom: 10px;
            display: block;
        }
        .footer-logo span { color: var(--red); }
        .site-footer strong { color: rgba(255,255,255,.8); }
        .site-footer .footer-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,.08);
            margin: 18px auto;
            max-width: 300px;
        }

        main { min-height: calc(100vh - 64px - 260px); }
    </style>
</head>
<body>

<header class="site-header">
    <a href="{{ route('HomeFinder') }}" class="logo">Home<span>Finder</span></a>
    <nav class="header-nav">
        @auth
            <a href="{{ route('imoveis.create') }}" class="btn-primary">＋ Publicar Imóvel</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Sair</button>
            </form>
        @else
            <a href="{{ route('login') }}">Entrar</a>
            <a href="{{ route('clientes.create') }}" class="btn-primary">Registar</a>
        @endauth
    </nav>
</header>

@if(session('success'))
    <div id="toast" class="success">{{ session('success') }}</div>
@elseif(session('error'))
    <div id="toast" class="error">{{ session('error') }}</div>
@endif

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <span class="footer-logo">Home<span>Finder</span></span>
    <p>Plataforma digital para compra, venda e arrendamento de imóveis em Angola.</p>
    <hr class="footer-divider">
    <p>Problemas? Contacte: <strong>948 548 637 / 948 713 976 / 925 198 671</strong></p>
    <p style="margin-top:6px;">Desenvolvido por <strong>Ntela João, Gabriel Francisco & Evandro Gomes</strong></p>
    <p>Ideia original: <strong>Martinho Numa</strong></p>
    <p style="margin-top:16px;font-size:.76rem;opacity:.4;">© 2025 HomeFinder. Todos os direitos reservados.</p>
</footer>

<script>
    const toast = document.getElementById('toast');
    if (toast) {
        requestAnimationFrame(() => {
            setTimeout(() => toast.classList.add('show'), 80);
            setTimeout(() => toast.classList.remove('show'), 3600);
        });
    }
</script>
</body>
</html>
