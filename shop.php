<?php require_once 'db.php';
$cat   = isset($_GET['cat']) ? sanitize($conn, $_GET['cat']) : '';
$where = $cat ? "WHERE is_available=1 AND category='$cat'" : "WHERE is_available=1";
$cakes = $conn->query("SELECT * FROM cakes $where ORDER BY category, name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Melt and More Bakery</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .shop-grid { max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:30px; }
        .shop-card { background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,0.07);transition:all 0.3s;border:2px solid #eee; }
        .shop-card:hover { transform:translateY(-8px);box-shadow:0 15px 40px rgba(0,188,212,0.18);border-color:#00bcd4; }
        .shop-card img { width:100%;height:230px;object-fit:cover;transition:transform 0.4s; }
        .shop-card:hover img { transform:scale(1.05); }
        .shop-card-body { padding:22px; }
        .shop-card-body h3 { font-size:20px;color:#111;margin-bottom:8px;font-weight:700;font-family:'Dancing Script',cursive; }
        .shop-card-body p { color:#777;font-size:14px;line-height:1.6;margin-bottom:15px; }
        .shop-card-footer { display:flex;align-items:center;justify-content:space-between; }
        .shop-price { font-size:22px;font-weight:700;color:#00bcd4; }
        .shop-unit { font-size:12px;color:#999;display:block; }
        .cat-tabs { display:flex;gap:10px;flex-wrap:wrap;margin-bottom:40px;justify-content:center; }
        .cat-tab { padding:10px 24px;border-radius:25px;text-decoration:none;font-weight:700;font-size:14px;border:2px solid #e0e0e0;color:#333;transition:all 0.3s; }
        .cat-tab:hover,.cat-tab.active { background:#111;color:#fff;border-color:#111; }
        @media(max-width:900px){.shop-grid{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:600px){.shop-grid{grid-template-columns:1fr;}}
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
            <li><a href="shop.php" class="active">Menu</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
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
    <h1>Our Menu</h1>
    <p>Fresh handcrafted cakes, cupcakes and desserts — order yours today</p>
</div>

<section style="padding:60px 30px;background:#f8f9fa;">
    <div class="cat-tabs">
        <a href="shop.php" class="cat-tab <?= !$cat ? 'active' : '' ?>">All Items</a>
        <a href="shop.php?cat=occasion_cakes" class="cat-tab <?= $cat=='occasion_cakes' ? 'active' : '' ?>">Occasion Cakes</a>
        <a href="shop.php?cat=cupcakes" class="cat-tab <?= $cat=='cupcakes' ? 'active' : '' ?>">Cupcakes</a>
        <a href="shop.php?cat=desserts" class="cat-tab <?= $cat=='desserts' ? 'active' : '' ?>">Desserts</a>
    </div>

    <div class="shop-grid">
        <?php
        $catImgs = [
            'occasion_cakes' => [
                'images/wedding-cake.png',
                'images/cakes-hero.png',
                'https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?w=500&h=350&fit=crop',
                'https://images.unsplash.com/photo-1559620192-032c4bc4674e?w=500&h=350&fit=crop',
                'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=500&h=350&fit=crop',
            ],
            'cupcakes' => [
                'images/cupcakes.png',
                'images/strawberry-cupcakes.png',
            ],
            'desserts' => [
                'images/cheesecake-slice.png',
                'images/chocolate-mousse.png',
                'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=500&h=350&fit=crop',
            ],
        ];
        $catCounts = [];
        while ($cake = $cakes->fetch_assoc()):
            $c = $cake['category'];
            $catCounts[$c] = $catCounts[$c] ?? 0;
            $imgArr = $catImgs[$c] ?? ['images/cakes-hero.png'];
            $imgSrc = !empty($cake['image_url']) ? htmlspecialchars($cake['image_url']) : $imgArr[$catCounts[$c] % count($imgArr)];
            $catCounts[$c]++;
        ?>
        <div class="shop-card">
            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($cake['name']) ?>" loading="lazy">
            <div class="shop-card-body">
                <h3><?= htmlspecialchars($cake['name']) ?></h3>
                <p><?= htmlspecialchars($cake['description'] ?? '') ?></p>
                <div class="shop-card-footer">
                    <div>
                        <div class="shop-price">Rs. <?= number_format($cake['price'], 0) ?></div>
                        <span class="shop-unit"><?= htmlspecialchars($cake['unit']) ?></span>
                    </div>
                    <a href="order.php?cake_id=<?= $cake['id'] ?>" class="btn-primary" style="padding:10px 22px;font-size:14px;">Order</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php if (($cakes->num_rows ?? 0) === 0): ?>
        <div style="grid-column:1/-1;text-align:center;padding:60px;color:#999;">
            <i class="fas fa-birthday-cake" style="font-size:50px;margin-bottom:15px;display:block;opacity:.3;"></i>
            <p>No items in this category yet.</p>
            <a href="shop.php" class="btn-primary" style="margin-top:15px;display:inline-block;">View All Items</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section style="background:linear-gradient(135deg,#111,#1a1a2e);padding:70px 30px;text-align:center;">
    <h2 style="font-family:'Dancing Script',cursive;font-size:44px;color:#fff;margin-bottom:12px;">Need a Custom Order?</h2>
    <p style="color:rgba(255,255,255,0.75);font-size:17px;margin-bottom:30px;">Any design, any flavour — we will bring your vision to life.</p>
    <a href="order.php" class="btn-primary" style="font-size:16px;padding:15px 40px;background:#00bcd4;border-color:#00bcd4;">Place an Order</a>
    <a href="contact.php" class="btn-outline" style="font-size:16px;padding:15px 40px;margin-left:15px;color:#fff;border-color:rgba(255,255,255,0.4);background:transparent;">Contact Us</a>
</section>

<div class="wave-divider" style="background:linear-gradient(135deg,#111,#1a1a2e);"><svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#111"/></svg></div>
<footer>
    <div class="footer-inner">
        <div class="footer-col"><h4>Pages</h4><div class="footer-divider"></div>
            <a href="index.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Home</a>
            <a href="shop.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Menu</a>
            <a href="about.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">About</a>
            <a href="contact.php" style="color:rgba(255,255,255,0.55);text-decoration:none;display:block;margin:8px 0;">Contact</a>
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
