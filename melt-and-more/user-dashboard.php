<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}
require_once 'db.php';

$user_id    = $_SESSION['user_id'];
$user_name  = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$welcome    = isset($_GET['welcome']);

// Fetch user's orders by email
$orders = $conn->query("SELECT * FROM orders WHERE customer_email='".sanitize($conn, $user_email)."' ORDER BY created_at DESC");

$statusColors = [
    'pending'   => '#f39c12',
    'confirmed' => '#27ae60',
    'preparing' => '#00bcd4',
    'delivered' => '#2ecc71',
    'cancelled' => '#e74c3c',
];
$statusLabels = [
    'pending'   => 'Received',
    'confirmed' => 'Confirmed',
    'preparing' => 'Preparing',
    'delivered' => 'Delivered',
    'cancelled' => 'Cancelled',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Melt and More</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-wrap { max-width:1000px; margin:50px auto; padding:0 25px 80px; }
        .dash-header { background:linear-gradient(135deg,#111,#1a1a2e); color:#fff; border-radius:16px; padding:35px 40px; margin-bottom:30px; display:flex; align-items:center; gap:25px; }
        .dash-avatar { width:70px; height:70px; background:#00bcd4; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:28px; color:#fff; flex-shrink:0; }
        .dash-info h2 { font-family:'Dancing Script',cursive; font-size:32px; margin-bottom:4px; }
        .dash-info p { opacity:.7; font-size:14px; }
        .dash-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:30px; }
        .stat-card { background:#fff; border-radius:14px; padding:25px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.07); border:2px solid #eee; }
        .stat-num { font-size:36px; font-weight:700; color:#111; }
        .stat-label { font-size:13px; color:#999; margin-top:4px; }
        .order-table { width:100%; border-collapse:collapse; }
        .order-table th { background:#111; color:#fff; padding:14px 16px; text-align:left; font-size:13px; letter-spacing:.5px; }
        .order-table td { padding:14px 16px; border-bottom:1px solid #f0f0f0; font-size:14px; }
        .order-table tr:hover td { background:#fafcfc; }
        .status-pill { display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; color:#fff; }
        .welcome-banner { background:#e0f7fa; border-radius:12px; padding:20px 25px; margin-bottom:25px; display:flex; align-items:center; gap:15px; border:1px solid #b2ebf2; }
        .section-card { background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); overflow:hidden; margin-bottom:30px; }
        .section-card-header { padding:20px 25px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; }
        .section-card-header h3 { font-family:'Dancing Script',cursive; font-size:24px; color:#111; }
        @media(max-width:600px){ .dash-stats{grid-template-columns:1fr 1fr;} .dash-header{flex-direction:column;text-align:center;} }
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
            <li><a href="user-dashboard.php" class="active">My Account</a></li>
            <li><a href="order.php" class="nav-admin-btn">Order Now</a></li>
        </ul>
        <button class="mobile-menu-btn">&#9776;</button>
    </div>
    <div class="mobile-nav">
        <a href="index.php">Home</a><a href="shop.php">Menu</a>
        <a href="about.php">About</a><a href="contact.php">Contact</a>
        <a href="user-dashboard.php">My Account</a><a href="order.php">Order Now</a>
        <a href="user-logout.php">Sign Out</a>
    </div>
</nav>

<div class="dashboard-wrap">

    <?php if ($welcome): ?>
    <div class="welcome-banner">
        <i class="fas fa-check-circle" style="font-size:28px;color:#00bcd4;"></i>
        <div>
            <strong style="color:#111;">Welcome to Melt and More, <?= htmlspecialchars($user_name) ?>!</strong>
            <p style="color:#555;font-size:14px;margin:3px 0 0;">Your account has been created. You can now track all your orders here.</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- PROFILE HEADER -->
    <div class="dash-header">
        <div class="dash-avatar"><i class="fas fa-user"></i></div>
        <div class="dash-info">
            <h2>Hello, <?= htmlspecialchars($user_name) ?></h2>
            <p><?= htmlspecialchars($user_email) ?> &nbsp;&bull;&nbsp; Customer Account</p>
        </div>
        <div style="margin-left:auto;display:flex;gap:10px;flex-wrap:wrap;">
            <a href="order.php" class="btn-primary" style="font-size:14px;padding:10px 22px;">Place New Order</a>
            <a href="user-logout.php" style="background:rgba(255,255,255,0.1);color:#fff;padding:10px 22px;border-radius:30px;text-decoration:none;font-weight:700;font-size:14px;border:2px solid rgba(255,255,255,0.3);">Sign Out</a>
        </div>
    </div>

    <!-- STATS -->
    <?php
    $totalOrders    = $conn->query("SELECT COUNT(*) c FROM orders WHERE customer_email='".sanitize($conn, $user_email)."'")->fetch_assoc()['c'];
    $totalSpent     = $conn->query("SELECT COALESCE(SUM(total_amount),0) t FROM orders WHERE customer_email='".sanitize($conn, $user_email)."'")->fetch_assoc()['t'];
    $pendingOrders  = $conn->query("SELECT COUNT(*) c FROM orders WHERE customer_email='".sanitize($conn, $user_email)."' AND status NOT IN ('delivered','cancelled')")->fetch_assoc()['c'];
    ?>
    <div class="dash-stats">
        <div class="stat-card">
            <div class="stat-num"><?= $totalOrders ?></div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#00bcd4;">Rs. <?= number_format($totalSpent, 0) ?></div>
            <div class="stat-label">Total Spent</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#f39c12;"><?= $pendingOrders ?></div>
            <div class="stat-label">Active Orders</div>
        </div>
    </div>

    <!-- ORDERS TABLE -->
    <div class="section-card">
        <div class="section-card-header">
            <h3>My Orders</h3>
            <a href="order.php" class="btn-primary" style="font-size:13px;padding:8px 18px;">New Order</a>
        </div>
        <?php if ($orders->num_rows > 0): ?>
        <div style="overflow-x:auto;">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($o = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($o['order_number']) ?></strong></td>
                        <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                        <td><strong>Rs. <?= number_format($o['total_amount'], 0) ?></strong></td>
                        <td>
                            <span class="status-pill" style="background:<?= $statusColors[$o['status']] ?? '#999' ?>;">
                                <?= $statusLabels[$o['status']] ?? ucfirst($o['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="track-order.php?order=<?= urlencode($o['order_number']) ?>&phone=<?= urlencode($o['customer_phone']) ?>"
                               style="color:#00bcd4;text-decoration:none;font-weight:700;font-size:13px;">
                                Track &rarr;
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div style="text-align:center;padding:60px;color:#999;">
            <i class="fas fa-shopping-basket" style="font-size:48px;margin-bottom:15px;display:block;opacity:.3;"></i>
            <p style="font-size:16px;">No orders yet.</p>
            <a href="order.php" class="btn-primary" style="margin-top:20px;display:inline-block;">Place Your First Order</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- QUICK LINKS -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
        <a href="shop.php" style="background:#fff;border-radius:14px;padding:25px;text-align:center;text-decoration:none;box-shadow:0 4px 20px rgba(0,0,0,0.06);border:2px solid #eee;transition:all 0.3s;" onmouseover="this.style.borderColor='#00bcd4'" onmouseout="this.style.borderColor='#eee'">
            <i class="fas fa-birthday-cake" style="font-size:28px;color:#00bcd4;margin-bottom:10px;display:block;"></i>
            <strong style="color:#111;">Browse Menu</strong>
        </a>
        <a href="track-order.php" style="background:#fff;border-radius:14px;padding:25px;text-align:center;text-decoration:none;box-shadow:0 4px 20px rgba(0,0,0,0.06);border:2px solid #eee;transition:all 0.3s;" onmouseover="this.style.borderColor='#00bcd4'" onmouseout="this.style.borderColor='#eee'">
            <i class="fas fa-map-marked-alt" style="font-size:28px;color:#00bcd4;margin-bottom:10px;display:block;"></i>
            <strong style="color:#111;">Track Order</strong>
        </a>
        <a href="contact.php" style="background:#fff;border-radius:14px;padding:25px;text-align:center;text-decoration:none;box-shadow:0 4px 20px rgba(0,0,0,0.06);border:2px solid #eee;transition:all 0.3s;" onmouseover="this.style.borderColor='#00bcd4'" onmouseout="this.style.borderColor='#eee'">
            <i class="fas fa-comments" style="font-size:28px;color:#00bcd4;margin-bottom:10px;display:block;"></i>
            <strong style="color:#111;">Contact Us</strong>
        </a>
    </div>

</div>

<div class="wave-divider" style="background:#f8f9fa;"><svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#111"/></svg></div>
<footer>
    <div class="footer-inner" style="padding:40px 30px;">
        <div class="footer-col"><div class="footer-logo-circle"><div class="footer-logo-title">Melt&More</div><div class="footer-logo-sub">SWEET BAKERY</div></div></div>
        <div class="footer-col"></div>
        <div class="footer-col">
            <p style="color:rgba(255,255,255,0.4);font-size:13px;line-height:2;">
                Fatehsher, Sahiwal<br>+92 300 1234567<br>meltandmore@gmail.com
            </p>
        </div>
    </div>
    <div class="footer-bottom">&copy; 2026 Melt and More &mdash; Fatehsher, Sahiwal</div>
</footer>
<button id="backToTop">&#8679;</button>
<script src="js/main.js"></script>
</body>
</html>
