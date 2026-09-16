<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?? 'alt.FPOS - A modern Point-of-Sale system built with CodeIgniter 4' ?>">
    <title><?= esc($title ?? 'alt.FPOS') ?> | alt.FPOS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #0f1117;
            --bg-secondary: #1a1d27;
            --bg-card: #21242f;
            --bg-card-hover: #282c3a;
            --border-color: rgba(255, 255, 255, 0.06);
            --text-primary: #f0f2f5;
            --text-secondary: #8b8fa3;
            --text-muted: #5c6070;
            --accent-primary: #6c5ce7;
            --accent-secondary: #a29bfe;
            --accent-gradient: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
            --success: #00cec9;
            --warning: #fdcb6e;
            --danger: #ff6b6b;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.4);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .navbar {
            background: rgba(15, 17, 23, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 0 2rem;
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.35rem;
            letter-spacing: -0.5px;
        }

        .navbar-brand .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--accent-gradient);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4);
        }

        .navbar-links {
            display: flex;
            list-style: none;
            gap: 4px;
        }

        .navbar-links li a {
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
            transition: var(--transition);
            position: relative;
        }

        .navbar-links li a:hover {
            color: var(--text-primary);
            background: rgba(108, 92, 231, 0.1);
        }

        .navbar-links li a.active {
            color: var(--text-primary);
            background: rgba(108, 92, 231, 0.15);
        }

        .navbar-links li a.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background: var(--accent-gradient);
            border-radius: 2px;
        }

        .main-content {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
            width: 100%;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }

        .page-header .subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            transition: var(--transition);
        }

        .card:hover {
            border-color: rgba(108, 92, 231, 0.2);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .table-container {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .table-header {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-header h2 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .table-badge {
            background: rgba(108, 92, 231, 0.15);
            color: var(--accent-secondary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            text-align: left;
            padding: 0.9rem 1.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            background: rgba(0, 0, 0, 0.15);
        }

        table tbody tr {
            transition: var(--transition);
        }

        table tbody tr:hover {
            background: var(--bg-card-hover);
        }

        table tbody td {
            padding: 1rem 1.75rem;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        table tbody td:first-child {
            color: var(--text-primary);
            font-weight: 500;
        }

        .row-index {
            color: var(--text-muted) !important;
            font-weight: 400 !important;
            font-size: 0.8rem !important;
            width: 50px;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .role-admin {
            background: rgba(108, 92, 231, 0.15);
            color: var(--accent-secondary);
        }

        .role-manager {
            background: rgba(0, 206, 201, 0.12);
            color: var(--success);
        }

        .role-cashier {
            background: rgba(253, 203, 110, 0.12);
            color: var(--warning);
        }

        .role-staff {
            background: rgba(255, 107, 107, 0.12);
            color: var(--danger);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            border-color: rgba(108, 92, 231, 0.2);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .stat-card .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 0.25rem;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .stat-icon.purple {
            background: rgba(108, 92, 231, 0.15);
        }

        .stat-icon.teal {
            background: rgba(0, 206, 201, 0.12);
        }

        .stat-icon.yellow {
            background: rgba(253, 203, 110, 0.12);
        }

        .stat-icon.red {
            background: rgba(255, 107, 107, 0.12);
        }

        .hero {
            text-align: center;
            padding: 4rem 1rem 3rem;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(108, 92, 231, 0.12);
            color: var(--accent-secondary);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(108, 92, 231, 0.2);
        }

        .hero h1 {
            font-size: 3.2rem;
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.15;
            margin-bottom: 1.25rem;
        }

        .hero h1 .gradient-text {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero .hero-subtitle {
            font-size: 1.15rem;
            color: var(--text-secondary);
            max-width: 560px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: var(--radius-sm);
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--accent-gradient);
            color: #fff;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.5);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-outline:hover {
            color: var(--text-primary);
            border-color: rgba(108, 92, 231, 0.3);
            background: rgba(108, 92, 231, 0.05);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 2rem;
            transition: var(--transition);
        }

        .feature-card:hover {
            border-color: rgba(108, 92, 231, 0.2);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .feature-card .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1.25rem;
        }

        .feature-card h3 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 0.6rem;
        }

        .feature-card p {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .about-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 2rem;
        }

        .about-card h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .about-card ul {
            list-style: none;
        }

        .about-card ul li {
            padding: 6px 0;
            font-size: 0.9rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .about-card ul li::before {
            content: '→';
            color: var(--accent-secondary);
            font-weight: 600;
        }

        .version-info {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-top: 1.5rem;
        }

        .version-info h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .version-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .version-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .version-item .label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }

        .version-item .value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--accent-secondary);
        }

        .footer {
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.82rem;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .navbar-inner {
                flex-direction: column;
                height: auto;
                padding: 1rem 0;
                gap: 0.75rem;
            }

            .navbar-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .main-content {
                padding: 1.5rem 1rem;
            }

            table thead th,
            table tbody td {
                padding: 0.75rem 1rem;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
    </style>
</head>
<body>
    <nav class="navbar" id="main-navbar">
        <div class="navbar-inner">
            <a href="<?= base_url('/') ?>" class="navbar-brand">
                <span class="logo-icon">⚡</span>
                alt.FPOS
            </a>
            <ul class="navbar-links" id="nav-links">
                <li><a href="<?= base_url('/') ?>" class="<?= ($activeNav ?? '') === 'home' ? 'active' : '' ?>" id="nav-home">Home</a></li>
                <li><a href="<?= base_url('about') ?>" class="<?= ($activeNav ?? '') === 'about' ? 'active' : '' ?>" id="nav-about">About</a></li>
                <li><a href="<?= base_url('customers') ?>" class="<?= ($activeNav ?? '') === 'customers' ? 'active' : '' ?>" id="nav-customers">Customers</a></li>
                <li><a href="<?= base_url('users') ?>" class="<?= ($activeNav ?? '') === 'users' ? 'active' : '' ?>" id="nav-users">Users</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="footer" id="main-footer">
        <p>&copy; <?= date('Y') ?> alt.FPOS &mdash; Built with CodeIgniter <?= \CodeIgniter\CodeIgniter::CI_VERSION ?></p>
    </footer>
</body>
</html>
