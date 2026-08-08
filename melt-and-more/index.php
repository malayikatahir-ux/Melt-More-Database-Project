<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melt and More - Homemade Cakes &amp; Bakery | Fatehsher, Sahiwal</title>
    <meta name="description" content="Melt and More - Handcrafted cakes, cupcakes and desserts made with love in Fatehsher, Sahiwal.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- TOP BAR -->
<div class="top-bar">
    <span><i class="fas fa-map-marker-alt" style="color:#00bcd4;margin-right:5px;"></i> Fatehsher, Sahiwal &nbsp;|&nbsp; <a href="mailto:meltandmore@gmail.com">meltandmore@gmail.com</a></span>
    <span><i class="fas fa-phone" style="color:#00bcd4;margin-right:5px;"></i> <a href="tel:+923001234567">+92 300 1234567</a> &nbsp;|&nbsp; Free delivery on orders above Rs. 2,000</span>
</div>

<!-- NAVIGATION -->
<nav>
    <div class="nav-container">
        <a href="index.php" class="logo">
            <div class="logo-circle">
                <div class="logo-title">Melt&More</div>
                <div class="logo-sub">SWEET BAKERY</div>
            </div>
        </a>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Home</a></li>
            <li>
                <a href="shop.php">Menu</a>
                <div class="dropdown-menu">
                    <a href="shop.php?cat=occasion_cakes">Occasion Cakes</a>
                    <a href="shop.php?cat=cupcakes">Cupcakes</a>
                    <a href="shop.php?cat=desserts">Desserts</a>
                    <a href="shop.php">All Products</a>
                </div>
            </li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="user-login.php">My Account</a></li>
            <li><a href="order.php" class="nav-admin-btn">Order Now</a></li>
        </ul>
        <button class="mobile-menu-btn">&#9776;</button>
    </div>
    <div class="mobile-nav">
        <a href="index.php">Home</a>
        <a href="shop.php">Menu</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>
        <a href="user-login.php">My Account</a>
        <a href="order.php">Order Now</a>
        <a href="admin/login.php" style="color:#999;font-size:13px;">Admin</a>
    </div>
</nav>

<!-- HERO SECTION - Bellaria Style -->
<section class="hero">
    <div class="hero-bg-img"></div>
    <div class="hero-overlay"></div>
    <div class="hero-center">
        <div class="hero-badge">
            <div class="hero-badge-icon"></div>
            <h1>Welcome to<br>Melt and More</h1>
            <p>Handcrafted cakes, cupcakes and desserts made fresh daily with the finest ingredients.</p>
            <div class="hero-badge-btns">
                <a href="order.php" class="btn-primary">Order Now</a>
                <a href="shop.php" class="btn-outline">View Menu</a>
            </div>
        </div>
    </div>
</section>

<!-- WAVE -->
<div class="wave-divider">
    <svg viewBox="0 0 1200 80" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C150,80 350,0 600,40 C850,80 1050,0 1200,40 L1200,80 L0,80 Z" fill="#111111"/>
    </svg>
</div>

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="inner">
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-crown"></i></div>
                <h3>Tradition</h3>
                <p>Every cake is made following time-honoured homemade recipes. Everything is fresh and handcrafted from scratch.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-star"></i></div>
                <h3>Quality</h3>
                <p>Only premium-grade ingredients are used. No artificial flavours, no shortcuts — pure, honest goodness in every bite.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-palette"></i></div>
                <h3>Creativity</h3>
                <p>Every order is unique. Custom designs, flavours and decorations tailored exactly to your vision.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-heart"></i></div>
                <h3>Passion</h3>
                <p>Baking is not just a craft here — it is a calling. Every piece carries genuine care and dedication.</p>
            </div>
        </div>
        <div class="know-btn-wrap">
            <a href="about.php" class="know-btn">Learn More About Us</a>
        </div>
    </div>
</section>

