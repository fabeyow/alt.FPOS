<?php
/**
 * alt.FPOS — Customer Accounts
 * Handles: listing, new, create, edit, update
 */
require_once 'db_connect.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch ($action) {
    case 'new':
        handleNew();
        break;
    case 'create':
        handleCreate();
        break;
    case 'edit':
        handleEdit();
        break;
    case 'update':
        handleUpdate();
        break;
    case 'list':
    default:
        handleList();
        break;
}

/* ────────────────────────────────────────────────
   LIST — Show all customers
   ──────────────────────────────────────────────── */
function handleList() {
    global $conn;
    $result    = $conn->query("SELECT * FROM customers ORDER BY id ASC");
    $customers = $result->fetch_all(MYSQLI_ASSOC);
    $success   = flash('success');
    $total     = count($customers);

    ob_start();
    ?>
    <div class="page-header animate-in">
        <div class="page-header-row">
            <div>
                <h1>Customer Accounts</h1>
                <p class="subtitle">Browse all registered customer records in the system.</p>
            </div>
            <a href="<?= url('index.php?page=customers&action=new') ?>" class="btn btn-primary" id="add-customer-btn">➕ New Customer</a>
        </div>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success animate-in delay-1">✅ <?= esc($success) ?></div>
    <?php endif; ?>

    <div class="stats-grid animate-in delay-1">
        <div class="stat-card">
            <div class="stat-icon purple">👥</div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Customers</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon teal">📧</div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Email Addresses</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">📞</div>
            <div class="stat-value"><?= count(array_filter($customers, fn($c) => !empty($c['phone']))) ?></div>
            <div class="stat-label">Phone Numbers</div>
        </div>
    </div>

    <div class="table-container animate-in delay-2" id="customers-table-container">
        <div class="table-header">
            <h2>📋 Customer Directory</h2>
            <span class="table-badge"><?= $total ?> Records</span>
        </div>
        <table id="customers-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $i => $c): ?>
                <tr>
                    <td class="row-index"><?= $i + 1 ?></td>
                    <td><?= esc($c['full_name']) ?></td>
                    <td><?= esc($c['email']) ?></td>
                    <td><?= esc($c['phone']) ?></td>
                    <td>
                        <a href="<?= url('index.php?page=customers&action=edit&id=' . $c['id']) ?>" class="btn-action btn-edit" title="Edit">✏️ Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    $content = ob_get_clean();
    renderLayout('Customer Accounts', 'customers', $content);
}

/* ────────────────────────────────────────────────
   NEW — Show blank form
   ──────────────────────────────────────────────── */
