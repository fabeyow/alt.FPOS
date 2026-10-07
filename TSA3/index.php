<?php
/**
 * alt.FPOS — Main Router & Home Page
 * Plain PHP POS application for InfinityFree hosting
 * Includes: authentication, login/logout, auth filter
 */
session_start();
require_once 'db_connect.php';

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

/**
 * Check if the current user is logged in.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Auth Filter — Redirect to login if not authenticated.
 * Call this at the top of any protected page.
 */
function require_login() {
    if (!is_logged_in()) {
        set_flash('error', 'Please log in to access that page.');
        header('Location: ' . url('index.php?page=login'));
        exit;
    }
}

/**
 * Get the currently logged-in user's data from the session.
 */
function current_user() {
    if (!is_logged_in()) return null;
    return [
        'id'        => $_SESSION['user_id'],
        'username'  => $_SESSION['user_username'],
        'full_name' => $_SESSION['user_full_name'],
        'role'      => $_SESSION['user_role'],
    ];
}

// Route to the appropriate page
switch ($page) {
    case 'login':
        handleLogin();
        break;
    case 'logout':
        handleLogout();
        break;
    case 'customers':
        require_login();
        require 'customers.php';
        break;
    case 'users':
        require_login();
        require 'users.php';
        break;
    case 'home':
    default:
        renderHome();
        break;
}

/* ────────────────────────────────────────────────
   LOGIN — Login page and authentication
   ──────────────────────────────────────────────── */
function handleLogin() {
    // If already logged in, redirect to home
    if (is_logged_in()) {
        header('Location: ' . url('index.php'));
        exit;
    }

    // Handle POST (form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $conn;

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors   = [];

        if (empty($username)) {
            $errors['username'] = 'Username is required.';
        }
        if (empty($password)) {
            $errors['password'] = 'Password is required.';
        }

        if (empty($errors)) {
            // Look up user by username
            $stmt = $conn->prepare("SELECT id, username, password, full_name, role FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($user && password_verify($password, $user['password'])) {
                // Success — store user data in session
                $_SESSION['user_id']        = $user['id'];
                $_SESSION['user_username']  = $user['username'];
                $_SESSION['user_full_name'] = $user['full_name'];
                $_SESSION['user_role']      = $user['role'];

                set_flash('success', 'Welcome back, ' . $user['full_name'] . '!');
                header('Location: ' . url('index.php'));
                exit;
            } else {
                $errors['login'] = 'Invalid username or password.';
            }
        }

        set_flash('errors', $errors);
        set_flash('old', ['username' => $username]);
        header('Location: ' . url('index.php?page=login'));
        exit;
    }

    // Handle GET (show login form)
    $errors = flash('errors');
    $old    = flash('old');
    $error  = flash('error');

    // Render login page with its own minimal layout (no navbar)
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login to alt.FPOS - Point of Sale System">
    <title>Login | alt.FPOS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('style.css?v=1.1') ?>">
</head>
<body>
    <div class="login-page">
        <div class="login-card animate-in">
            <div class="login-header">
                <div class="login-logo">
                    <span class="logo-icon">💳</span>
                </div>
                <h1>alt.FPOS</h1>
                <p class="subtitle">Sign in to your account</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">🔒 <?= esc($error) ?></div>
            <?php endif; ?>

            <?php if (isset($errors['login'])): ?>
                <div class="alert alert-danger">❌ <?= esc($errors['login']) ?></div>
            <?php endif; ?>

            <form action="<?= url('index.php?page=login') ?>" method="post" id="login-form">
                <div class="form-group">
                    <label for="username" class="form-label">Username <span class="required">*</span></label>
                    <input type="text" id="username" name="username"
                           class="form-input <?= isset($errors['username']) ? 'input-error' : '' ?>"
                           value="<?= esc($old['username'] ?? '') ?>"
                           placeholder="e.g. admin_jose" required autofocus>
                    <?php if (isset($errors['username'])): ?>
                        <p class="error-text"><?= esc($errors['username']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password"
                           class="form-input <?= isset($errors['password']) ? 'input-error' : '' ?>"
                           placeholder="Enter your password" required>
                    <?php if (isset($errors['password'])): ?>
                        <p class="error-text"><?= esc($errors['password']) ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-login" id="login-btn">
                    🔐 Sign In
                </button>
            </form>

            <div class="login-footer">
                <p>Default credentials: <code>admin_jose</code> / <code>password123</code></p>
            </div>
        </div>
    </div>
</body>
</html>
    <?php
    exit;
}

/* ────────────────────────────────────────────────
   LOGOUT — Destroy session and redirect
   ──────────────────────────────────────────────── */
function handleLogout() {
    // Clear all session data
    $_SESSION = [];

    // Destroy the session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }

    session_destroy();

    // Start a new session just for the flash message
    session_start();
    set_flash('error', 'You have been logged out.');
    header('Location: ' . url('index.php?page=login'));
    exit;
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
            <?php if (is_logged_in()): ?>
                <a href="<?= url('index.php?page=customers') ?>" class="btn btn-primary" id="btn-view-customers">
                    👥 View Customers
                </a>
                <a href="<?= url('index.php?page=users') ?>" class="btn btn-outline" id="btn-view-users">
                    👤 Manage Users
                </a>
            <?php else: ?>
                <a href="<?= url('index.php?page=login') ?>" class="btn btn-primary" id="btn-login">
                    🔐 Sign In
                </a>
            <?php endif; ?>
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
            <div class="feature-icon stat-icon yellow">🔐</div>
            <h3>Secure Access</h3>
            <p>Password-protected accounts with session-based authentication. Only authorized users can manage records.</p>
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
    $user = current_user();
    $success = flash('success');
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
    <link rel="stylesheet" href="<?= url('style.css?v=1.1') ?>">
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
                <?php if ($user): ?>
                    <li><a href="<?= url('index.php?page=customers') ?>" class="<?= $activeNav === 'customers' ? 'active' : '' ?>" id="nav-customers">Customers</a></li>
                    <li><a href="<?= url('index.php?page=users') ?>" class="<?= $activeNav === 'users' ? 'active' : '' ?>" id="nav-users">Users</a></li>
                    <li class="nav-user-info">
                        <span class="nav-greeting">👤 <?= esc($user['full_name']) ?></span>
                    </li>
                    <li><a href="<?= url('index.php?page=logout') ?>" class="nav-logout" id="nav-logout">🚪 Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= url('index.php?page=login') ?>" class="<?= $activeNav === 'login' ? 'active' : '' ?>" id="nav-login">🔐 Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <?php if ($success): ?>
            <div class="alert alert-success animate-in">✅ <?= esc($success) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </main>

    <footer class="footer" id="main-footer">
        <p>&copy; <?= date('Y') ?> alt.FPOS &mdash; Built with PHP</p>
    </footer>
</body>
</html>
<?php
}