<!-- WAVE REVERSE -->
<div class="wave-divider" style="transform:scaleY(-1);background:#f8f9fa;">
    <svg viewBox="0 0 1200 80" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C150,80 350,0 600,40 C850,80 1050,0 1200,40 L1200,80 L0,80 Z" fill="#111111"/>
    </svg>
</div>

<!-- PRICING SECTION -->
<section class="pricing-section">
    <div class="section-header">
        <h2>Our Prices</h2>
        <div class="divider"></div>
        <p>The finest cakes at the most accessible prices</p>
    </div>
    <div class="pricing-grid">

        <div class="price-card">
            <img src="images/wedding-cake.png" class="price-card-donut" alt="Occasion Cake">
            <h3>Occasion Cakes</h3>
            <div class="price-amount">Rs. <span>1,400</span></div>
            <div class="price-label">1 POUND</div>
            <ul class="price-features">
                <li>Vanilla, Chocolate or Red Velvet</li>
                <li>Fresh Cream Frosting</li>
                <li>Custom Message Included</li>
                <li>Same Day Available</li>
            </ul>
            <a href="order.php" class="order-btn">Order Now</a>
        </div>

        <div class="price-card">
            <img src="images/cupcakes.png" class="price-card-donut" alt="Cupcakes">
            <h3>Cupcakes</h3>
            <div class="price-amount">Rs. <span>1,000</span></div>
            <div class="price-label">6 PIECES</div>
            <ul class="price-features">
                <li>Mixed Flavours Available</li>
                <li>Buttercream Frosting</li>
                <li>Baked Fresh Daily</li>
                <li>Gift Packaging</li>
            </ul>
            <a href="order.php" class="order-btn">Order Now</a>
        </div>

        <div class="price-card featured" style="position:relative;">
            <div class="best-badge">Best Seller</div>
            <img src="images/cakes-hero.png" class="price-card-donut" alt="2 Pound Cake">
            <h3>2 Pound Cake</h3>
            <div class="price-amount">Rs. <span>2,400</span></div>
            <div class="price-label">2 POUND</div>
            <ul class="price-features">
                <li>Serves 10 – 12 People</li>
                <li>Custom Design</li>
                <li>Fondant or Cream Finish</li>
                <li>Candles Included</li>
            </ul>
            <a href="order.php" class="order-btn">Order Now</a>
        </div>

        <div class="price-card">
            <img src="https://images.unsplash.com/photo-1514190051997-0f6f39ca5cde?w=200&h=200&fit=crop" class="price-card-donut" alt="Chocolate Mousse">
            <h3>Chocolate Mousse</h3>
            <div class="price-amount">Rs. <span>350</span></div>
            <div class="price-label">1 CUP</div>
            <ul class="price-features">
                <li>Premium Dark Chocolate</li>
                <li>Silky Smooth Texture</li>
                <li>Prepared Fresh Daily</li>
                <li>Topping Options</li>
            </ul>
            <a href="order.php" class="order-btn">Order Now</a>
        </div>

    </div>
</section>

<!-- GALLERY -->
<section class="gallery-section">
    <div class="section-header">
        <h2>Our Gallery</h2>
        <div class="divider"></div>
        <p>A glimpse of our handcrafted creations</p>
    </div>
    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="images/wedding-cake.png" alt="Wedding Cake">
            <div class="gallery-item-info"><h4>Wedding Cake</h4><p>By Malayika</p></div>
        </div>
        <div class="gallery-item">
            <img src="images/cupcakes.png" alt="Cupcakes">
            <div class="gallery-item-info"><h4>Fresh Cupcakes</h4><p>By Malayika</p></div>
        </div>
        <div class="gallery-item">
            <img src="images/cakes-hero.png" alt="Cake Collection">
            <div class="gallery-item-info"><h4>Signature Cakes</h4><p>By Malayika</p></div>
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?w=500&h=350&fit=crop" alt="Red Velvet Cake">
            <div class="gallery-item-info"><h4>Red Velvet Cake</h4><p>By Malayika</p></div>
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=500&h=350&fit=crop" alt="Cheesecake">
            <div class="gallery-item-info"><h4>New York Cheesecake</h4><p>By Malayika</p></div>
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1559620192-032c4bc4674e?w=500&h=350&fit=crop" alt="Black Forest Cake">
            <div class="gallery-item-info"><h4>Black Forest Cake</h4><p>By Malayika</p></div>
        </div>
    </div>
