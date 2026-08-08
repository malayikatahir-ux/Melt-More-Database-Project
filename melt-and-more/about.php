<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Melt and More Bakery</title>
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
            <li><a href="about.php" class="active">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="user-login.php">My Account</a></li>
            <li><a href="order.php" class="nav-admin-btn">Order Now</a></li>
        </ul>
        <button class="mobile-menu-btn">&#9776;</button>
    </div>
    <div class="mobile-nav">
        <a href="index.php">Home</a><a href="shop.php">Menu</a>
        <a href="about.php">About Us</a><a href="contact.php">Contact</a>
        <a href="user-login.php">My Account</a><a href="order.php">Order Now</a>
    </div>
</nav>

<div class="page-hero">
    <h1>About Us</h1>
    <p>The story behind Melt and More — a student, a dream, and a whole lot of passion</p>
</div>

<!-- ABOUT MAIN -->
<section class="about-section">
    <div class="about-inner">
        <div class="about-img-wrap">
            <img src="images/wedding-cake.png" alt="Melt and More Signature Cake" class="about-img-main">
            <div class="about-badge">
                <strong>2026</strong>
                Since March
            </div>
        </div>
        <div class="about-text">
            <h2>Our Story</h2>
            <p class="founded"><i class="fas fa-map-marker-alt"></i> Founded March 2026 — Fatehsher, Sahiwal, Pakistan</p>

            <p>Melt and More began as a student's story — a young girl who turned her home kitchen into the birthplace of her dream. In March 2026, armed with little more than a mixing bowl, a hand mixer, and an unshakeable love for baking, this bakery took its first steps.</p>

            <p>This is not just an online bakery — it is Malayika Tahir's labour of love. Balancing school books with baking trays, and seeing the smiles that each handcrafted treat brought to people's faces, made one thing abundantly clear: this is passion, not merely a business.</p>

            <p>Everything here is homemade. Fresh ingredients, a clean kitchen, genuine care — and a promise that every cake carries a piece of Malayika's heart. Whether it is a birthday, Eid, or any special occasion, Melt and More is ready to make it sweeter.</p>

            <div class="about-team">
                <h4>Our Team</h4>
                <div class="team-members">
                    <div class="team-member">
                        <div class="team-member-icon"><i class="fas fa-user"></i></div>
                        <div class="team-member-info">
                            <strong>Malayika Tahir</strong>
                            <span>Owner &amp; Head Baker</span>
                        </div>
                    </div>
                    <div class="team-member">
                        <div class="team-member-icon"><i class="fas fa-code"></i></div>
                        <div class="team-member-info">
                            <strong>Malayika Tahir &amp; Mahnoor</strong>
                            <span>Website Developers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TIMELINE -->
<section style="padding:80px 30px;background:#f8f9fa;">
    <div style="max-width:800px;margin:0 auto;">
        <div class="section-header">
            <h2>Our Journey</h2>
            <div class="divider"></div>
        </div>
        <div style="position:relative;padding-left:40px;">
            <div style="position:absolute;left:15px;top:0;bottom:0;width:3px;background:linear-gradient(to bottom,#00bcd4,#006064);border-radius:2px;"></div>
            <?php
            $timeline = [
                ['March 2026',  'fas fa-star',        'Day One',          'Melt and More launched from a home kitchen. The very first batch of cupcakes was made for family and friends — the response was overwhelming.'],
                ['April 2026',  'fas fa-mobile-alt',  'Online Launch',    'The website went live and the first online orders started arriving. Word spread through Instagram and the enquiries have not stopped since.'],
                ['May 2026',    'fas fa-birthday-cake','First Occasion Cake', 'The first birthday cake order came in — a 2-pound chocolate cake with a custom message. The customer\'s joy was unforgettable.'],
                ['June 2026',   'fas fa-rocket',      'Growing Fast',     'Daily orders are now the norm. New recipes, new flavours, and a growing family of sweet lovers across Sahiwal.'],
            ];
            foreach ($timeline as $t):
            ?>
            <div style="position:relative;margin-bottom:40px;padding-left:20px;">
                <div style="position:absolute;left:-33px;top:2px;width:36px;height:36px;background:#00bcd4;border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid #fff;box-shadow:0 0 0 3px #00bcd4;">
                    <i class="<?= $t[1] ?>" style="font-size:14px;color:#fff;"></i>
                </div>
                <div style="background:#fff;padding:22px 28px;border-radius:12px;box-shadow:0 3px 15px rgba(0,0,0,0.06);">
                    <div style="font-size:11px;font-weight:700;color:#00bcd4;letter-spacing:1px;text-transform:uppercase;margin-bottom:5px;"><?= $t[0] ?></div>
                    <h4 style="font-size:18px;color:#111;margin-bottom:8px;font-family:'Dancing Script',cursive;"><?= $t[2] ?></h4>
                    <p style="color:#777;font-size:14px;line-height:1.7;"><?= $t[3] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- MISSION -->
<section class="mission-section">
    <div class="inner">
        <div class="section-header">
            <h2>Our Values</h2>
            <div class="divider"></div>
            <p>The principles we build every cake upon</p>
        </div>
        <div class="mission-grid">
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-trophy"></i></div>
                <h3>High Standards</h3>
                <p>Only the finest quality ingredients. Absolutely no compromises on anything.</p>
            </div>
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-bolt"></i></div>
                <h3>Dedication</h3>
                <p>Full effort and commitment in every order. Each cake matters to us as much as it does to you.</p>
            </div>
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-leaf"></i></div>
                <h3>Freshness</h3>
                <p>Everything is baked on the same day it is delivered. Always fresh, always honest.</p>
            </div>
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-heart"></i></div>
                <h3>Love &amp; Care</h3>
                <p>We put our hearts into every cake — because this is not just food, it is a feeling.</p>
            </div>
        </div>
    </div>
</section>

<div class="wave-divider" style="background:#e0f7fa;"><svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#111"/></svg></div>
<footer>
    <div class="footer-inner">
        <div class="footer-col"><h4>Quick Links</h4><div class="footer-divider"></div>
            <a href="index.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Home</a>
            <a href="shop.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Menu</a>
            <a href="about.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">About</a>
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
    <div class="footer-bottom">&copy; 2026 Melt and More &mdash; Fatehsher, Sahiwal &mdash; Founded by Malayika Tahir</div>
</footer>
<button id="backToTop">&#8679;</button>
<script src="js/main.js"></script>
</body>
</html>
