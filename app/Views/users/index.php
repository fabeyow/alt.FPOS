<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header animate-in">
    <h1>User Accounts</h1>
    <p class="subtitle">Manage staff and system user accounts.</p>
</div>

<div class="stats-grid animate-in delay-1">
    <div class="stat-card">
        <div class="stat-icon purple">🔑</div>
        <div class="stat-value"><?= count($users) ?></div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal">🛡️</div>
        <div class="stat-value"><?= count(array_filter($users, fn($u) => $u['role'] === 'Admin')) ?></div>
        <div class="stat-label">Administrators</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">💼</div>
        <div class="stat-value"><?= count(array_filter($users, fn($u) => $u['role'] === 'Manager')) ?></div>
        <div class="stat-label">Managers</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">🧾</div>
        <div class="stat-value"><?= count(array_filter($users, fn($u) => $u['role'] === 'Cashier')) ?></div>
        <div class="stat-label">Cashiers</div>
    </div>
</div>

<div class="table-container animate-in delay-2" id="users-table-container">
    <div class="table-header">
        <h2>📋 Staff Directory</h2>
        <span class="table-badge"><?= count($users) ?> Records</span>
    </div>
    <table id="users-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
                <tr>
                    <td class="row-index"><?= $index + 1 ?></td>
                    <td><?= esc($user['username']) ?></td>
                    <td><?= esc($user['full_name']) ?></td>
                    <td>
                        <?php
                            $roleClass = match(strtolower($user['role'])) {
                                'admin'   => 'role-admin',
                                'manager' => 'role-manager',
                                'cashier' => 'role-cashier',
                                default   => 'role-staff',
                            };
                        ?>
                        <span class="role-badge <?= $roleClass ?>"><?= esc($user['role']) ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
