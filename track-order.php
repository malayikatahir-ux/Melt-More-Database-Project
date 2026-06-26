<?php
require_once 'db.php';
$order = null;
$items = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_num = sanitize($conn, $_POST['order_number'] ?? '');
    $phone = sanitize($conn, $_POST['phone'] ?? '');

    if ($order_num && $phone) {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_number=? AND customer_phone=?");
        $stmt->bind_param("ss", $order_num, $phone);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        if ($order) {
            $oid = $order['id'];
            $res = $conn->query("SELECT * FROM order_items WHERE order_id=$oid");
            while ($row = $res->fetch_assoc()) $items[] = $row;
        } else {
            $error = 'No order found with this Order Number and Phone. Please check and try again.';
        }
    } else {
        $error = 'Please enter your Order Number and Phone Number.';
    }
}

$statusInfo = [
    'pending'   => ['label' => 'Order Received', 'icon' => '🕐', 'color' => '#f39c12', 'steps' => 1],
    'confirmed' => ['label' => 'Confirmed',       'icon' => '✅', 'color' => '#27ae60', 'steps' => 2],
    'preparing' => ['label' => 'Being Prepared',  'icon' => '👩‍🍳', 'color' => '#45b8ac', 'steps' => 3],
    'delivered' => ['label' => 'Delivered',        'icon' => '🎉', 'color' => '#2ecc71', 'steps' => 4],
    'cancelled' => ['label' => 'Cancelled',        'icon' => '❌', 'color' => '#e74c3c', 'steps' => 0],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order - Melt and More</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .track-wrap { max-width:620px; margin:60px auto; padding:0 20px 80px; }
        .track-card { background:#fff; border-radius:20px; box-shadow:0 8px 35px rgba(0,0,0,0.1); overflow:hidden; }
        .track-header { background:linear-gradient(135deg,#3d2314,#5a3421); padding:35px; text-align:center; color:#fff; }
        .track-header h2 { font-family:'Dancing Script',cursive; font-size:36px; margin-bottom:5px; }
        .track-header p { opacity:0.8; font-size:14px; }
        .track-body { padding:35px; }
        .order-status-bar { display:flex; justify-content:space-between; align-items:center; position:relative; margin:30px 0; }
        .order-status-bar::before { content:''; position:absolute; top:20px; left:10%; right:10%; height:3px; background:#e0e0e0; z-index:0; border-radius:2px; }
        .status-progress { position:absolute; top:20px; left:10%; height:3px; background:#45b8ac; z-index:1; border-radius:2px; transition:width 0.5s; }
        .step { display:flex; flex-direction:column; align-items:center; gap:8px; z-index:2; }
        .step-circle { width:40px; height:40px; border-radius:50%; background:#e0e0e0; display:flex; align-items:center; justify-content:center; font-size:18px; border:3px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .step-circle.done { background:#45b8ac; }
        .step-label { font-size:11px; font-weight:700; color:#999; text-align:center; max-width:80px; }
        .step-label.done { color:#45b8ac; }
        .order-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:15px; margin:20px 0; }
        .info-box { background:#f8fcfc; border-radius:10px; padding:15px; }
        .info-box label { font-size:11px; font-weight:700; color:#999; text-transform:uppercase; letter-spacing:1px; display:block; margin-bottom:4px; }
        .info-box span { font-size:15px; font-weight:600; color:#3d2314; }
        .items-list { background:#f8fcfc; border-radius:10px; padding:20px; margin:20px 0; }
        .item-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; }
        .item-row:last-child { border-bottom:none; }
        .total-row { display:flex; justify-content:space-between; padding:15px 0 0; font-weight:700; font-size:17px; color:#3d2314; }
        .status-badge { display:inline-flex; align-items:center; gap:6px; padding:8px 18px; border-radius:25px; font-weight:700; font-size:14px; color:#fff; }
    </style>
</head>
<body>
<div class="top-bar">
    <span>📍 Fatehsher, Sahiwal | <a href="mailto:meltandmore@gmail.com">meltandmore@gmail.com</a></span>
    <span>📞 <a href="tel:+923001234567">+92 300 1234567</a></span>
</div>
<nav>
    <div class="nav-container">
        <a href="index.php" class="logo"><div class="logo-circle"><div class="logo-title">Melt&More</div><div class="logo-sub">SWEET BAKERY</div></div></a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Menu</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="order.php" class="nav-admin-btn">Order Now 🎂</a></li>
        </ul>
        <button class="mobile-menu-btn">☰</button>
    </div>
    <div class="mobile-nav">
        <a href="index.php">Home</a><a href="shop.php">Menu</a>
        <a href="about.php">About</a><a href="contact.php">Contact</a>
        <a href="order.php">Order Now</a>
    </div>
</nav>

<div class="track-wrap">
    <div class="track-card">
        <div class="track-header">
            <div style="font-size:50px;margin-bottom:10px;">📦</div>
            <h2>Track Your Order</h2>
            <p>Enter your order number and phone to see the status</p>
        </div>
        <div class="track-body">

            <?php if (!$order): ?>
            <!-- SEARCH FORM -->
            <?php if ($error): ?>
                <div class="alert-error" style="margin-bottom:20px;">❌ <?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label style="font-weight:700;color:#3d2314;display:block;margin-bottom:6px;">Order Number</label>
                    <input type="text" name="order_number" placeholder="e.g. MM-2026-0123"
                        value="<?= htmlspecialchars($_POST['order_number'] ?? '') ?>"
                        style="width:100%;padding:14px;border:2px solid #e0e0e0;border-radius:10px;font-size:15px;font-family:inherit;outline:none;"
                        required>
                    <small style="color:#999;font-size:12px;">You received this in your order confirmation</small>
                </div>
                <div class="form-group" style="margin-top:15px;">
                    <label style="font-weight:700;color:#3d2314;display:block;margin-bottom:6px;">Your Phone Number</label>
                    <input type="text" name="phone" placeholder="e.g. 0300-1234567"
                        value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                        style="width:100%;padding:14px;border:2px solid #e0e0e0;border-radius:10px;font-size:15px;font-family:inherit;outline:none;"
                        required>
                    <small style="color:#999;font-size:12px;">The phone you used when placing the order</small>
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:15px;font-size:16px;border:none;cursor:pointer;margin-top:20px;border-radius:10px;font-family:inherit;">
                    🔍 Track Order
                </button>
            </form>

            <hr style="border:none;border-top:1px solid #eee;margin:25px 0;">
            <p style="text-align:center;color:#999;font-size:14px;">
                Don't have an order yet?
                <a href="order.php" style="color:#45b8ac;font-weight:700;text-decoration:none;">Place an order →</a>
            </p>
            <p style="text-align:center;margin-top:8px;">
                <a href="admin/login.php" style="color:#999;font-size:13px;text-decoration:none;">Admin Login</a>
            </p>

            <?php else: ?>
            <!-- ORDER FOUND -->
            <?php
            $st = $order['status'];
            $si = $statusInfo[$st] ?? $statusInfo['pending'];
            $steps = $si['steps'];
            $pct = $st === 'cancelled' ? 0 : ($steps - 1) / 3 * 80;
            ?>
            <div style="text-align:center;margin-bottom:20px;">
                <span class="status-badge" style="background:<?= $si['color'] ?>;">
                    <?= $si['icon'] ?> <?= $si['label'] ?>
                </span>
            </div>

            <!-- PROGRESS BAR -->
            <?php if ($st !== 'cancelled'): ?>
            <div class="order-status-bar">
                <div class="status-progress" style="width:<?= $pct ?>%;"></div>
                <?php
                $stepDefs = [
                    ['🕐','Received'],['✅','Confirmed'],['👩‍🍳','Preparing'],['🎉','Delivered']
                ];
                foreach ($stepDefs as $i => $s):
                    $done = $steps > $i;
                ?>
                <div class="step">
                    <div class="step-circle <?= $done?'done':'' ?>"><?= $s[0] ?></div>
                    <div class="step-label <?= $done?'done':'' ?>"><?= $s[1] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="order-info-grid">
                <div class="info-box">
                    <label>Order Number</label>
                    <span><?= htmlspecialchars($order['order_number']) ?></span>
                </div>
                <div class="info-box">
                    <label>Order Date</label>
                    <span><?= date('d M Y', strtotime($order['created_at'])) ?></span>
                </div>
                <div class="info-box">
                    <label>Customer Name</label>
                    <span><?= htmlspecialchars($order['customer_name']) ?></span>
                </div>
                <div class="info-box">
                    <label>Phone</label>
                    <span><?= htmlspecialchars($order['customer_phone']) ?></span>
                </div>
            </div>

            <div class="items-list">
                <h4 style="margin-bottom:15px;color:#3d2314;">Order Items</h4>
                <?php foreach ($items as $item): ?>
                <div class="item-row">
                    <span><?= htmlspecialchars($item['cake_name']) ?> × <?= $item['quantity'] ?></span>
                    <span style="color:#45b8ac;font-weight:700;">Rs. <?= number_format($item['price'] * $item['quantity'], 0) ?></span>
                </div>
                <?php endforeach; ?>
                <div class="total-row">
                    <span>Total</span>
                    <span>Rs. <?= number_format($order['total_amount'], 0) ?></span>
                </div>
            </div>

            <?php if ($order['notes']): ?>
            <div style="background:#fffbf0;border-radius:10px;padding:15px;border:1px solid #ffe08a;margin-bottom:20px;">
                <strong style="font-size:13px;color:#856404;">📝 Your Notes:</strong>
                <p style="margin:5px 0 0;color:#555;"><?= htmlspecialchars($order['notes']) ?></p>
            </div>
            <?php endif; ?>

            <div style="text-align:center;">
                <a href="track-order.php" class="btn-outline" style="margin-right:10px;">Track Another Order</a>
                <a href="index.php" class="btn-primary">Back to Home</a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="wave-divider" style="margin-top:0;"><svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#3d2314"/></svg></div>
<footer>
    <div class="footer-inner">
        <div class="footer-col"><h4>Quick Links</h4><div class="footer-divider"></div>
            <a href="index.php" style="color:rgba(255,255,255,0.6);text-decoration:none;display:block;margin:8px 0;">Home</a>
            <a href="shop.php" style="color:rgba(255,255,255,0.6);text-decoration:none;display:block;margin:8px 0;">Menu</a>
            <a href="order.php" style="color:rgba(255,255,255,0.6);text-decoration:none;display:block;margin:8px 0;">Order Now</a>
        </div>
        <div class="footer-col"><div class="footer-logo-circle"><div class="footer-logo-title">Melt&More</div><div class="footer-logo-sub">SWEET BAKERY</div></div></div>
        <div class="footer-col"><h4>Contact</h4><div class="footer-divider"></div>
            <p style="color:rgba(255,255,255,0.5);font-size:14px;line-height:2;">📍 Fatehsher, Sahiwal<br>📞 +92 300 1234567</p>
        </div>
    </div>
    <div class="footer-bottom">Melt and More — Founded March 2026 by Malayika Tahir</div>
</footer>
<button id="backToTop">↑</button>
<script src="js/main.js"></script>
</body>
</html>