</section>

<!-- MISSION -->
<section class="mission-section">
    <div class="inner">
        <div class="section-header">
            <h2>Our Mission</h2>
            <div class="divider"></div>
            <p>To bring joy to every home and sweetness to every occasion — that is our purpose.</p>
        </div>
        <div class="mission-grid">
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-trophy"></i></div>
                <h3>High Standards</h3>
                <p>Only the finest quality ingredients are used. Every cake reflects 100% effort and care.</p>
            </div>
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-bolt"></i></div>
                <h3>Dedicated Work</h3>
                <p>We work around the clock to ensure your order is ready on time, exactly as requested.</p>
            </div>
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-leaf"></i></div>
                <h3>Always Fresh</h3>
                <p>Everything is baked fresh to order. No pre-made items, no stale products — guaranteed.</p>
            </div>
            <div class="mission-item">
                <div class="mission-icon"><i class="fas fa-heart"></i></div>
                <h3>Made with Love</h3>
                <p>Baking is our passion. Every item carries genuine care and love in every layer.</p>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials-section">
    <div class="section-header">
        <h2>What Clients Say</h2>
        <div class="divider"></div>
    </div>
    <div class="testimonial-card">
        <div style="width:70px;height:70px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;border:3px solid rgba(255,255,255,0.4);">
            <i class="fas fa-user" style="font-size:28px;color:rgba(255,255,255,0.8);"></i>
        </div>
        <div class="testimonial-text">"The chocolate cake from Melt and More was absolutely extraordinary. Everyone at my birthday celebration was in awe. Malayika's baking is on a completely different level!"</div>
        <div class="testimonial-name">Ayesha Khan</div>
        <div class="testimonial-dots">
            <span class="active"></span><span></span><span></span>
        </div>
    </div>
</section>

<!-- FOOTER WAVE -->
<div class="wave-divider" style="background:#fff;">
    <svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#111111"/>
    </svg>
</div>

<footer>
    <div class="footer-inner">
        <div class="footer-col">
            <h4>Follow Us</h4>
            <div class="footer-divider"></div>
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                <a href="https://wa.me/923001234567" class="social-link"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
            </div>
            <p style="color:rgba(255,255,255,0.45);margin-top:20px;font-size:13px;">Instagram: @meltandmore.pk</p>
        </div>
        <div class="footer-col">
            <div class="footer-logo-circle">
                <div class="footer-logo-title">Melt&More</div>
                <div class="footer-logo-sub">SWEET BAKERY</div>
            </div>
        </div>
        <div class="footer-col">
            <h4>Stay Updated</h4>
            <div class="footer-divider"></div>
            <p style="color:rgba(255,255,255,0.45);font-size:14px;margin-bottom:12px;">Subscribe for new flavours and seasonal offers.</p>
            <div class="newsletter-input-wrap">
                <input type="email" class="newsletter-input" placeholder="Your email address">
                <button class="newsletter-btn">Subscribe</button>
            </div>
            <p style="color:rgba(255,255,255,0.35);font-size:12px;margin-top:15px;line-height:2;">
                <i class="fas fa-map-marker-alt"></i> Fatehsher, Sahiwal<br>
                <i class="fas fa-phone"></i> +92 300 1234567<br>
                <i class="fas fa-envelope"></i> meltandmore@gmail.com
            </p>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2026 Melt and More &mdash; Fatehsher, Sahiwal &mdash; Founded by Malayika Tahir
        <a href="admin/login.php" style="color:rgba(255,255,255,0.2);text-decoration:none;margin-left:10px;">Admin</a>
    </div>
</footer>

<button id="backToTop" title="Back to top">&#8679;</button>
<script src="js/main.js"></script>
</body>
</html>
