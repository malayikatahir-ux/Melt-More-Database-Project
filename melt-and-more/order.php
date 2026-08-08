<?php
require_once 'db.php';
$success = '';
$error   = '';
session_start();
$prefill_name  = $_SESSION['user_name']  ?? '';
$prefill_email = $_SESSION['user_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = sanitize($conn, $_POST['customer_name']   ?? '');
    $phone        = sanitize($conn, $_POST['customer_phone']  ?? '');
    $email        = sanitize($conn, $_POST['customer_email']  ?? '');
    $address      = sanitize($conn, $_POST['delivery_address']?? '');
    $cake_name    = sanitize($conn, $_POST['cake_name']       ?? '');
    $quantity     = (int)($_POST['quantity']     ?? 1);
    $total_amount = (float)($_POST['total_amount']?? 0);
    $delivery_date= sanitize($conn, $_POST['delivery_date']   ?? '');
    $notes        = sanitize($conn, $_POST['special_notes']   ?? '');

    if (!$name || !$phone || !$cake_name || !$delivery_date) {
        $error = 'Please fill in all required fields.';
    } elseif ($quantity < 1) {
        $error = 'Quantity must be at least 1.';
    } else {
        $order_number = 'MAM-' . date('ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 5));
        $stmt = $conn->prepare(
            "INSERT INTO orders
             (order_number,customer_name,customer_phone,customer_email,delivery_address,cake_name,quantity,total_amount,delivery_date,special_notes,status)
             VALUES (?,?,?,?,?,?,?,?,?,?,'pending')"
        );
        $stmt->bind_param("ssssssidss",
            $order_number,$name,$phone,$email,$address,$cake_name,$quantity,$total_amount,$delivery_date,$notes
        );
        if ($stmt->execute()) {
            $success = $order_number;
        } else {
            $error = 'Order could not be placed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place an Order - Melt and More</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .price-hint{background:#e0f7fa;border:1px solid #b2ebf2;border-radius:8px;padding:12px 16px;font-size:14px;color:#007c91;margin-top:8px;display:none;}
        .total-box{background:#111;color:#fff;border-radius:12px;padding:22px;margin:18px 0;text-align:center;}
        .total-box .total-amount{font-size:38px;font-weight:700;color:#00bcd4;margin-top:5px;}
    </style>
</head>
<body>
<div class="top-bar">
    <span><i class="fas fa-map-marker-alt" style="color:#00bcd4;margin-right:5px;"></i> Fatehsher, Sahiwal &nbsp;|&nbsp; <a href="mailto:meltandmore@gmail.com">meltandmore@gmail.com</a></span>
    <span><i class="fas fa-phone" style="color:#00bcd4;margin-right:5px;"></i> <a href="tel:+923001234567">+92 300 1234567</a></span>
</div>
<nav>
    <div class="nav-container">
        <a href="index.php" class="logo"><div class="logo-circle"><div class="logo-title">Melt&More</div><div class="logo-sub">SWEET BAKERY</div></div></a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Menu</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="user-login.php">My Account</a></li>
            <li><a href="order.php" class="active nav-admin-btn">Order Now</a></li>
        </ul>
        <button class="mobile-menu-btn">&#9776;</button>
    </div>
    <div class="mobile-nav">
        <a href="index.php">Home</a><a href="shop.php">Menu</a>
        <a href="about.php">About</a><a href="contact.php">Contact</a>
        <a href="user-login.php">My Account</a><a href="order.php">Order Now</a>
    </div>
</nav>

<div class="page-hero" style="background:url('images/cupcakes.png') center/cover no-repeat;position:relative;">
    <div style="position:absolute;inset:0;background:rgba(0,0,0,0.70);z-index:0;"></div>
    <h1 style="position:relative;z-index:1;">Place Your Order</h1>
    <p style="position:relative;z-index:1;">Fill in the form and we will confirm your order within a few hours</p>
</div>

<section class="order-section">
<?php if ($success): ?>
    <div style="max-width:580px;margin:0 auto;text-align:center;padding:50px 30px;background:#fff;border-radius:20px;box-shadow:0 10px 40px rgba(0,0,0,0.08);">
        <i class="fas fa-check-circle" style="font-size:70px;color:#00bcd4;margin-bottom:20px;display:block;"></i>
        <h2 style="font-family:'Dancing Script',cursive;font-size:36px;color:#111;margin-bottom:10px;">Order Placed!</h2>
        <p style="color:#777;margin-bottom:20px;font-size:16px;">Thank you! We will contact you shortly to confirm your order.</p>
        <div style="background:#e0f7fa;border-radius:12px;padding:22px;margin-bottom:25px;">
            <p style="color:#555;font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px;">Order Number</p>
            <div style="font-size:26px;font-weight:700;color:#111;letter-spacing:3px;"><?= htmlspecialchars($success) ?></div>
            <p style="color:#777;font-size:13px;margin-top:6px;">Save this number to track your order</p>
        </div>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="track-order.php" class="btn-primary">Track My Order</a>
            <a href="index.php" class="btn-outline">Back to Home</a>
        </div>
    </div>
<?php else: ?>
    <div class="order-form-wrap">
        <h2 style="font-family:'Dancing Script',cursive;font-size:30px;color:#111;margin-bottom:25px;">Order Form</h2>
        <?php if ($error): ?><div class="alert-error"><i class="fas fa-exclamation-circle" style="margin-right:6px;"></i><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Select Product <span style="color:#e74c3c;">*</span></label>
                <select name="cake_name" id="cakeSel" onchange="updatePrice()" required
                    style="width:100%;padding:13px 16px;border:2px solid #e0e0e0;border-radius:10px;font-size:15px;font-family:inherit;outline:none;transition:border-color 0.3s;">
                    <option value="">-- Choose a product --</option>
                    <?php
                    $allCakes = $conn->query("SELECT * FROM cakes WHERE is_available=1 ORDER BY category,name");
                    $prevCat  = '';
                    while ($c = $allCakes->fetch_assoc()):
                        if ($c['category'] !== $prevCat) {
                            if ($prevCat) echo '</optgroup>';
                            echo '<optgroup label="'.htmlspecialchars(ucwords(str_replace('_',' ',$c['category']))).'">';
                            $prevCat = $c['category'];
                        }
                    ?>
                    <option value="<?= htmlspecialchars($c['name']) ?>"
                        data-price="<?= $c['price'] ?>"
                        data-unit="<?= htmlspecialchars($c['unit']) ?>">
                        <?= htmlspecialchars($c['name']) ?> — Rs. <?= number_format($c['price'],0) ?> / <?= htmlspecialchars($c['unit']) ?>
                    </option>
                    <?php endwhile; if ($prevCat) echo '</optgroup>'; ?>
                </select>
                <div class="price-hint" id="priceHint"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Quantity <span style="color:#e74c3c;">*</span></label>
                    <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="50" onchange="updatePrice()" required>
                </div>
                <div class="form-group">
                    <label>Delivery Date <span style="color:#e74c3c;">*</span></label>
                    <input type="date" name="delivery_date" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                </div>
            </div>

            <div class="total-box">
                <div style="font-size:12px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px;">Total Amount</div>
                <div class="total-amount" id="totalDisplay">Rs. 0</div>
                <input type="hidden" name="total_amount" id="totalInput" value="0">
            </div>

            <hr style="margin:20px 0;border:none;border-top:2px solid #f0f0f0;">

            <div class="form-row">
                <div class="form-group">
                    <label>Full Name <span style="color:#e74c3c;">*</span></label>
                    <input type="text" name="customer_name" placeholder="Your full name" required value="<?= htmlspecialchars($prefill_name) ?>">
                </div>
                <div class="form-group">
                    <label>Phone Number <span style="color:#e74c3c;">*</span></label>
                    <input type="tel" name="customer_phone" placeholder="+92 300 xxxxxxx" required>
                </div>
            </div>
            <div class="form-group">
                <label>Email Address <span style="color:#aaa;font-weight:400;font-size:13px;">(Optional — for order tracking)</span></label>
                <input type="email" name="customer_email" placeholder="your@email.com" value="<?= htmlspecialchars($prefill_email) ?>">
            </div>
            <div class="form-group">
                <label>Delivery Address <span style="color:#e74c3c;">*</span></label>
                <input type="text" name="delivery_address" placeholder="House / Street / Area, City" required>
            </div>
            <div class="form-group">
                <label>Special Instructions <span style="color:#aaa;font-weight:400;font-size:13px;">(Optional)</span></label>
                <textarea name="special_notes" placeholder="Flavour, design notes, message on cake, allergies, etc."></textarea>
            </div>
            <button type="submit" class="btn-primary"
                style="width:100%;font-size:16px;padding:16px;border:none;cursor:pointer;font-family:inherit;font-weight:700;">
                <i class="fas fa-paper-plane" style="margin-right:8px;"></i> Confirm My Order
            </button>
            <p style="text-align:center;margin-top:13px;color:#aaa;font-size:13px;">We will contact you within 2 hours to confirm your order.</p>
        </form>
    </div>
<?php endif; ?>
</section>

<div class="wave-divider"><svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#111"/></svg></div>
<footer>
    <div class="footer-inner">
        <div class="footer-col"><h4>Quick Links</h4><div class="footer-divider"></div>
            <a href="index.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Home</a>
            <a href="shop.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Menu</a>
            <a href="track-order.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Track Order</a>
        </div>
        <div class="footer-col"><div class="footer-logo-circle"><div class="footer-logo-title">Melt&More</div><div class="footer-logo-sub">SWEET BAKERY</div></div></div>
        <div class="footer-col"><h4>Contact</h4><div class="footer-divider"></div>
            <p style="color:rgba(255,255,255,0.45);font-size:14px;line-height:2.2;">
                <i class="fas fa-map-marker-alt"></i> Fatehsher, Sahiwal<br>
                <i class="fas fa-phone"></i> +92 300 1234567<br>
                <i class="fas fa-envelope"></i> meltandmore@gmail.com
            </p>
        </div>
    </div>
    <div class="footer-bottom">&copy; 2026 Melt and More &mdash; Fatehsher, Sahiwal</div>
</footer>
<button id="backToTop">&#8679;</button>
<script src="js/main.js"></script>
<script>
function updatePrice() {
    const sel  = document.getElementById('cakeSel');
    const opt  = sel.options[sel.selectedIndex];
    const qty  = parseInt(document.getElementById('qtyInput').value) || 1;
    const hint = document.getElementById('priceHint');
    if (!opt || !opt.value) { hint.style.display='none'; return; }
    const price = parseFloat(opt.dataset.price) || 0;
    const unit  = opt.dataset.unit || '';
    const total = price * qty;
    hint.style.display = 'block';
    hint.innerHTML = '<i class="fas fa-tags"></i> Rs. <strong>' + price.toLocaleString() + '</strong> &times; ' + qty + ' ' + unit + ' = <strong>Rs. ' + total.toLocaleString() + '</strong>';
    document.getElementById('totalDisplay').textContent = 'Rs. ' + total.toLocaleString();
    document.getElementById('totalInput').value = total;
}
window.addEventListener('DOMContentLoaded', updatePrice);
</script>
</body>
</html>
