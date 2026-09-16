<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header animate-in">
    <h1>About alt.FPOS</h1>
    <p class="subtitle">Learn more about this project and the technologies behind it.</p>
</div>

<div class="about-grid">
    <div class="about-card animate-in delay-1">
        <h3>📋 Project Overview</h3>
        <ul>
            <li>Basic Point-of-Sale (POS) system</li>
            <li>Four-page CodeIgniter 4 web application</li>
            <li>Static PHP arrays as temporary data source</li>
            <li>No database involved in this version</li>
            <li>MVC architecture with clean routing</li>
        </ul>
    </div>

    <div class="about-card animate-in delay-2">
        <h3>🛠️ Tech Stack</h3>
        <ul>
            <li>PHP 8.x with CodeIgniter 4 framework</li>
            <li>Composer for dependency management</li>
            <li>XAMPP local development server</li>
            <li>Pure CSS with modern design patterns</li>
            <li>Responsive, mobile-friendly layout</li>
        </ul>
    </div>

    <div class="about-card animate-in delay-3">
        <h3>📄 Pages</h3>
        <ul>
            <li><strong>Home</strong> — Landing page with overview</li>
            <li><strong>About</strong> — Project details and tech stack</li>
            <li><strong>Customers</strong> — Customer accounts listing</li>
            <li><strong>Users</strong> — Staff / user accounts listing</li>
        </ul>
    </div>

    <div class="about-card animate-in delay-4">
        <h3>🚧 Roadmap</h3>
        <ul>
            <li>Database integration (MySQL)</li>
            <li>CRUD operations for all records</li>
            <li>Authentication &amp; login system</li>
            <li>Product inventory management</li>
            <li>Sales transaction processing</li>
        </ul>
    </div>
</div>

<div class="version-info animate-in delay-4">
    <h3>⚙️ Environment</h3>
    <div class="version-grid">
        <div class="version-item">
            <span class="label">CodeIgniter</span>
            <span class="value"><?= \CodeIgniter\CodeIgniter::CI_VERSION ?></span>
        </div>
        <div class="version-item">
            <span class="label">PHP Version</span>
            <span class="value"><?= PHP_VERSION ?></span>
        </div>
        <div class="version-item">
            <span class="label">Environment</span>
            <span class="value"><?= ENVIRONMENT ?></span>
        </div>
        <div class="version-item">
            <span class="label">Server</span>
            <span class="value">XAMPP (Apache)</span>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
