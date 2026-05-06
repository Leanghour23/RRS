<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stay Safe Here | Room Rental System')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        :root {
            --bg: #fafafa;
            --bg-accent: #f3f4f6;
            --surface: rgba(255, 255, 255, 0.96);
            --surface-strong: #ffffff;
            --surface-dark: #111827;
            --primary: #111827;
            --primary-deep: #030712;
            --primary-soft: #f3f4f6;
            --secondary: #2563eb;
            --secondary-deep: #1d4ed8;
            --secondary-soft: #dbeafe;
            --text: #111827;
            --muted: #6b7280;
            --muted-soft: #9ca3af;
            --line: #e5e7eb;
            --success: #374151;
            --danger: #ef4444;
            --danger-deep: #dc2626;
            --danger-soft: #fee2e2;
            --shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
            --radius-xl: 28px;
            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;
            --content-width: 1180px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", "Trebuchet MS", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.05), transparent 30%),
                radial-gradient(circle at top right, rgba(55, 65, 81, 0.06), transparent 35%),
                linear-gradient(180deg, var(--bg) 0%, #f3f4f6 100%);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            display: block;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        .page-frame {
            width: min(var(--content-width), calc(100% - 32px));
            margin: 0 auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            padding: 18px 0;
            backdrop-filter: blur(18px);
            background: rgba(250, 250, 250, 0.88);
            border-bottom: 1px solid rgba(229, 231, 235, 0.9);
        }

        .site-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--surface-dark);
        }

        .brand-mark {
            width: 44px;
            height: 44px;
        }

        .site-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            flex: 0 0 auto;
            max-width: 100%;
        }

        .site-logo-mark {
            display: inline-flex;
            flex: 0 0 auto;
            filter: drop-shadow(0 10px 24px rgba(17, 24, 39, 0.12));
        }

        .site-logo-mark svg {
            width: 100%;
            height: 100%;
        }

        .site-logo-wordmark {
            display: inline-block;
            font-size: 0.92rem;
            line-height: 1.05;
            white-space: nowrap;
        }

        .site-nav {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
        }

        .nav-link,
        .button-link,
        .button-secondary {
            border-radius: 999px;
            transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .nav-link {
            padding: 11px 16px;
            color: var(--muted);
            border: 1px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--secondary);
            border-color: rgba(37, 99, 235, 0.16);
            background: rgba(219, 234, 254, 0.45);
        }

        .button-link,
        .button-secondary,
        .button-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 20px;
            border: none;
            cursor: pointer;
            font-weight: 700;
        }

        .button-link {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-deep));
            box-shadow: 0 14px 30px rgba(17, 24, 39, 0.18);
        }

        .button-secondary {
            color: var(--surface-dark);
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(229, 231, 235, 1);
        }

        .button-submit {
            width: 100%;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-deep));
            box-shadow: 0 14px 28px rgba(17, 24, 39, 0.18);
        }

        .button-link:hover,
        .button-secondary:hover,
        .button-submit:hover,
        .nav-link:hover {
            transform: translateY(-2px);
        }

        .page-content {
            padding: 38px 0 72px;
        }

        .panel,
        .room-card,
        .info-card,
        .auth-card,
        .metric-card,
        .list-card,
        .table-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
        }

        .flash-banner {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 1200;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            width: fit-content;
            max-width: min(520px, calc(100vw - 48px));
            margin: 0;
            padding: 14px 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.96);
            color: var(--surface-dark);
            border: 1px solid rgba(17, 24, 39, 0.08);
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(14px);
            line-height: 1.45;
            transition: opacity 0.28s ease, transform 0.28s ease, max-height 0.28s ease, padding 0.28s ease, border-width 0.28s ease;
            opacity: 1;
            transform: translateY(0);
            max-height: 120px;
            overflow: hidden;
        }

        .flash-banner::before {
            content: "OK";
            flex: 0 0 auto;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(55, 65, 81, 0.12);
            color: var(--success);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .flash-banner.is-hiding {
            opacity: 0;
            transform: translateY(-10px);
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
            border-width: 0;
        }

        @media (max-width: 640px) {
            .flash-banner {
                top: 16px;
                right: 16px;
                left: 16px;
                max-width: none;
                width: auto;
            }
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.72);
            color: var(--surface-dark);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .section-heading h2,
        .hero-copy h1,
        .auth-copy h1,
        .dashboard-heading h1 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            line-height: 1.05;
            color: var(--surface-dark);
        }

        .section-heading p,
        .hero-copy p,
        .auth-copy p,
        .dashboard-heading p,
        .muted {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .hero {
            grid-template-columns: 1.3fr 0.9fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .hero-copy,
        .hero-aside,
        .auth-copy,
        .auth-form-wrap,
        .dashboard-hero {
            padding: 30px;
        }

        .hero-copy {
            position: relative;
            overflow: hidden;
        }

        .hero-copy::after {
            content: "";
            position: absolute;
            inset: auto -90px -90px auto;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, transparent 68%);
        }

        .hero-copy h1 {
            margin-top: 18px;
            font-size: clamp(2.6rem, 5vw, 4.7rem);
            max-width: 9ch;
        }

        .hero-copy p {
            margin-top: 18px;
            max-width: 58ch;
            font-size: 1.05rem;
        }

        .hero-actions,
        .stat-row,
        .feature-pills,
        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-actions {
            margin-top: 28px;
        }

        .stat-row {
            margin-top: 26px;
        }

        .stat-pill {
            min-width: 140px;
            padding: 16px 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.64);
            border: 1px solid rgba(229, 231, 235, 1);
        }

        .stat-pill strong,
        .metric-value,
        .price-tag strong {
            display: block;
            font-size: 1.45rem;
            color: var(--surface-dark);
        }

        .stat-pill span,
        .metric-label,
        .meta-line,
        .table-subtle {
            color: var(--muted);
            font-size: 0.92rem;
        }

        .hero-aside h3,
        .auth-form-wrap h2,
        .list-card h3,
        .table-card h3 {
            margin: 0 0 10px;
            color: var(--surface-dark);
        }

        .hero-aside p,
        .auth-form-wrap p {
            margin: 0 0 22px;
            color: var(--muted);
            line-height: 1.6;
        }

        .form-grid {
            display: grid;
            gap: 14px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        .field label {
            font-weight: 700;
            color: var(--surface-dark);
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.82);
            color: var(--text);
            outline: none;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: rgba(37, 99, 235, 0.4);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .form-note,
        .inline-note {
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .room-grid,
        .info-grid,
        .metrics-grid,
        .dashboard-grid,
        .auth-grid,
        .steps-grid {
            display: grid;
            gap: 20px;
        }

        .room-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 32px;
        }

        .room-card {
            overflow: hidden;
        }

        .room-image {
            min-height: 210px;
            padding: 20px;
            display: flex;
            align-items: end;
            justify-content: space-between;
            color: #fff;
        }

        .room-image--garden-photo {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://i.pinimg.com/1200x/fa/2f/ff/fa2fffc8ab6ec7f91064a660ebe5d04c.jpg') center/cover no-repeat;
        }

        .room-image--loft-photo {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://i.pinimg.com/736x/f1/77/c5/f177c5954b2cf9fbb981d8f744d85fc1.jpg') center/cover no-repeat;
        }

        .room-image--executive-photo {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.16), rgba(15, 23, 42, 0.48)),
                url('https://i.pinimg.com/1200x/d4/84/5e/d4845eedfc3cc7b847fb59060052ee2c.jpg') center/cover no-repeat;
        }

        .room-image--river {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        }

        .room-image--maple {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        }

        .room-image--skyline {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        }

        .room-image--oakwood {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        }

        .room-image--harbor {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        }

        .room-image--campus {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)),
                url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        }

        .room-image small,
        .status-chip,
        .soft-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .room-image small {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
        }

        .room-body {
            padding: 22px;
        }

        .room-title-row,
        .metric-header,
        .table-row,
        .list-row {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 14px;
        }

        .room-body h3,
        .info-card h3 {
            margin: 0;
            color: var(--surface-dark);
        }

        .room-meta,
        .property-table,
        .mini-list {
            display: grid;
            gap: 12px;
        }

        .room-meta {
            margin: 16px 0 18px;
        }

        .meta-line {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .meta-line strong {
            color: var(--surface-dark);
        }

        .price-tag {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 12px;
        }

        .price-value {
            text-align: right;
        }

        .price-value.inline {
            display: inline-flex;
            align-items: baseline;
            gap: 6px;
        }

        .price-value.inline strong,
        .price-value.inline span {
            display: inline;
        }

        .price-tag span {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .info-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 32px;
        }

        .info-card {
            padding: 24px;
        }

        .feature-pills {
            margin-top: 18px;
        }

        .soft-chip {
            background: var(--secondary-soft);
            color: var(--secondary);
        }

        .steps-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .step-card {
            padding: 22px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.46);
        }

        .step-number {
            width: 42px;
            height: 42px;
            margin-bottom: 18px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: var(--surface-dark);
            color: #fff;
            font-weight: 800;
        }

        .page-auth .page-frame,
        .page-dashboard .page-frame {
            width: min(var(--content-width), calc(100% - 28px));
        }

        .auth-grid {
            grid-template-columns: 1fr 1fr;
            align-items: stretch;
        }

        .auth-copy {
            background: linear-gradient(160deg, rgba(17, 24, 39, 0.98), rgba(55, 65, 81, 0.94));
            color: #f8fafc;
        }

        .auth-copy h1,
        .auth-copy p,
        .auth-copy .inline-note,
        .auth-copy li {
            color: inherit;
        }

        .auth-copy .eyebrow {
            background: rgba(255, 255, 255, 0.08);
            color: #dbeafe;
        }

        .auth-points {
            display: grid;
            gap: 14px;
            margin: 28px 0 0;
            padding: 0;
            list-style: none;
        }

        .auth-points li {
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
        }

        .auth-form-wrap {
            background: rgba(255, 250, 244, 0.88);
        }

        .form-row-two {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .dashboard-hero {
            margin-bottom: 22px;
        }

        .dashboard-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 18px;
        }

        .metrics-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin-bottom: 22px;
        }

        .metric-card,
        .list-card,
        .table-card {
            padding: 24px;
        }

        .metric-card {
            display: grid;
            gap: 18px;
        }

        .status-chip {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .dashboard-grid {
            grid-template-columns: 1.35fr 0.85fr;
            align-items: start;
        }

        .property-table {
            margin-top: 18px;
        }

        .table-row,
        .list-row {
            padding: 14px 0;
            border-top: 1px solid var(--line);
        }

        .table-row:first-child,
        .list-row:first-child {
            border-top: none;
            padding-top: 6px;
        }

        .table-row strong,
        .list-row strong {
            color: var(--surface-dark);
        }

        .table-stack {
            display: grid;
            gap: 4px;
        }

        .quick-actions {
            margin-top: 18px;
        }

        .site-footer {
            padding: 0 0 34px;
        }

        .site-footer-card {
            padding: 22px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .site-footer-card p {
            margin: 0;
            color: var(--muted);
        }

        @media (max-width: 1080px) {
            .hero,
            .auth-grid,
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .room-grid,
            .info-grid,
            .steps-grid,
            .metrics-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .site-header {
                position: static;
            }

            .site-header-inner,
            .section-heading,
            .dashboard-heading,
            .site-footer-card,
            .room-title-row,
            .table-row,
            .list-row {
                flex-direction: column;
                align-items: stretch;
            }

            .price-tag {
                align-items: stretch;
            }

            .price-value {
                text-align: right;
                align-self: flex-end;
            }

            .page-content {
                padding-top: 24px;
            }

            .hero-copy,
            .hero-aside,
            .auth-copy,
            .auth-form-wrap,
            .dashboard-hero,
            .metric-card,
            .list-card,
            .table-card {
                padding: 22px;
            }

            .room-grid,
            .info-grid,
            .steps-grid,
            .metrics-grid,
            .form-row-two {
                grid-template-columns: 1fr;
            }

            .hero-copy h1,
            .auth-copy h1,
            .dashboard-heading h1 {
                font-size: 2.3rem;
            }

            .page-frame {
                width: min(var(--content-width), calc(100% - 20px));
            }

            .site-nav {
                justify-content: flex-start;
            }
        }
    </style>
    @stack('head')
</head>
<body class="@yield('page_class', 'page-shell')">
    @if (! trim($__env->yieldContent('hide_shell')))
        <header class="site-header">
            <div class="page-frame site-header-inner">
                <a href="{{ route('home') }}" class="brand">
                    <x-site-logo mark-class="brand-mark" />
                </a>

                <nav class="site-nav">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Browse Rooms</a>
                    @auth
                        @if (auth()->user()->is_admin || auth()->user()->role === 'admin')
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard', 'admin.*') ? 'active' : '' }}">Dashboard</a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                        <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                    @endauth
                </nav>
            </div>
        </header>
    @endif

    <main class="page-content">
        @if (trim($__env->yieldContent('hide_shell')))
            @if (session('status'))
                <div class="page-frame">
                    <div class="flash-banner" data-auto-dismiss="3000">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @yield('content')
        @else
            <div class="page-frame">
                @if (session('status'))
                    <div class="flash-banner" data-auto-dismiss="3000">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="flash-banner" style="background: var(--danger-soft); color: var(--danger-deep); border-color: rgba(239, 68, 68, 0.18);">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        @endif
    </main>

    @if (! trim($__env->yieldContent('hide_shell')))
        <footer class="site-footer">
            <div class="page-frame">
                <div class="site-footer-card panel">
                    <p>Stay Safe Here helps students, travelers, and teams find flexible rooms with fast booking and simple management.</p>
                </div>
            </div>
        </footer>
    @endif

    <script>
        document.querySelectorAll('[data-auto-dismiss]').forEach((banner) => {
            const delay = Number(banner.dataset.autoDismiss || 3000);

            window.setTimeout(() => {
                banner.classList.add('is-hiding');
                window.setTimeout(() => banner.remove(), 280);
            }, delay);
        });
    </script>
    @stack('scripts')
</body>
</html>
