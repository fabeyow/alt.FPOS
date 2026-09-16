<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="hero animate-in" id="hero-section">
    <span class="hero-badge">🚀 Version 1.0 — Now Live</span>
    <h1>
        Smarter Sales with<br>
        <span class="gradient-text">alt.FPOS</span>
    </h1>
    <p class="hero-subtitle">
        A modern, lightweight Point-of-Sale system built with CodeIgniter 4. Manage customers, track users, and streamline your retail operations — all from one dashboard.
    </p>
    <div class="hero-actions">
        <a href="<?= base_url('customers') ?>" class="btn btn-primary" id="btn-view-customers">
            👥 View Customers
        </a>
        <a href="<?= base_url('users') ?>" class="btn btn-outline" id="btn-view-users">
            🔑 Manage Users
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
        <div class="feature-icon stat-icon teal">🔑</div>
        <h3>User &amp; Role Control</h3>
        <p>Manage staff accounts and assign roles — Admins, Managers, Cashiers — to maintain operational clarity.</p>
    </div>
    <div class="feature-card animate-in delay-3">
        <div class="feature-icon stat-icon yellow">⚡</div>
        <h3>Built on CodeIgniter 4</h3>
        <p>Powered by a lightweight PHP framework with MVC architecture, making it fast, secure, and easy to extend.</p>
    </div>
</section>

<?= $this->endSection() ?>
