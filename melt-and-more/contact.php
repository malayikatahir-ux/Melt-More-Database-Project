<?php require_once 'db.php';
$sent = false; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = sanitize($conn, $_POST['name'] ?? '');
    $email = sanitize($conn, $_POST['email'] ?? '');
    if ($name && $email) { $sent = true; }
    else { $error = 'Name and email are required.'; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Melt and More</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <li><a href="contact.php" class="active">Contact</a></li>
            <li><a href="user-login.php">My Account</a></li>
            <li><a href="order.php" class="nav-admin-btn">Order Now</a></li>
        </ul>
        <button class="mobile-menu-btn">&#9776;</button>
    </div>
    <div class="mobile-nav">
        <a href="index.php">Home</a><a href="shop.php">Menu</a>
        <a href="about.php">About</a><a href="contact.php">Contact</a>
        <a href="user-login.php">My Account</a><a href="order.php">Order Now</a>
    </div>
</nav>
<div class="page-hero">
    <h1>Contact Us</h1>
    <p>We would love to hear from you — reach out any time</p>
</div>

<section style="padding:80px 30px;background:#fff;">
    <div class="contact-grid">
        <div class="contact-info">
            <h3>Get In Touch</h3>
            <p style="color:#777;margin-bottom:30px;line-height:1.7;">Have a custom cake inquiry, a question about our menu, or simply want to say hello? Send us a message and we will respond promptly.</p>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-phone"></i></div>
                <div><h4>Phone / WhatsApp</h4><p>+92 300 1234567<br>Monday – Saturday, 9 am – 8 pm</p></div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                <div><h4>Email</h4><p>meltandmore@gmail.com<br>We reply within 24 hours</p></div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fab fa-instagram"></i></div>
                <div><h4>Instagram</h4><p>@meltandmore.pk<br>See our latest creations</p></div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div><h4>Location</h4><p>Fatehsher, Sahiwal<br>Punjab, Pakistan</p></div>
            </div>
        </div>
        <div>
            <?php if ($sent): ?>
            <div style="text-align:center;padding:50px;background:#fff;border-radius:16px;box-shadow:0 5px 20px rgba(0,0,0,0.07);">
                <i class="fas fa-check-circle" style="font-size:60px;color:#00bcd4;margin-bottom:20px;display:block;"></i>
                <h3 style="color:#111;margin-bottom:10px;font-family:'Dancing Script',cursive;font-size:30px;">Message Sent!</h3>
                <p style="color:#777;">Thank you for reaching out. We will get back to you shortly.</p>
                <a href="index.php" class="btn-primary" style="display:inline-block;margin-top:20px;">Back to Home</a>
            </div>
            <?php else: ?>
            <div class="order-form-wrap" style="margin:0;">
                <h3 style="font-family:'Dancing Script',cursive;font-size:28px;color:#111;margin-bottom:20px;">Send a Message</h3>
                <?php if ($error): ?><div class="alert-error"><?= $error ?></div><?php endif; ?>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group"><label>Your Name</label><input type="text" name="name" placeholder="Full name" required></div>
                        <div class="form-group"><label>Email Address</label><input type="email" name="email" placeholder="your@email.com" required></div>
                    </div>
                    <div class="form-group"><label>Phone Number</label><input type="tel" name="phone" placeholder="+92 300 1234567"></div>
                    <div class="form-group">
                        <label>Subject</label>
                        <select name="subject">
                            <option>Custom Cake Order Inquiry</option>
                            <option>Pricing Information</option>
                            <option>Delivery Information</option>
                            <option>Feedback / Review</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Message</label><textarea name="message" placeholder="Write your message here..." required></textarea></div>
                    <button type="submit" class="btn-primary" style="width:100%;font-size:16px;padding:15px;border:none;cursor:pointer;font-family:inherit;">Send Message</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="wave-divider"><svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#111"/></svg></div>
<footer>
    <div class="footer-inner">
        <div class="footer-col"><h4>Quick Links</h4><div class="footer-divider"></div>
            <a href="index.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Home</a>
            <a href="shop.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Menu</a>
            <a href="order.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Order Now</a>
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
</body>
</html>
