<?php
/**
 * alt.FPOS — User Accounts
 * Handles: listing (with avatar display), new, create, edit, update (with avatar upload & thumbnail)
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
   LIST — Show all users with avatars
   ──────────────────────────────────────────────── */
function handleList() {
    global $conn;
    $result  = $conn->query("SELECT * FROM users ORDER BY id ASC");
    $users   = $result->fetch_all(MYSQLI_ASSOC);
    $success = flash('success');
    $total   = count($users);
    $admins  = count(array_filter($users, fn($u) => $u['role'] === 'Admin'));
    $managers = count(array_filter($users, fn($u) => $u['role'] === 'Manager'));
    $cashiers = count(array_filter($users, fn($u) => $u['role'] === 'Cashier'));

    ob_start();
    ?>
    <div class="page-header animate-in">
        <div class="page-header-row">
            <div>
                <h1>User Accounts</h1>
                <p class="subtitle">Manage staff and system user accounts.</p>
            </div>
            <a href="<?= url('index.php?page=users&action=new') ?>" class="btn btn-primary" id="add-user-btn">➕ New User</a>
        </div>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success animate-in delay-1">✅ <?= esc($success) ?></div>
    <?php endif; ?>

    <div class="stats-grid animate-in delay-1">
        <div class="stat-card">
            <div class="stat-icon purple">👥</div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon teal">👑</div>
            <div class="stat-value"><?= $admins ?></div>
            <div class="stat-label">Administrators</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">👔</div>
            <div class="stat-value"><?= $managers ?></div>
            <div class="stat-label">Managers</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">💰</div>
            <div class="stat-value"><?= $cashiers ?></div>
            <div class="stat-label">Cashiers</div>
        </div>
    </div>

    <div class="table-container animate-in delay-2" id="users-table-container">
        <div class="table-header">
            <h2>📋 Staff Directory</h2>
            <span class="table-badge"><?= $total ?> Records</span>
        </div>
        <table id="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $i => $user): ?>
                <tr>
                    <td class="row-index"><?= $i + 1 ?></td>
                    <td>
                        <div class="user-avatar-cell">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?= url('uploads/avatars/' . $user['avatar']) ?>"
                                     alt="<?= esc($user['full_name']) ?>"
                                     class="user-avatar" loading="lazy">
                            <?php else: ?>
                                <div class="user-avatar-placeholder">
                                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
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
                    <td>
                        <a href="<?= url('index.php?page=users&action=edit&id=' . $user['id']) ?>" class="btn-action btn-edit" title="Edit">✏️ Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    $content = ob_get_clean();
    renderLayout('User Accounts', 'users', $content);
}

/* ────────────────────────────────────────────────
   NEW — Show blank user form
   ──────────────────────────────────────────────── */
