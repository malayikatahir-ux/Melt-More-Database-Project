<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: user-dashboard.php');
    exit();
}
require_once 'db.php';
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = sanitize($conn, $_POST['name'] ?? '');
    $email    = sanitize($conn, $_POST['email'] ?? '');
    $phone    = sanitize($conn, $_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (!$name || !$email || !$phone || !$password) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'An account with this email already exists. Please sign in.';
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt   = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $hashed);
            if ($stmt->execute()) {
                $user_id = $conn->insert_id;
                $_SESSION['user_id']    = $user_id;
                $_SESSION['user_name']  = $name;
                $_SESSION['user_email'] = $email;
                header('Location: user-dashboard.php?welcome=1');
                exit();
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Melt and More</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-tabs { display:flex; border-radius:10px; overflow:hidden; border:2px solid #e0e0e0; margin-bottom:25px; }
        .auth-tab { flex:1; padding:12px; text-align:center; background:#f8f9fa; color:#666; text-decoration:none; font-weight:700; font-size:14px; transition:all 0.3s; }
        .auth-tab.active { background:#111; color:#fff; }
        .auth-tab:hover:not(.active) { background:#e0f7fa; color:#00bcd4; }
    </style>
</head>
<body>
<div class="top-bar">
    <span><i class="fas fa-map-marker-alt" style="color:#00bcd4;margin-right:5px;"></i> Fatehsher, Sahiwal</span>
    <span><i class="fas fa-phone" style="color:#00bcd4;margin-right:5px;"></i> +92 300 1234567</span>
</div>
<nav>
    <div class="nav-container">
        <a href="index.php" class="logo"><div class="logo-circle"><div class="logo-title">Melt&More</div><div class="logo-sub">SWEET BAKERY</div></div></a>
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
</nav>

<div class="admin-login-page" style="background:#f8f9fa;">
    <div class="login-card" style="max-width:480px;">
        <div class="login-logo"><i class="fas fa-user-plus" style="color:#00bcd4;font-size:46px;"></i></div>
        <h2>Create Account</h2>
        <p class="subtitle">Register to track orders and manage your bakery experience</p>

        <div class="auth-tabs">
            <a href="user-login.php" class="auth-tab">Sign In</a>
            <a href="user-register.php" class="auth-tab active">Create Account</a>
        </div>

        <?php if ($error): ?>
            <div class="login-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form class="login-form" method="POST">
            <div class="form-group" style="text-align:left;">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Your full name" required
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>
            <div class="form-row">
                <div class="form-group" style="text-align:left;">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="your@email.com" required
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email">
                </div>
                <div class="form-group" style="text-align:left;">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="+92 300 xxxxxxx" required
                        value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="text-align:left;">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 6 characters" required autocomplete="new-password">
                </div>
                <div class="form-group" style="text-align:left;">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Repeat password" required autocomplete="new-password">
                </div>
            </div>
            <button type="submit" class="login-btn">Create My Account</button>
        </form>

        <a href="index.php" class="back-link"><i class="fas fa-arrow-left" style="margin-right:5px;"></i> Back to Website</a>
    </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
