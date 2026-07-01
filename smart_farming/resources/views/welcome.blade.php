<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AgroPredict — Sistem Rekomendasi Tanaman Cerdas</title>
    <meta name="description" content="AgroPredict — Analisis kondisi lahan dan dapatkan rekomendasi tanaman terbaik berbasis Machine Learning.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f8f7f4; color: #1a1a1a; overflow-x: hidden; }

        /* ── Color Tokens ── */
        :root {
            --olive:       #4a6741;
            --olive-dark:  #3a5233;
            --olive-light: #6b8c5e;
            --cream:       #f8f7f4;
            --cream-dark:  #edeae3;
            --sage:        #b8c9a3;
            --text-dark:   #1b2e1b;
            --text-muted:  #6b7c6b;
        }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-12px); }
        }
        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%      { opacity: .5; }
        }
        .anim-1 { animation: fadeInUp .8s ease-out both; }
        .anim-2 { animation: fadeInUp .8s ease-out .15s both; }
        .anim-3 { animation: fadeInUp .8s ease-out .3s both; }
        .anim-4 { animation: fadeInUp .8s ease-out .45s both; }
        .anim-r { animation: fadeInRight .8s ease-out .4s both; }

        /* ══════════════════════════════════════════════
           HERO SECTION
        ══════════════════════════════════════════════ */
        .hero-section {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Background */
        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center bottom;
        }
        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(248,247,244,0.92) 0%,
                rgba(248,247,244,0.80) 35%,
                rgba(248,247,244,0.45) 60%,
                rgba(248,247,244,0.15) 80%,
                rgba(248,247,244,0.05) 100%
            );
        }

        /* ── Navigation ── */
        .top-nav {
            position: relative;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 48px;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 36px; height: 36px;
            color: var(--olive);
        }
        .nav-logo-text {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }
        .nav-logo-text span {
            font-weight: 400;
            color: var(--olive);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
            list-style: none;
        }
        .nav-links a {
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            transition: color .2s;
            position: relative;
        }
        .nav-links a:hover { color: var(--olive); }
        .nav-links .badge-new {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 8px;
            background: var(--olive);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            border-radius: 6px;
            margin-left: 6px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: var(--olive);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            transition: all .3s;
        }
        .btn-nav:hover { background: var(--olive-dark); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(74,103,65,0.3); }
        .hamburger {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            transition: background .2s;
        }
        .hamburger:hover { background: var(--olive-dark); }
        .hamburger svg { width: 20px; height: 20px; color: #fff; }

        /* ── Hero Content ── */
        .hero-content {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            align-items: center;
            padding: 0 48px;
            padding-bottom: 40px;
        }
        .hero-left {
            flex: 1;
            max-width: 600px;
        }
        .hero-title {
            font-size: clamp(48px, 7vw, 88px);
            font-weight: 900;
            line-height: 0.95;
            letter-spacing: -2px;
            text-transform: uppercase;
            color: var(--text-dark);
            margin-bottom: 24px;
        }
        .hero-title .green {
            color: var(--olive);
        }
        .hero-subtitle {
            font-size: 17px;
            font-weight: 400;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 36px;
            max-width: 340px;
        }
        .btn-discover {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 28px;
            background: var(--olive);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            transition: all .3s;
        }
        .btn-discover:hover { background: var(--olive-dark); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(74,103,65,0.35); }
        .btn-discover .arrow-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .3s;
        }
        .btn-discover:hover .arrow-circle { background: rgba(255,255,255,0.4); }
        .btn-discover .arrow-circle svg {
            width: 16px;
            height: 16px;
            color: #fff;
        }

        /* ── Hero Center (Plant Circle) ── */
        .hero-center {
            position: absolute;
            right: 15%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }
        .plant-orbit {
            position: relative;
            width: 380px;
            height: 380px;
        }
        .orbit-ring {
            position: absolute;
            inset: 0;
            border: 2px dashed rgba(74,103,65,0.25);
            border-radius: 50%;
            animation: spinSlow 30s linear infinite;
        }
        .orbit-dot {
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--olive);
            box-shadow: 0 0 0 4px rgba(74,103,65,0.2);
        }
        .plant-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle at center, rgba(184,201,163,0.4) 0%, rgba(184,201,163,0.1) 70%, transparent 100%);
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            animation: floatSlow 6s ease-in-out infinite;
        }
        .plant-circle img {
            width: 220px;
            height: 220px;
            object-fit: contain;
            object-position: bottom center;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.15));
        }

        /* ── Hero Right Info ── */
        .hero-right-info {
            position: absolute;
            right: 48px;
            top: 35%;
            z-index: 15;
            text-align: right;
            max-width: 200px;
        }
        .eco-icon {
            width: 56px; height: 56px;
            border-radius: 50%;
            border: 1.5px solid rgba(74,103,65,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-bottom: 14px;
            color: var(--olive);
        }
        .hero-right-text {
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
            line-height: 1.5;
            margin-bottom: 14px;
        }
        .eco-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border: 1.5px solid rgba(74,103,65,0.3);
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            color: var(--olive);
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(8px);
        }
        .eco-badge svg { width: 18px; height: 18px; }

        /* ── Bottom Cards ── */
        .hero-bottom {
            position: relative;
            z-index: 15;
            display: flex;
            align-items: stretch;
            gap: 0;
            margin: 0 48px;
            margin-top: -20px;
            margin-bottom: 0;
        }
        .bottom-image-card {
            width: 280px;
            height: 200px;
            border-radius: 20px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 12px 40px rgba(0,0,0,0.1);
        }
        .bottom-image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .bottom-info-card {
            flex: 1;
            background: #fff;
            border-radius: 20px;
            padding: 28px 32px;
            margin-left: -16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            z-index: 2;
        }
        .bottom-info-icon {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--olive);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }
        .bottom-info-icon svg { width: 20px; height: 20px; color: #fff; }
        .bottom-info-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        .bottom-info-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }
        .bottom-stat-card {
            width: 260px;
            background: var(--olive);
            border-radius: 20px;
            padding: 28px 32px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: -16px;
            color: #fff;
            box-shadow: 0 12px 40px rgba(74,103,65,0.3);
            z-index: 3;
        }
        .stat-avatars {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }
        .stat-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2.5px solid var(--olive);
            margin-left: -10px;
            background: var(--sage);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--olive-dark);
        }
        .stat-avatar:first-child { margin-left: 0; }
        .stat-avatar.plus {
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
        }
        .stat-number {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: 14px;
            font-weight: 500;
            opacity: 0.85;
        }

        /* ══════════════════════════════════════════════
           FEATURES SECTION (below fold)
        ══════════════════════════════════════════════ */
        .features-section {
            background: var(--cream);
            padding: 80px 48px;
        }
        .features-header {
            text-align: center;
            margin-bottom: 56px;
        }
        .features-header h2 {
            font-size: 38px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 12px;
            letter-spacing: -1px;
        }
        .features-header p {
            font-size: 16px;
            color: var(--text-muted);
            max-width: 500px;
            margin: 0 auto;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }
        .feature-card {
            background: #fff;
            border-radius: 24px;
            padding: 36px 32px;
            border: 1px solid #eee;
            transition: all .35s ease;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.08);
            border-color: var(--sage);
        }
        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            background: #f0f5ec;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--olive);
            transition: all .3s;
        }
        .feature-card:hover .feature-icon {
            background: var(--olive);
            color: #fff;
        }
        .feature-icon svg { width: 24px; height: 24px; }
        .feature-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
        }
        .feature-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* ══════════════════════════════════════════════
           CTA SECTION
        ══════════════════════════════════════════════ */
        .cta-section {
            padding: 80px 48px;
            background: var(--cream);
        }
        .cta-inner {
            max-width: 1100px;
            margin: 0 auto;
            background: var(--text-dark);
            border-radius: 32px;
            padding: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            overflow: hidden;
            position: relative;
        }
        .cta-inner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: var(--olive);
            border-radius: 50%;
            opacity: .15;
            filter: blur(80px);
        }
        .cta-text h2 {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        .cta-text p {
            font-size: 16px;
            color: rgba(255,255,255,0.7);
            line-height: 1.6;
            max-width: 460px;
        }
        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: #fff;
            color: var(--text-dark);
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            transition: all .3s;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
        }
        .btn-cta:hover { background: var(--sage); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
        .btn-cta .arrow-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--olive);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-cta .arrow-circle svg { width: 16px; height: 16px; color: #fff; }

        /* ══════════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════════ */
        .site-footer {
            background: var(--cream);
            border-top: 1px solid #e8e5de;
            padding: 40px 48px;
        }
        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .footer-inner p {
            font-size: 13px;
            color: var(--text-muted);
        }
        .footer-links {
            display: flex;
            gap: 24px;
        }
        .footer-links a {
            font-size: 13px;
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }
        .footer-links a:hover { color: var(--olive); }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .hero-center { display: none; }
            .hero-right-info { display: none; }
            .top-nav { padding: 20px 24px; }
            .nav-links { display: none; }
            .hero-content { padding: 0 24px; padding-bottom: 40px; }
            .hero-bottom { flex-direction: column; margin: 0 24px; gap: 12px; }
            .bottom-image-card { width: 100%; height: 180px; }
            .bottom-info-card { margin-left: 0; }
            .bottom-stat-card { margin-left: 0; width: 100%; }
            .features-section { padding: 60px 24px; }
            .features-grid { grid-template-columns: 1fr; }
            .cta-section { padding: 60px 24px; }
            .cta-inner { flex-direction: column; padding: 40px 32px; text-align: center; }
            .site-footer { padding: 32px 24px; }
            .footer-inner { flex-direction: column; gap: 16px; text-align: center; }
        }
        @media (max-width: 640px) {
            .hero-title { font-size: 42px; letter-spacing: -1px; }
        }
    </style>