function handleNew() {
    $errors = flash('errors');
    $old    = flash('old');

    ob_start();
    ?>
    <div class="page-header animate-in">
        <h1>New User</h1>
        <p class="subtitle">Fill in the details to create a new user account.</p>
    </div>

    <div class="form-card animate-in delay-1">
        <form action="<?= url('index.php?page=users&action=create') ?>" method="post" id="user-form">

            <div class="form-group">
                <label for="username" class="form-label">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username"
                       class="form-input <?= isset($errors['username']) ? 'input-error' : '' ?>"
                       value="<?= esc($old['username'] ?? '') ?>"
                       placeholder="e.g. admin_jose" required>
                <?php if (isset($errors['username'])): ?>
                    <p class="error-text"><?= esc($errors['username']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password"
                       class="form-input <?= isset($errors['password']) ? 'input-error' : '' ?>"
                       placeholder="Minimum 6 characters" required>
                <?php if (isset($errors['password'])): ?>
                    <p class="error-text"><?= esc($errors['password']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="full_name" class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name"
                       class="form-input <?= isset($errors['full_name']) ? 'input-error' : '' ?>"
                       value="<?= esc($old['full_name'] ?? '') ?>"
                       placeholder="e.g. Jose Andres Mendoza" required>
                <?php if (isset($errors['full_name'])): ?>
                    <p class="error-text"><?= esc($errors['full_name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Role <span class="required">*</span></label>
                <select id="role" name="role" class="form-input form-select" required>
                    <?php
                        $currentRole = $old['role'] ?? 'Staff';
                        $roles = ['Admin', 'Manager', 'Cashier', 'Staff'];
                    ?>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role ?>" <?= $currentRole === $role ? 'selected' : '' ?>><?= $role ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submit-btn">➕ Create User</button>
                <a href="<?= url('index.php?page=users') ?>" class="btn btn-outline" id="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    $content = ob_get_clean();
    renderLayout('New User', 'users', $content);
}

/* ────────────────────────────────────────────────
   CREATE — Validate & insert new user
   ──────────────────────────────────────────────── */
function handleCreate() {
    global $conn;

    $username  = trim($_POST['username'] ?? '');
    $password  = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $role      = trim($_POST['role'] ?? 'Staff');
    $errors    = [];

    // Validation
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors['username'] = 'Username must be between 3 and 50 characters.';
    } else {
        // Check uniqueness
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param('s', $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors['username'] = 'This username is already taken.';
        }
        $check->close();
    }

    if (empty($full_name)) {
        $errors['full_name'] = 'Full name is required.';
    } elseif (strlen($full_name) < 2 || strlen($full_name) > 100) {
        $errors['full_name'] = 'Full name must be between 2 and 100 characters.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }

    $validRoles = ['Admin', 'Manager', 'Cashier', 'Staff'];
    if (!in_array($role, $validRoles)) {
        $errors['role'] = 'Invalid role selected.';
    }

    if (!empty($errors)) {
        set_flash('errors', $errors);
        set_flash('old', $_POST);
        header('Location: ' . url('index.php?page=users&action=new'));
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, role, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param('ssss', $username, $hashedPassword, $full_name, $role);
    $stmt->execute();
    $stmt->close();

    set_flash('success', 'User created successfully.');
    header('Location: ' . url('index.php?page=users'));
    exit;
}

/* ────────────────────────────────────────────────
   EDIT — Pre-fill form with existing user data + avatar upload
   ──────────────────────────────────────────────── */
function handleEdit() {
    global $conn;
    $id = intval($_GET['id'] ?? 0);

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo '<div style="text-align:center;padding:3rem;color:#ff6b6b;">User not found.</div>';
        return;
    }

    $errors = flash('errors');

    ob_start();
    ?>
    <div class="page-header animate-in">
        <h1>Edit User</h1>
        <p class="subtitle">Update the user account below.</p>
    </div>

    <div class="form-card animate-in delay-1">
        <form action="<?= url('index.php?page=users&action=update&id=' . $user['id']) ?>" method="post" enctype="multipart/form-data" id="user-form">

            <?php if (!empty($user['avatar'])): ?>
                <div class="current-avatar-section">
                    <p class="form-label">Current Avatar</p>
                    <img src="<?= url('uploads/avatars/' . $user['avatar']) ?>"
                         alt="Current avatar" class="current-avatar-preview" id="current-avatar">
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username" class="form-label">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username"
                       class="form-input <?= isset($errors['username']) ? 'input-error' : '' ?>"
                       value="<?= esc($user['username']) ?>"
                       placeholder="e.g. admin_jose" required>
                <?php if (isset($errors['username'])): ?>
                    <p class="error-text"><?= esc($errors['username']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="full_name" class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name"
                       class="form-input <?= isset($errors['full_name']) ? 'input-error' : '' ?>"
                       value="<?= esc($user['full_name']) ?>"
                       placeholder="e.g. Jose Andres Mendoza" required>
                <?php if (isset($errors['full_name'])): ?>
                    <p class="error-text"><?= esc($errors['full_name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Role <span class="required">*</span></label>
                <select id="role" name="role" class="form-input form-select" required>
                    <?php
                        $roles = ['Admin', 'Manager', 'Cashier', 'Staff'];
                    ?>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role ?>" <?= $user['role'] === $role ? 'selected' : '' ?>><?= $role ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="avatar" class="form-label">Profile Picture</label>
                <div class="file-input-wrapper">
                    <input type="file" id="avatar" name="avatar"
                           class="form-file-input <?= isset($errors['avatar']) ? 'input-error' : '' ?>"
                           accept=".jpg,.jpeg,.png">
                    <p class="form-hint">JPG or PNG only. Maximum 2 MB. Will be resized to a 200×200 thumbnail.</p>
                </div>
                <?php if (isset($errors['avatar'])): ?>
                    <p class="error-text"><?= esc($errors['avatar']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submit-btn">💾 Update User</button>
                <a href="<?= url('index.php?page=users') ?>" class="btn btn-outline" id="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    $content = ob_get_clean();
    renderLayout('Edit User', 'users', $content);
}

/* ────────────────────────────────────────────────
   UPDATE — Validate, handle avatar upload, update record
   ──────────────────────────────────────────────── */
function handleUpdate() {
    global $conn;
    $id = intval($_GET['id'] ?? 0);

    // Verify record exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo '<div style="text-align:center;padding:3rem;color:#ff6b6b;">User not found.</div>';
        return;
    }

    $username  = trim($_POST['username'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $role      = trim($_POST['role'] ?? 'Staff');
    $errors    = [];

    // Validate fields
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors['username'] = 'Username must be between 3 and 50 characters.';
    } else {
        // Check uniqueness (exclude current user)
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $check->bind_param('si', $username, $id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors['username'] = 'This username is already taken.';
        }
        $check->close();
    }

    if (empty($full_name)) {
        $errors['full_name'] = 'Full name is required.';
    } elseif (strlen($full_name) < 2 || strlen($full_name) > 100) {
        $errors['full_name'] = 'Full name must be between 2 and 100 characters.';
    }

    $validRoles = ['Admin', 'Manager', 'Cashier', 'Staff'];
    if (!in_array($role, $validRoles)) {
        $errors['role'] = 'Invalid role selected.';
    }

    // Handle avatar upload
    $newAvatar = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file     = $_FILES['avatar'];
        $fileSize = $file['size'];
        $tmpName  = $file['tmp_name'];

        // Validate file size (max 2 MB)
        if ($fileSize > 2 * 1024 * 1024) {
            $errors['avatar'] = 'File size must not exceed 2 MB.';
        }

        // Validate file type (JPG or PNG only)
        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpName);
        finfo_close($finfo);

        $allowedMimes = ['image/jpeg', 'image/png'];
        if (!in_array($mimeType, $allowedMimes)) {
            $errors['avatar'] = 'Only JPG and PNG files are allowed.';
        }

        // Also check extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            $errors['avatar'] = 'Only JPG and PNG files are allowed.';
        }
    }

    if (!empty($errors)) {
        set_flash('errors', $errors);
        header('Location: ' . url('index.php?page=users&action=edit&id=' . $id));
        exit;
    }

    // Process avatar if uploaded
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file    = $_FILES['avatar'];
        $tmpName = $file['tmp_name'];
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Create uploads directory if needed
        $uploadDir = __DIR__ . '/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Delete old avatar
        if (!empty($user['avatar'])) {
            $oldPath = $uploadDir . $user['avatar'];
            if (is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        // Generate unique filename
        $newAvatar = 'avatar_' . $id . '_' . time() . '.' . $ext;
        $destPath  = $uploadDir . $newAvatar;

        // Move uploaded file
        move_uploaded_file($tmpName, $destPath);

        // Create display-ready thumbnail (200×200 center-cropped)
        createThumbnail($destPath, $destPath);
    }

    // Update database
    if ($newAvatar) {
        $stmt = $conn->prepare("UPDATE users SET username = ?, full_name = ?, role = ?, avatar = ? WHERE id = ?");
        $stmt->bind_param('ssssi', $username, $full_name, $role, $newAvatar, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, full_name = ?, role = ? WHERE id = ?");
        $stmt->bind_param('sssi', $username, $full_name, $role, $id);
    }
    $stmt->execute();
    $stmt->close();

    set_flash('success', 'User updated successfully.');
    header('Location: ' . url('index.php?page=users'));
    exit;
}

/* ────────────────────────────────────────────────
   THUMBNAIL — Create a display-ready 200×200 avatar
   Center-crops and resizes using GD library.
   ──────────────────────────────────────────────── */
function createThumbnail(string $source, string $destination): void {
    $imageInfo = getimagesize($source);
    if ($imageInfo === false) return;

    $mime       = $imageInfo['mime'];
    $origWidth  = $imageInfo[0];
    $origHeight = $imageInfo[1];
    $thumbSize  = 200;

    // Create source image resource
    switch ($mime) {
        case 'image/jpeg':
            $srcImage = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $srcImage = imagecreatefrompng($source);
            break;
        default:
            return;
    }

    if (!$srcImage) return;

    // Square center crop
    $minDim = min($origWidth, $origHeight);
    $cropX  = (int)(($origWidth - $minDim) / 2);
    $cropY  = (int)(($origHeight - $minDim) / 2);

    // Create thumbnail canvas
    $thumbImage = imagecreatetruecolor($thumbSize, $thumbSize);

    // Preserve PNG transparency
    if ($mime === 'image/png') {
        imagealphablending($thumbImage, false);
        imagesavealpha($thumbImage, true);
    }

    // High-quality resampling
    imagecopyresampled(
        $thumbImage, $srcImage,
        0, 0,
        $cropX, $cropY,
        $thumbSize, $thumbSize,
        $minDim, $minDim
    );

    // Save
    switch ($mime) {
        case 'image/jpeg':
            imagejpeg($thumbImage, $destination, 85);
            break;
        case 'image/png':
            imagepng($thumbImage, $destination, 8);
            break;
    }

    imagedestroy($srcImage);
    imagedestroy($thumbImage);
}
