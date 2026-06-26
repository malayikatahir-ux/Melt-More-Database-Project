<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">🎂</div>
        <h2>Melt & More</h2>
        <p>Admin Panel</p>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section-title">Main</div>
        <a href="dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="sidebar-section-title">Products</div>
        <a href="cakes.php" class="<?= $currentPage === 'cakes.php' ? 'active' : '' ?>">
            <span class="nav-icon">🎂</span> Cakes & Products
        </a>
        <a href="add_cake.php" class="<?= $currentPage === 'add_cake.php' ? 'active' : '' ?>">
            <span class="nav-icon">➕</span> Naya Product
        </a>

        <div class="sidebar-section-title">Orders</div>
        <a href="orders.php" class="<?= $currentPage === 'orders.php' ? 'active' : '' ?>">
            <span class="nav-icon">📦</span> Sab Orders
        </a>
        <?php
        $pending = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='pending'")->fetch_assoc()['c'];
        if ($pending > 0): ?>
        <a href="orders.php?status=pending" style="color:#f39c12;">
            <span class="nav-icon">⏳</span> Pending (<?= $pending ?>)
        </a>
        <?php endif; ?>

        <div class="sidebar-section-title">Inventory</div>
        <a href="ingredients.php" class="<?= $currentPage === 'ingredients.php' ? 'active' : '' ?>">
            <span class="nav-icon">🥣</span> Ingredients
        </a>
        <a href="add_ingredient.php" class="<?= $currentPage === 'add_ingredient.php' ? 'active' : '' ?>">
            <span class="nav-icon">➕</span> Ingredient Add
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">👤</div>
            <div class="sidebar-user-info">
                <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></strong>
                <span>Administrator</span>
            </div>
        </div>
        <a href="logout.php" class="logout-btn">🚪 Logout</a>
    </div>
</aside>