</head>
<body class="antialiased">

    <!-- ═══════════════════════════════════════════════
         HERO SECTION
    ═══════════════════════════════════════════════ -->
    <section class="hero-section">

        <!-- Background Image -->
        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=2940&auto=format&fit=crop" alt="Lahan pertanian hijau">
        </div>

        <!-- Navigation -->
        <nav class="top-nav">
            <a href="/" class="nav-logo">
                <img src="{{ asset('images/agropredict-logo.png') }}" alt="AgroPredict" class="nav-logo-icon" style="width:36px; height:36px; object-fit:contain;">
                <span class="nav-logo-text">Agro<span>Predict</span></span>
            </a>

            <ul class="nav-links">
                <li><a href="#hero">Beranda</a></li>
                <li><a href="#features">Tentang</a></li>
                <li><a href="#features">Fitur</a></li>
                <li>
                    <a href="#features">Produk <span class="badge-new">NEW</span></a>
                </li>
                <li><a href="#cta">Kontak</a></li>
            </ul>

            <div class="nav-right">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nav">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav">Masuk</a>
                    @endauth
                @endif
                <button class="hamburger" aria-label="Menu">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="hero-content">

            <!-- Left: Title -->
            <div class="hero-left">
                <h1 class="hero-title anim-1">
                    TANAM<br>
                    <span class="green">CERDAS</span><br>
                    PANEN LEBIH
                </h1>
                <p class="hero-subtitle anim-2">
                    Solusi rekomendasi tanaman berbasis data untuk masa depan pertanian yang berkelanjutan.
                </p>
                @auth
                    <a href="{{ route('crop.form') }}" class="btn-discover anim-3">
                        Mulai Analisis
                        <span class="arrow-circle">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-discover anim-3">
                        Mulai Sekarang
                        <span class="arrow-circle">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </span>
                    </a>
                @endauth
            </div>

            <!-- Center: Plant Circle -->
            <div class="hero-center anim-r">
                <div class="plant-orbit">
                    <div class="orbit-ring">
                        <div class="orbit-dot"></div>
                    </div>
                    <div class="plant-circle">
                        <img src="https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?q=80&w=600&auto=format&fit=crop" alt="Tanaman tumbuh">
                    </div>
                </div>
            </div>

            <!-- Right Info -->
            <div class="hero-right-info anim-r">
                <div class="eco-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" width="28" height="28">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/>
                    </svg>
                </div>
                <p class="hero-right-text">
                    Menjaga alam dengan prediksi tanaman yang akurat
                </p>
                <div class="eco-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                    </svg>
                    Berbasis AI
                </div>
            </div>
        </div>

        <!-- Bottom Cards -->
        <div class="hero-bottom anim-4">
            <!-- Image Card -->
            <div class="bottom-image-card">
                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop" alt="Lahan pertanian">
            </div>

            <!-- Info Card -->
            <div class="bottom-info-card">
                <div class="bottom-info-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <h3 class="bottom-info-title">Akurasi yang Bisa Dipercaya</h3>
                <p class="bottom-info-desc">Model prediksi kami dilatih dengan 2.200+ sampel data tanah untuk memberikan rekomendasi terbaik.</p>
            </div>

            <!-- Stat Card -->
            <div class="bottom-stat-card">
                <div class="stat-avatars">
                    <div class="stat-avatar">N</div>
                    <div class="stat-avatar">P</div>
                    <div class="stat-avatar">K</div>
                    <div class="stat-avatar plus">+</div>
                </div>
                <div class="stat-number">99.7%</div>
                <div class="stat-label">Akurasi Prediksi</div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         FEATURES SECTION
    ═══════════════════════════════════════════════ -->
    <section id="features" class="features-section">
        <div class="features-header">
            <h2>Mengapa AgroPredict?</h2>
            <p>Fitur-fitur yang dirancang untuk membantu petani mengambil keputusan berbasis data.</p>
        </div>

        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 0 1 2 2v1a2 2 0 0 0 2 2 2 2 0 0 1 2 2v2.945M8 3.935V5.5A2.5 2.5 0 0 0 10.5 8h.5a2 2 0 0 1 2 2 2 2 0 1 0 4 0 2 2 0 0 1 2-2h1.064M15 20.488V18a2 2 0 0 1 2-2h3.064M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <h3 class="feature-title">Rekomendasi Tanaman</h3>
                <p class="feature-desc">Masukkan data nutrisi tanah (N, P, K), suhu, kelembaban, pH, dan curah hujan untuk mendapatkan rekomendasi tanaman paling cocok.</p>
            </div>

            <!-- Feature 2 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                </div>
                <h3 class="feature-title">Dashboard Analitik</h3>
                <p class="feature-desc">Visualisasi distribusi prediksi, rata-rata parameter tanah, dan tren data riwayat dalam dashboard interaktif.</p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <h3 class="feature-title">Riwayat & Evaluasi</h3>
                <p class="feature-desc">Simpan seluruh riwayat prediksi, edit data, bandingkan hasil, dan rencanakan musim tanam berikutnya.</p>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         CTA SECTION
    ═══════════════════════════════════════════════ -->
    <section id="cta" class="cta-section">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Siap Mengoptimalkan Lahan Anda?</h2>
                <p>Bergabunglah dan gunakan teknologi prediksi berbasis AI untuk meningkatkan produktivitas pertanian Anda.</p>
            </div>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-cta">
                    Buka Dashboard
                    <span class="arrow-circle">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </span>
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-cta">
                    Daftar Gratis
                    <span class="arrow-circle">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </span>
                </a>
            @endauth
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════ -->
    <footer class="site-footer">
        <div class="footer-inner">
            <a href="/" class="nav-logo" style="text-decoration:none;">
                <img src="{{ asset('images/agropredict-logo.png') }}" alt="AgroPredict" class="nav-logo-icon" style="width:28px; height:28px; object-fit:contain;">
                <span class="nav-logo-text" style="font-size:16px;">Agro<span>Predict</span></span>
            </a>
            <p>&copy; {{ date('Y') }} AgroPredict — Tugas Akhir Pemrograman Web Berbasis Framework.</p>
            <div class="footer-links">
                <a href="#">Tentang</a>
                <a href="#">Privasi</a>
                @guest <a href="{{ route('login') }}">Masuk</a> @endguest
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Drawer -->
    <div id="mobile-menu" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="absolute right-0 top-0 bottom-0 w-64 bg-white p-6 shadow-xl flex flex-col gap-6 translate-x-full transition-transform duration-300">
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-gray-900" style="font-family:'Inter', sans-serif;">Menu</span>
                <button id="close-menu" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors border-none cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <ul class="flex flex-col gap-4 list-none" style="padding:0; margin:0; font-family:'Inter', sans-serif;">
                <li><a href="#hero" class="text-base font-semibold text-gray-700 hover:text-green-700 transition-colors" style="text-decoration:none;">Beranda</a></li>
                <li><a href="#features" class="text-base font-semibold text-gray-700 hover:text-green-700 transition-colors" style="text-decoration:none;">Tentang</a></li>
                <li><a href="#features" class="text-base font-semibold text-gray-700 hover:text-green-700 transition-colors" style="text-decoration:none;">Fitur</a></li>
                <li><a href="#cta" class="text-base font-semibold text-gray-700 hover:text-green-700 transition-colors" style="text-decoration:none;">Kontak</a></li>
            </ul>
            <div class="mt-auto border-t pt-4" style="border-color:#F3F4F6; font-family:'Inter', sans-serif;">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nav w-full justify-center" style="text-decoration:none; display:flex; justify-content:center;">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav w-full justify-center" style="text-decoration:none; display:flex; justify-content:center;">Masuk</a>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <script>
        const hamburgerBtn = document.querySelector('.hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuDrawer = mobileMenu.querySelector('.absolute');
        const closeMenuBtn = document.getElementById('close-menu');
        const mobileLinks = mobileMenu.querySelectorAll('a');

        function openMenu() {
            mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
            menuDrawer.classList.remove('translate-x-full');
        }

        function closeMenu() {
            mobileMenu.classList.add('opacity-0', 'pointer-events-none');
            menuDrawer.classList.add('translate-x-full');
        }

        hamburgerBtn.addEventListener('click', openMenu);
        closeMenuBtn.addEventListener('click', closeMenu);
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) closeMenu();
        });
        mobileLinks.forEach(link => link.addEventListener('click', closeMenu));
    </script>

</body>
</html>
