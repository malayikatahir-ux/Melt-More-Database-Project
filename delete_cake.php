<?php
require_once 'auth.php';
require_once '../db.php';

$totalCakes = $conn->query("SELECT COUNT(*) as c FROM cakes")->fetch_assoc()['c'];
$totalOrders = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
$pendingOrders = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='pending'")->fetch_assoc()['c'];
$totalRevenue = $conn->query("SELECT SUM(total_amount) as s FROM orders WHERE status != 'cancelled'")->fetch_assoc()['s'] ?? 0;

$recentOrders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 8");
$lowIngredients = $conn->query("SELECT * FROM ingredients WHERE quantity <= min_stock ORDER BY quantity ASC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">

    <?php include 'sidebar.php'; ?>

    <div class="admin-main">
        <div class="admin-topbar">
            <h1>📊 Dashboard</h1>
            <div class="topbar-actions">
                <span class="topbar-badge">🗓️ <?= date('d M Y') ?></span>
                <a href="../index.php" class="btn btn-outline btn-sm" target="_blank">🌐 Website Dekhein</a>
            </div>
        </div>

        <div class="admin-content">

            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon teal">🎂</div>
                    <div>
                        <div class="stat-value"><?= $totalCakes ?></div>
                        <div class="stat-label">Total Products</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue">📦</div>
                    <div>
                        <div class="stat-value"><?= $totalOrders ?></div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">⏳</div>
                    <div>
                        <div class="stat-value"><?= $pendingOrders ?></div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">💰</div>
                    <div>
                        <div class="stat-value">Rs.<?= number_format($totalRevenue, 0) ?></div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                </div>
            </div>

            <!-- RECENT ORDERS -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>📦 Recent Orders</h3>
                    <a href="orders.php" class="btn btn-teal btn-sm">Sab Dekhein</a>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $recentOrders->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($order['order_number']) ?></strong></td>
                                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                <td><?= htmlspecialchars($order['customer_phone']) ?></td>
                                <td><strong>Rs. <?= number_format($order['total_amount'], 0) ?></strong></td>
                                <td><span class="badge badge-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span></td>
                                <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                                <td><a href="order_detail.php?id=<?= $order['id'] ?>" class="btn btn-outline btn-sm">Details</a></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- LOW STOCK INGREDIENTS -->
            <?php if ($lowIngredients->num_rows > 0): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>⚠️ Low Stock Ingredients</h3>
                    <a href="ingredients.php" class="btn btn-warning btn-sm">Sab Dekhein</a>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr><th>Ingredient</th><th>Current Stock</th><th>Min Stock</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php while ($ing = $lowIngredients->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($ing['name']) ?></td>
                                <td><?= $ing['quantity'] ?> <?= $ing['unit'] ?></td>
                                <td><?= $ing['min_stock'] ?> <?= $ing['unit'] ?></td>
                                <td><span class="badge badge-low">⚠ Low Stock</span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
</body>
</html>
