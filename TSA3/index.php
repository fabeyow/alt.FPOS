<?php
/**
 * alt.FPOS — Main Router & Home Page
 * Plain PHP POS application for InfinityFree hosting
 */
session_start();

// Determine the current page from query string
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Base URL helper — auto-detect for both localhost and InfinityFree
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$baseUrl = $protocol . '://' . $host . $scriptDir;

/**
 * Generate a URL relative to the application root.
 */
function url($path = '') {
    global $baseUrl;
    return $baseUrl . '/' . ltrim($path, '/');
}

/**
 * Escape output for HTML.
 */
function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Get and clear a flash message from the session.
 */
function flash($key) {
    if (isset($_SESSION['flash_' . $key])) {
        $msg = $_SESSION['flash_' . $key];
        unset($_SESSION['flash_' . $key]);
        return $msg;
    }
    return null;
}

/**
 * Set a flash message in the session.
 */
function set_flash($key, $value) {
    $_SESSION['flash_' . $key] = $value;
}

// Route to the appropriate page
switch ($page) {
    case 'customers':
        require 'customers.php';
        break;
    case 'users':
        require 'users.php';
        break;
    case 'home':
    default:
        renderHome();
        break;
}

/**
 * Render the Home page.
 */
function renderHome() {
    $title = 'Home';
    $activeNav = 'home';
    
    ob_start();
    ?>
    <section class="hero animate-in" id="hero-section">
        <span class="hero-badge">🚀 Version 1.0 — Now Live</span>
        <h1>
            Smarter Sales with<br>
            <span class="gradient-text">alt.FPOS</span>
        </h1>
        <p class="hero-subtitle">
            A modern, lightweight Point-of-Sale system built with PHP. Manage customers, track users, and streamline your retail operations — all from one dashboard.
        </p>
        <div class="hero-actions">
            <a href="<?= url('index.php?page=customers') ?>" class="btn btn-primary" id="btn-view-customers">
                👥 View Customers
            </a>
            <a href="<?= url('index.php?page=users') ?>" class="btn btn-outline" id="btn-view-users">
                👤 Manage Users
            </a>
        </div>
    </section>

    <section class="features-grid" id="features-section">
        <div class="feature-card animate-in delay-1">
            <div class="feature-icon stat-icon purple">👥</div>
            <h3>Customer Management</h3>
            <p>Keep track of your customer base with organized contact records including names, emails, and phone numbers.</p>
        </div>
        <div class="feature-card animate-in delay-2">
            <div class="feature-icon stat-icon teal">👤</div>
            <h3>User &amp; Role Control</h3>
            <p>Manage staff accounts and assign roles — Admins, Managers, Cashiers — to maintain operational clarity.</p>
        </div>
        <div class="feature-card animate-in delay-3">
            <div class="feature-icon stat-icon yellow">🖼️</div>
            <h3>Avatar Upload</h3>
            <p>Upload and manage profile pictures for user accounts, with automatic display-ready thumbnail preparation.</p>
        </div>
    </section>
    <?php
    $content = ob_get_clean();
    renderLayout($title, $activeNav, $content);
}

/**
 * Main layout wrapper — shared by all pages.
 */
function renderLayout($title, $activeNav, $content) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="alt.FPOS - A modern Point-of-Sale system">
    <title><?= esc($title) ?> | alt.FPOS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('style.css') ?>">
</head>
<body>
    <nav class="navbar" id="main-navbar">
        <div class="navbar-inner">
            <a href="<?= url('index.php') ?>" class="navbar-brand">
                <span class="logo-icon">💳</span>
                alt.FPOS
            </a>
            <ul class="navbar-links" id="nav-links">
                <li><a href="<?= url('index.php') ?>" class="<?= $activeNav === 'home' ? 'active' : '' ?>" id="nav-home">Home</a></li>
                <li><a href="<?= url('index.php?page=customers') ?>" class="<?= $activeNav === 'customers' ? 'active' : '' ?>" id="nav-customers">Customers</a></li>
                <li><a href="<?= url('index.php?page=users') ?>" class="<?= $activeNav === 'users' ? 'active' : '' ?>" id="nav-users">Users</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <?= $content ?>
    </main>

    <footer class="footer" id="main-footer">
        <p>&copy; <?= date('Y') ?> alt.FPOS &mdash; Built with PHP</p>
    </footer>
</body>
</html>
<?php
}
