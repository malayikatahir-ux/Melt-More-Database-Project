<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

require_once '../db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($conn, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id, username, password, full_name FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_name'] = $admin['full_name'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Incorrect username or password. Please try again.';
        }
    } else {
        $error = 'Username and password are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Melt and More</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .login-tabs { display:flex; gap:0; margin-bottom:25px; border-radius:10px; overflow:hidden; border:2px solid #e0e0e0; }
        .login-tab { flex:1; padding:12px; text-align:center; background:#f8f9fa; color:#666; text-decoration:none; font-weight:700; font-size:14px; transition:all 0.3s; }
        .login-tab.active { background:#45b8ac; color:#fff; }
        .login-tab:hover:not(.active) { background:#e8f8f7; color:#45b8ac; }
        .divider-line { border:none; border-top:1px solid #eee; margin:20px 0; }
        .setup-note { background:#fff3cd; border:1px solid #ffc107; border-radius:8px; padding:14px; font-size:13px; color:#856404; margin-top:15px; line-height:1.6; }
        .setup-note a { color:#856404; font-weight:700; }
    </style>
</head>
<body>
<div class="admin-login-page">
    <div class="login-card">
        <div class="login-logo">🎂</div>
        <h2>Melt and More</h2>
        <p class="subtitle">Bakery Management Panel</p>

        <!-- TABS -->
        <div class="login-tabs">
            <a href="login.php" class="login-tab active">🔐 Admin Login</a>
            <a href="../track-order.php" class="login-tab">📦 Track My Order</a>
        </div>

        <?php if ($error): ?>
            <div class="login-error">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="admin" required autocomplete="username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>
            <button type="submit" class="login-btn">🔐 Login to Admin Panel</button>
        </form>

        <div class="setup-note">
            <strong>⚠️ First time setup?</strong><br>
            Run <a href="../setup.php">setup.php</a> once to create admin account.<br>
            Default: Username <code>admin</code> / Password <code>admin123</code>
        </div>

        <hr class="divider-line">
        <a href="../index.php" class="back-link">← Back to Website</a>
        <a href="../track-order.php" style="display:block;text-align:center;margin-top:10px;color:#45b8ac;text-decoration:none;font-size:14px;">
            📦 Customer? Track your order here
        </a>
    </div>
</div>
</body>
</html>