function handleNew() {
    $errors = flash('errors');
    $old    = flash('old');

    ob_start();
    ?>
    <div class="page-header animate-in">
        <h1>New Customer</h1>
        <p class="subtitle">Fill in the details to add a new customer.</p>
    </div>

    <div class="form-card animate-in delay-1">
        <form action="<?= url('index.php?page=customers&action=create') ?>" method="post" id="customer-form">

            <div class="form-group">
                <label for="full_name" class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name"
                       class="form-input <?= isset($errors['full_name']) ? 'input-error' : '' ?>"
                       value="<?= esc($old['full_name'] ?? '') ?>"
                       placeholder="e.g. Maria Clara Santos" required>
                <?php if (isset($errors['full_name'])): ?>
                    <p class="error-text"><?= esc($errors['full_name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email"
                       class="form-input <?= isset($errors['email']) ? 'input-error' : '' ?>"
                       value="<?= esc($old['email'] ?? '') ?>"
                       placeholder="e.g. maria.santos@email.com" required>
                <?php if (isset($errors['email'])): ?>
                    <p class="error-text"><?= esc($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone"
                       class="form-input"
                       value="<?= esc($old['phone'] ?? '') ?>"
                       placeholder="e.g. +63 917 123 4567">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submit-btn">➕ Create Customer</button>
                <a href="<?= url('index.php?page=customers') ?>" class="btn btn-outline" id="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    $content = ob_get_clean();
    renderLayout('New Customer', 'customers', $content);
}

/* ────────────────────────────────────────────────
   CREATE — Validate & insert
   ──────────────────────────────────────────────── */
function handleCreate() {
    global $conn;

    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $errors    = [];

    // Validation
    if (empty($full_name)) {
        $errors['full_name'] = 'Full name is required.';
    } elseif (strlen($full_name) < 2 || strlen($full_name) > 100) {
        $errors['full_name'] = 'Full name must be between 2 and 100 characters.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (!empty($errors)) {
        set_flash('errors', $errors);
        set_flash('old', $_POST);
        header('Location: ' . url('index.php?page=customers&action=new'));
        exit;
    }

    // Insert
    $stmt = $conn->prepare("INSERT INTO customers (full_name, email, phone, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param('sss', $full_name, $email, $phone);
    $stmt->execute();
    $stmt->close();

    set_flash('success', 'Customer created successfully.');
    header('Location: ' . url('index.php?page=customers'));
    exit;
}

/* ────────────────────────────────────────────────
   EDIT — Pre-fill form with existing data
   ──────────────────────────────────────────────── */
function handleEdit() {
    global $conn;
    $id = intval($_GET['id'] ?? 0);

    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $customer = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$customer) {
        echo '<div style="text-align:center;padding:3rem;color:#ff6b6b;">Customer not found.</div>';
        return;
    }

    $errors = flash('errors');

    ob_start();
    ?>
    <div class="page-header animate-in">
        <h1>Edit Customer</h1>
        <p class="subtitle">Update the customer record below.</p>
    </div>

    <div class="form-card animate-in delay-1">
        <form action="<?= url('index.php?page=customers&action=update&id=' . $customer['id']) ?>" method="post" id="customer-form">

            <div class="form-group">
                <label for="full_name" class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name"
                       class="form-input <?= isset($errors['full_name']) ? 'input-error' : '' ?>"
                       value="<?= esc($customer['full_name']) ?>"
                       placeholder="e.g. Maria Clara Santos" required>
                <?php if (isset($errors['full_name'])): ?>
                    <p class="error-text"><?= esc($errors['full_name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email"
                       class="form-input <?= isset($errors['email']) ? 'input-error' : '' ?>"
                       value="<?= esc($customer['email']) ?>"
                       placeholder="e.g. maria.santos@email.com" required>
                <?php if (isset($errors['email'])): ?>
                    <p class="error-text"><?= esc($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone"
                       class="form-input"
                       value="<?= esc($customer['phone']) ?>"
                       placeholder="e.g. +63 917 123 4567">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submit-btn">💾 Update Customer</button>
                <a href="<?= url('index.php?page=customers') ?>" class="btn btn-outline" id="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    $content = ob_get_clean();
    renderLayout('Edit Customer', 'customers', $content);
}

/* ────────────────────────────────────────────────
   UPDATE — Validate & update
   ──────────────────────────────────────────────── */
function handleUpdate() {
    global $conn;
    $id = intval($_GET['id'] ?? 0);

    // Verify record exists
    $check = $conn->prepare("SELECT id FROM customers WHERE id = ?");
    $check->bind_param('i', $id);
    $check->execute();
    if (!$check->get_result()->fetch_assoc()) {
        echo '<div style="text-align:center;padding:3rem;color:#ff6b6b;">Customer not found.</div>';
        return;
    }
    $check->close();

    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $errors    = [];

    if (empty($full_name)) {
        $errors['full_name'] = 'Full name is required.';
    } elseif (strlen($full_name) < 2 || strlen($full_name) > 100) {
        $errors['full_name'] = 'Full name must be between 2 and 100 characters.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (!empty($errors)) {
        set_flash('errors', $errors);
        header('Location: ' . url('index.php?page=customers&action=edit&id=' . $id));
        exit;
    }

    $stmt = $conn->prepare("UPDATE customers SET full_name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param('sssi', $full_name, $email, $phone, $id);
    $stmt->execute();
    $stmt->close();

    set_flash('success', 'Customer updated successfully.');
    header('Location: ' . url('index.php?page=customers'));
    exit;
}
