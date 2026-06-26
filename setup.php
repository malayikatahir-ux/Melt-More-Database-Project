<?php
/**
 * MELT AND MORE - First Time Setup
 * Run this file ONCE at: http://localhost/melt-and-more/setup.php
 * Creates admin account, users table, and sample data.
 * DELETE this file after running it.
 */
require_once 'db.php';
$messages = [];

// --- Admin table ---
$conn->query("CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// --- Users (customers) table ---
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    phone VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// --- Cakes table ---
$conn->query("CREATE TABLE IF NOT EXISTS cakes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    unit VARCHAR(100) DEFAULT '1 piece',
    image_url VARCHAR(500) DEFAULT '',
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// --- Ingredients table ---
$conn->query("CREATE TABLE IF NOT EXISTS ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    quantity DECIMAL(10,2) DEFAULT 0,
    unit VARCHAR(50) DEFAULT 'grams',
    min_stock DECIMAL(10,2) DEFAULT 100,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// --- Orders table (updated structure) ---
$conn->query("CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    customer_name VARCHAR(200) NOT NULL,
    customer_email VARCHAR(200) DEFAULT '',
    customer_phone VARCHAR(50) NOT NULL,
    delivery_address VARCHAR(500) DEFAULT '',
    cake_name VARCHAR(200) DEFAULT '',
    quantity INT DEFAULT 1,
    total_amount DECIMAL(10,2) NOT NULL,
    delivery_date DATE DEFAULT NULL,
    special_notes TEXT,
    status ENUM('pending','confirmed','preparing','delivered','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$messages[] = "All database tables created / verified.";

// --- Admin account ---
$hashed = password_hash('admin123', PASSWORD_BCRYPT);
$check  = $conn->query("SELECT id FROM admins WHERE username='admin'")->num_rows;
if ($check > 0) {
    $stmt = $conn->prepare("UPDATE admins SET password=?, full_name='Malayika Tahir' WHERE username='admin'");
    $stmt->bind_param("s", $hashed); $stmt->execute();
    $messages[] = "Admin password reset to: <strong>admin123</strong>";
} else {
    $stmt = $conn->prepare("INSERT INTO admins (username, password, full_name) VALUES ('admin', ?, 'Malayika Tahir')");
    $stmt->bind_param("s", $hashed); $stmt->execute();
    $messages[] = "Admin account created. Username: <strong>admin</strong>, Password: <strong>admin123</strong>";
}

// --- Sample cakes ---
$cakeCount = $conn->query("SELECT COUNT(*) c FROM cakes")->fetch_assoc()['c'];
if ($cakeCount == 0) {
    $cakes = [
        ['1 Pound Vanilla Cake',        'occasion_cakes','Homemade vanilla sponge cake with fresh cream frosting. Perfect for birthdays.', 1400.00,'1 Pound',   ''],
        ['2 Pound Chocolate Cake',       'occasion_cakes','Rich chocolate cake. Serves 10-12 people. Custom design available.',           2400.00,'2 Pound',   ''],
        ['Cupcakes - 6 Pieces',          'cupcakes',      'Assorted homemade cupcakes with buttercream frosting. Mix or single flavour.',  1000.00,'6 Pieces',  ''],
        ['Chocolate Mousse',             'desserts',      'Creamy mousse made with premium dark chocolate. Served in a cup.',             350.00, '1 Cup',     ''],
        ['Red Velvet Cake (1 Pound)',     'occasion_cakes','Classic red velvet with cream cheese frosting.',                               1600.00,'1 Pound',   ''],
        ['Strawberry Cupcakes - 6 Pcs',  'cupcakes',      'Fresh strawberry cupcakes with pink frosting. Great for gifting.',             1200.00,'6 Pieces',  ''],
        ['Black Forest Cake (2 Pound)',   'occasion_cakes','Traditional Black Forest gateau with cherries and cream.',                    2800.00,'2 Pound',   ''],
        ['Cheesecake Slice',             'desserts',      'Creamy New York style cheesecake with berry topping.',                        450.00, '1 Slice',   ''],
    ];
    $s = $conn->prepare("INSERT INTO cakes (name,category,description,price,unit,image_url) VALUES (?,?,?,?,?,?)");
    foreach ($cakes as $c) { $s->bind_param("sssdss",$c[0],$c[1],$c[2],$c[3],$c[4],$c[5]); $s->execute(); }
    $messages[] = "Sample products added (8 items).";
}

// --- Sample ingredients ---
$ingCount = $conn->query("SELECT COUNT(*) c FROM ingredients")->fetch_assoc()['c'];
if ($ingCount == 0) {
    $ings = [
        ['All Purpose Flour',5000,'grams',1000], ['Sugar',3000,'grams',500],
        ['Butter',2000,'grams',300],             ['Eggs',48,'pieces',12],
        ['Milk',5000,'ml',1000],                 ['Vanilla Extract',200,'ml',50],
        ['Baking Powder',500,'grams',100],        ['Cocoa Powder',1000,'grams',200],
        ['Heavy Cream',2000,'ml',500],            ['Cream Cheese',1500,'grams',300],
        ['Dark Chocolate',2000,'grams',300],      ['Food Color Red',100,'ml',20],
        ['Icing Sugar',2000,'grams',500],
    ];
    $s = $conn->prepare("INSERT INTO ingredients (name,quantity,unit,min_stock) VALUES (?,?,?,?)");
    foreach ($ings as $i) { $s->bind_param("sdsd",$i[0],$i[1],$i[2],$i[3]); $s->execute(); }
    $messages[] = "Sample ingredients added (13 items).";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - Melt and More</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Segoe UI',sans-serif;background:#e0f7fa;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px;}
        .card{background:#fff;padding:40px;border-radius:16px;box-shadow:0 10px 40px rgba(0,0,0,0.1);max-width:520px;width:100%;}
        .logo{font-size:28px;font-weight:700;color:#111;margin-bottom:4px;}
        .sub{color:#00bcd4;font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:20px;}
        h2{font-size:20px;color:#111;margin-bottom:16px;}
        .msg{padding:11px 14px;border-radius:8px;margin-bottom:10px;background:#e0f7fa;color:#007c91;font-size:14px;line-height:1.5;border:1px solid #b2ebf2;}
        .msg::before{content:'OK  ';font-weight:700;}
        .btn{display:inline-block;background:#111;color:#fff;padding:12px 26px;border-radius:8px;text-decoration:none;font-weight:700;margin:5px 5px 0 0;font-size:14px;transition:background 0.3s;}
        .btn:hover{background:#00bcd4;}
        .btn-cyan{background:#00bcd4;}
        .btn-cyan:hover{background:#0097a7;}
        .warn{background:#fff8e1;color:#e65100;padding:14px;border-radius:8px;font-size:13px;margin-top:20px;border:1px solid #ffcc02;line-height:1.6;}
        .divider{height:1px;background:#f0f0f0;margin:20px 0;}
    </style>
</head>
<body>
<div class="card">
    <div class="logo">Melt and More</div>
    <div class="sub">Sweet Bakery &mdash; Setup</div>
    <h2>Database Setup Complete</h2>

    <?php foreach ($messages as $m): ?>
        <div class="msg"><?= $m ?></div>
    <?php endforeach; ?>

    <div class="divider"></div>
    <a href="index.php" class="btn">Go to Website</a>
    <a href="admin/login.php" class="btn btn-cyan">Admin Login</a>
    <a href="user-login.php" class="btn" style="background:#444;">Customer Login</a>

    <div class="warn">
        <strong>Security Notice:</strong> Delete or rename <code>setup.php</code> after this setup is complete. Leaving it accessible allows anyone to reset the admin password.
    </div>
</div>
</body>
</html>
