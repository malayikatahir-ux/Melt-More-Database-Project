<?php
session_start();

// Already logged in — redirect
if (isset($_SESSION['user_id']))  { header('Location: user-dashboard.php'); exit(); }
if (isset($_SESSION['admin_id'])) { header('Location: admin/dashboard.php'); exit(); }

require_once 'db.php';

$userError  = '';
$adminError = '';
$activeTab  = $_GET['tab'] ?? 'customer';   // customer | admin

/* ---- Handle Customer Login ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'customer') {
    $activeTab = 'customer';
    $email    = sanitize($conn, $_POST['email']    ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id,name,email,password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: user-dashboard.php');
            exit();
        } else { $userError = 'Incorrect email or password. Please try again.'; }
    } else { $userError = 'Email and password are required.'; }
}

/* ---- Handle Admin Login ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'admin') {
    $activeTab = 'admin';
    $username = sanitize($conn, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id,username,password,full_name FROM admins WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id']       = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_name']     = $admin['full_name'];
            header('Location: admin/dashboard.php');
            exit();
        } else { $adminError = 'Incorrect username or password. Please try again.'; }
    } else { $adminError = 'Username and password are required.'; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Melt and More</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .login-page-wrap {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0f7fa 0%, #f8f9fa 60%, #e0f7fa 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 40px 20px;
        }
        .login-outer {
            width: 100%; max-width: 460px;
        }

        /* Big 3-tab switcher */
        .main-tabs {
            display: flex; border-radius: 14px; overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.10);
            margin-bottom: 0;
        }
        .main-tab {
            flex: 1; padding: 16px 10px; text-align: center;
            background: #fff; color: #777; text-decoration: none;
            font-weight: 700; font-size: 14px; transition: all 0.3s;
            border-bottom: 3px solid transparent; cursor: pointer;
            border: none; font-family: inherit;
        }
        .main-tab i { display: block; font-size: 22px; margin-bottom: 5px; }
        .main-tab.active.customer { background: #111; color: #fff; border-bottom-color: #00bcd4; }
        .main-tab.active.admin    { background: #111; color: #fff; border-bottom-color: #00bcd4; }
        .main-tab.active.register { background: #111; color: #fff; border-bottom-color: #00bcd4; }
        .main-tab:not(.active):hover { background: #f0fffe; color: #00bcd4; }

        /* Card panels */
        .login-panel {
            background: #fff; border-radius: 0 0 18px 18px;
            padding: 36px 36px 30px; display: none;
            box-shadow: 0 8px 40px rgba(0,0,0,0.10);
        }
        .login-panel.active { display: block; }

        .panel-icon { font-size: 46px; text-align: center; margin-bottom: 10px; }
        .panel-icon i.customer { color: #00bcd4; }
        .panel-icon i.admin    { color: #111; }
        .panel-icon i.register { color: #00bcd4; }

        .panel-title {
            font-family: 'Dancing Script', cursive;
            font-size: 30px; color: #111; text-align: center; margin-bottom: 4px;
        }
        .panel-sub {
            color: #999; font-size: 13px; text-align: center; margin-bottom: 22px;
        }

        .admin-badge {
            background: #111; color: #fff; border-radius: 8px;
            padding: 10px 14px; margin-bottom: 18px;
            display: flex; align-items: center; gap: 10px; font-size: 13px;
        }
        .admin-badge i { font-size: 20px; color: #00bcd4; }
        .admin-badge strong { display: block; font-size: 15px; }
        .admin-badge span { opacity: .7; }

        .admin-features {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 8px; margin: 18px 0;
        }
        .admin-feat {
            background: #f8f9fa; border-radius: 8px; padding: 10px 12px;
            font-size: 12px; color: #555; display: flex; align-items: center; gap: 8px;
        }
        .admin-feat i { color: #00bcd4; font-size: 14px; flex-shrink: 0; }

        .divider-or {
            display: flex; align-items: center; gap: 12px;
            margin: 18px 0; color: #bbb; font-size: 13px;
        }
        .divider-or::before, .divider-or::after { content:''; flex:1; height:1px; background:#eee; }

        @media(max-width:480px){
            .login-panel { padding: 28px 22px; }
            .admin-features { grid-template-columns: 1fr; }
            .main-tab { font-size: 12px; padding: 13px 6px; }
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="top-bar">
    <span><i class="fas fa-map-marker-alt" style="color:#00bcd4;margin-right:5px;"></i> Fatehsher, Sahiwal</span>
    <span><i class="fas fa-phone" style="color:#00bcd4;margin-right:5px;"></i> +92 300 1234567</span>
</div>

<!-- NAV -->
<nav>
    <div class="nav-container">
        <a href="index.php" class="logo">
            <div class="logo-circle">
                <div class="logo-title">Melt&More</div>
                <div class="logo-sub">SWEET BAKERY</div>
            </div>
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Menu</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="user-login.php" class="active">My Account</a></li>
            <li><a href="order.php" class="nav-admin-btn">Order Now</a></li>
        </ul>
        <button class="mobile-menu-btn">&#9776;</button>
    </div>
    <div class="mobile-nav">
        <a href="index.php">Home</a>
        <a href="shop.php">Menu</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="user-login.php">My Account</a>
        <a href="order.php">Order Now</a>
    </div>
</nav>

<!-- LOGIN PAGE -->
<div class="login-page-wrap">
    <div class="login-outer">

        <!-- 3-TAB SWITCHER -->
        <div class="main-tabs">
            <button class="main-tab customer <?= $activeTab==='customer' ? 'active' : '' ?>"
                onclick="switchTab('customer')">
                <i class="fas fa-user"></i>
                Customer Login
            </button>
            <button class="main-tab register <?= $activeTab==='register' ? 'active' : '' ?>"
                onclick="switchTab('register')">
                <i class="fas fa-user-plus"></i>
                Register
            </button>
            <button class="main-tab admin <?= $activeTab==='admin' ? 'active' : '' ?>"
                onclick="switchTab('admin')">
                <i class="fas fa-shield-alt"></i>
                Admin Login
            </button>
        </div>

        <!-- ==================== CUSTOMER LOGIN PANEL ==================== -->
        <div class="login-panel <?= $activeTab==='customer' ? 'active' : '' ?>" id="panel-customer">
            <div class="panel-icon"><i class="fas fa-user-circle customer"></i></div>
            <div class="panel-title">Welcome Back</div>
            <div class="panel-sub">Sign in to track your orders and manage your account</div>

            <?php if ($userError): ?>
                <div class="login-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($userError) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="form_type" value="customer">
                <div class="form-group" style="text-align:left;">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="your@email.com" required
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email">
                </div>
                <div class="form-group" style="text-align:left;">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Your password" required autocomplete="current-password">
                </div>
                <button type="submit" class="login-btn">Sign In</button>
            </form>

            <div class="divider-or">or</div>

            <a href="track-order.php" style="display:block;background:#e0f7fa;color:#007c91;padding:13px;border-radius:10px;text-decoration:none;font-weight:700;font-size:14px;text-align:center;">
                <i class="fas fa-search" style="margin-right:7px;"></i> Track Order Without Signing In
            </a>

            <p style="text-align:center;margin-top:18px;font-size:13px;color:#aaa;">
                No account yet?
                <a href="#" onclick="switchTab('register');return false;" style="color:#00bcd4;text-decoration:none;font-weight:700;">Create one here</a>
            </p>
        </div>

        <!-- ==================== REGISTER PANEL ==================== -->
        <div class="login-panel <?= $activeTab==='register' ? 'active' : '' ?>" id="panel-register">
            <div class="panel-icon"><i class="fas fa-user-plus register"></i></div>
            <div class="panel-title">Create Account</div>
            <div class="panel-sub">Register to track orders and manage your bakery experience</div>

            <a href="user-register.php"
               style="display:block;background:#111;color:#fff;padding:14px;border-radius:10px;text-decoration:none;font-weight:700;font-size:15px;text-align:center;margin-bottom:15px;">
                <i class="fas fa-user-plus" style="margin-right:8px;"></i> Go to Registration Page
            </a>

            <p style="text-align:center;font-size:13px;color:#999;line-height:1.7;">
                Already have an account?
                <a href="#" onclick="switchTab('customer');return false;" style="color:#00bcd4;text-decoration:none;font-weight:700;">Sign in</a>
            </p>
        </div>

        <!-- ==================== ADMIN LOGIN PANEL ==================== -->
        <div class="login-panel <?= $activeTab==='admin' ? 'active' : '' ?>" id="panel-admin">
            <div class="panel-icon"><i class="fas fa-shield-alt admin"></i></div>
            <div class="panel-title">Admin Panel</div>
            <div class="panel-sub">Bakery management — authorised personnel only</div>

            <!-- Admin features preview -->
            <div class="admin-features">
                <div class="admin-feat"><i class="fas fa-shopping-bag"></i> View &amp; Manage Orders</div>
                <div class="admin-feat"><i class="fas fa-birthday-cake"></i> Add / Edit Products</div>
                <div class="admin-feat"><i class="fas fa-boxes"></i> Ingredients &amp; Stock</div>
                <div class="admin-feat"><i class="fas fa-chart-bar"></i> Dashboard Overview</div>
                <div class="admin-feat"><i class="fas fa-check-circle"></i> Confirm Orders</div>
                <div class="admin-feat"><i class="fas fa-truck"></i> Update Delivery Status</div>
            </div>

            <?php if ($adminError): ?>
                <div class="login-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($adminError) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="form_type" value="admin">
                <div class="form-group" style="text-align:left;">
                    <label>Admin Username</label>
                    <input type="text" name="username" placeholder="admin" required
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
                </div>
                <div class="form-group" style="text-align:left;">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Admin password" required autocomplete="current-password">
                </div>
                <button type="submit" class="login-btn" style="background:#111;">
                    <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i> Sign In as Admin
                </button>
            </form>

            <p style="text-align:center;margin-top:15px;font-size:12px;color:#bbb;">
                Default: username <strong style="color:#555;">admin</strong> / password <strong style="color:#555;">admin123</strong><br>
                <span style="color:#f39c12;">(Run setup.php first if not yet done)</span>
            </p>
        </div>

        <!-- Back to home -->
        <div style="text-align:center;margin-top:18px;">
            <a href="index.php" style="color:#aaa;text-decoration:none;font-size:13px;">
                <i class="fas fa-arrow-left" style="margin-right:5px;"></i> Back to Website
            </a>
        </div>

    </div><!-- /login-outer -->
</div><!-- /login-page-wrap -->

<script src="js/main.js"></script>
<script>
function switchTab(tab) {
    // Hide all panels
    document.querySelectorAll('.login-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.main-tab').forEach(t => t.classList.remove('active'));

    // Show selected panel
    const panel = document.getElementById('panel-' + tab);
    if (panel) panel.classList.add('active');

    // Activate matching tab button
    document.querySelectorAll('.main-tab.' + tab).forEach(t => t.classList.add('active'));
}
</script>
</body>
</html>
