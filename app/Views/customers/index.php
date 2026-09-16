<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header animate-in">
    <h1>Customer Accounts</h1>
    <p class="subtitle">Browse all registered customer records in the system.</p>
</div>

<div class="stats-grid animate-in delay-1">
    <div class="stat-card">
        <div class="stat-icon purple">👥</div>
        <div class="stat-value"><?= count($customers) ?></div>
        <div class="stat-label">Total Customers</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal">📧</div>
        <div class="stat-value"><?= count($customers) ?></div>
        <div class="stat-label">Email Addresses</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">📱</div>
        <div class="stat-value"><?= count($customers) ?></div>
        <div class="stat-label">Phone Numbers</div>
    </div>
</div>

<div class="table-container animate-in delay-2" id="customers-table-container">
    <div class="table-header">
        <h2>📋 Customer Directory</h2>
        <span class="table-badge"><?= count($customers) ?> Records</span>
    </div>
    <table id="customers-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $index => $customer): ?>
                <tr>
                    <td class="row-index"><?= $index + 1 ?></td>
                    <td><?= esc($customer['full_name']) ?></td>
                    <td><?= esc($customer['email']) ?></td>
                    <td><?= esc($customer['phone']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
