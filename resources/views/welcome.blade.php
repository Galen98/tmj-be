
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Portal | Travel Murah Jogja</title>
    <meta name="theme-color" content="#f8fafc">

    <link rel="icon" href="{{ asset('images/misc/icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #0f172a;
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --muted: #64748b;
            --border: #e2e8f0;
            --background: #f8fafc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--navy);
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
        }

        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 28px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            color: var(--navy);
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .brand-subtitle {
            font-size: 11px;
            font-weight: 500;
            color: var(--muted);
            margin-top: 4px;
        }

        .nav-login {
            padding: 11px 20px;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--navy);
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            transition: .2s ease;
        }

        .nav-login:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .hero {
            flex: 1;
            width: 100%;
            max-width: 1240px;
            margin: auto;
            padding: 55px 36px 90px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 80px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--blue);
            background: #eff6ff;
            border: 1px solid #dbeafe;
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .7px;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;
            background: var(--blue);
            border-radius: 50%;
        }

        .hero-title {
            font-size: clamp(38px, 4.5vw, 60px);
            font-weight: 800;
            letter-spacing: -2.8px;
            line-height: 1.12;
            margin: 0 0 25px;
        }

        .hero-title span {
            color: var(--blue);
        }

        .hero-description {
            max-width: 510px;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.9;
            margin: 0 0 36px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            background: var(--blue);
            color: #fff;
            padding: 16px 25px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 12px 24px rgba(37, 99, 235, .15);
            transition: .2s ease;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            transform: translateY(-2px);
        }

        .access-note {
            color: #94a3b8;
            font-size: 12px;
        }

        .hero-visual {
            position: relative;
            padding: 30px;
        }

        .visual-glow {
            position: absolute;
            inset: 0;
            background: radial-gradient(
                circle,
                rgba(37,99,235,.13),
                transparent 70%
            );
            filter: blur(15px);
        }

        .preview {
            position: relative;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow:
                0 35px 75px rgba(15,23,42,.09),
                0 8px 20px rgba(15,23,42,.04);
        }

        .preview-header {
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .preview-dots {
            display: flex;
            gap: 6px;
        }

        .preview-dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e1;
        }

        .preview-dots span:first-child {
            background: #93c5fd;
        }

        .preview-label {
            font-size: 10px;
            color: #94a3b8;
            font-weight: 600;
        }

        .preview-body {
            display: grid;
            grid-template-columns: 95px 1fr;
            min-height: 310px;
        }

        .preview-sidebar {
            background: #f8fafc;
            border-right: 1px solid #f1f5f9;
            padding: 22px 12px;
        }

        .sidebar-line {
            height: 9px;
            background: #e2e8f0;
            border-radius: 4px;
            margin-bottom: 19px;
        }

        .sidebar-line.active {
            background: #bfdbfe;
        }

        .preview-main {
            padding: 24px;
        }

        .preview-heading {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .preview-subheading {
            font-size: 10px;
            color: #94a3b8;
            margin-bottom: 24px;
        }

        .preview-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 22px;
        }

        .stat {
            padding: 15px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
        }

        .stat-line {
            height: 7px;
            width: 55%;
            border-radius: 3px;
            background: #cbd5e1;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 19px;
            font-weight: 800;
            color: #1e293b;
        }

        .stat:nth-child(2) .stat-value {
            color: var(--blue);
        }

        .chart {
            display: flex;
            align-items: end;
            gap: 11px;
            height: 110px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
        }

        .chart-bar {
            flex: 1;
            background: #bfdbfe;
            border-radius: 4px 4px 0 0;
        }

        .chart-bar:nth-child(3),
        .chart-bar:nth-child(6) {
            background: #2563eb;
        }

        .visual-caption {
            position: relative;
            text-align: center;
            margin-top: 24px;
            font-size: 11px;
            color: #94a3b8;
        }

        .footer {
            padding: 25px 36px;
            border-top: 1px solid var(--border);
        }

        .footer-inner {
            max-width: 1168px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            gap: 15px;
            color: #94a3b8;
            font-size: 11px;
        }

        @media (max-width: 850px) {
            .hero {
                grid-template-columns: 1fr;
                gap: 45px;
                padding-top: 55px;
            }

            .hero-visual {
                max-width: 580px;
                width: 100%;
                margin: auto;
            }

            .hero-content {
                text-align: center;
            }

            .hero-description {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-actions {
                justify-content: center;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 20px;
            }

            .brand-logo {
                width: 42px;
                height: 42px;
            }

            .brand-title {
                font-size: 13px;
            }

            .brand-subtitle {
                font-size: 10px;
            }

            .nav-login {
                padding: 10px 13px;
                font-size: 12px;
            }

            .hero {
                padding: 60px 22px 75px;
                gap: 35px;
            }

            .hero-title {
                font-size: 37px;
                letter-spacing: -1.5px;
            }

            .hero-description {
                font-size: 14px;
            }

            .hero-visual {
                padding: 5px;
            }

            .preview-body {
                grid-template-columns: 65px 1fr;
            }

            .preview-main {
                padding: 16px;
            }

            .preview-stats {
                gap: 6px;
            }

            .stat {
                padding: 10px 8px;
            }

            .stat-value {
                font-size: 14px;
            }

            .footer-inner {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div class="page">

        <header class="navbar">
            <a href="{{ url('/') }}" class="brand">
                <img
                    src="{{ asset('images/misc/icon.png') }}"
                    alt="Travel Murah Jogja"
                    class="brand-logo"
                >

                <div>
                    <div class="brand-title">Travel Murah Jogja</div>
                    <div class="brand-subtitle">Administration Portal</div>
                </div>
            </a>

            @auth
                <a href="{{ url('/dashboard') }}" class="nav-login">
                    Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-login">
                    Login →
                </a>
            @endauth
        </header>

        <main class="hero">

            <div class="hero-content">
                <div class="eyebrow">
                    <span class="eyebrow-dot"></span>
                    TMJ Management Platform
                </div>

                <p class="hero-description">
                    Kelola produk wisata, reservasi, pelanggan,
                    dan aktivitas operasional Travel Murah Jogja
                    melalui satu sistem administrasi yang
                    terintegrasi, efisien, dan mudah digunakan.
                </p>

                <div class="hero-actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            Buka Dashboard <span>→</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">
                            Masuk ke Admin Portal <span>→</span>
                        </a>
                    @endauth

                    <span class="access-note">
                        Internal Access Only
                    </span>
                </div>
            </div>

            <div class="hero-visual">
                <div class="visual-glow"></div>

                <div class="preview">
                    <div class="preview-header">
                        <div class="preview-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <span class="preview-label">
                            TMJ / Administration
                        </span>
                    </div>

                    <div class="preview-body">
                        <div class="preview-sidebar">
                            <div class="sidebar-line active"></div>
                            <div class="sidebar-line"></div>
                            <div class="sidebar-line"></div>
                            <div class="sidebar-line"></div>
                        </div>

                        <div class="preview-main">
                            <div class="preview-heading">
                                Dashboard Overview
                            </div>

                            <div class="preview-subheading">
                                Operational management preview
                            </div>

                            <div class="preview-stats">
                                <div class="stat">
                                    <div class="stat-line"></div>
                                    <div class="stat-value">128</div>
                                </div>

                                <div class="stat">
                                    <div class="stat-line"></div>
                                    <div class="stat-value">64</div>
                                </div>

                                <div class="stat">
                                    <div class="stat-line"></div>
                                    <div class="stat-value">92%</div>
                                </div>
                            </div>

                            <div class="chart">
                                <div class="chart-bar" style="height:35%"></div>
                                <div class="chart-bar" style="height:60%"></div>
                                <div class="chart-bar" style="height:48%"></div>
                                <div class="chart-bar" style="height:75%"></div>
                                <div class="chart-bar" style="height:55%"></div>
                                <div class="chart-bar" style="height:90%"></div>
                                <div class="chart-bar" style="height:70%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>

        <footer class="footer">
            <div class="footer-inner">
                <span>
                    © {{ date('Y') }} Travel Murah Jogja.
                    All rights reserved.
                </span>

                <span>
                    TMJ Administration System
                </span>
            </div>
        </footer>

    </div>
</body>
</html>
