<?php
require_once 'auth.php';
require_once '../db.php';

$msg = '';
if (isset($_GET['deleted'])) $msg = '✅ Product delete ho gaya.';
if (isset($_GET['updated'])) $msg = '✅ Product update ho gaya.';
if (isset($_GET['added'])) $msg = '✅ Naya product add ho gaya.';

$status_filter = isset($_GET['status']) ? sanitize($conn, $_GET['status']) : '';
$search = isset($_GET['search']) ? sanitize($conn, $_GET['search']) : '';

$where = "WHERE 1=1";
if ($status_filter === 'available') $where .= " AND is_available = 1";
if ($status_filter === 'unavailable') $where .= " AND is_available = 0";
if ($search) $where .= " AND (name LIKE '%$search%' OR category LIKE '%$search%')";

$cakes = $conn->query("SELECT * FROM cakes $where ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cakes - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>🎂 Cakes & Products</h1>
            <div class="topbar-actions">
                <a href="add_cake.php" class="btn btn-teal">➕ Naya Product Add Karein</a>
            </div>
        </div>
        <div class="admin-content">
            <?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>

            <!-- FILTERS -->
            <div class="admin-card" style="margin-bottom:20px;">
                <div class="admin-card-body" style="padding:15px 25px;">
                    <form method="GET" style="display:flex;gap:15px;align-items:center;flex-wrap:wrap;">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                            placeholder="Product search karein..." style="padding:9px 15px;border:2px solid #e0e0e0;border-radius:8px;font-family:inherit;font-size:14px;outline:none;min-width:200px;">
                        <select name="status" style="padding:9px 15px;border:2px solid #e0e0e0;border-radius:8px;font-family:inherit;font-size:14px;outline:none;">
                            <option value="">Sab Status</option>
                            <option value="available" <?= $status_filter==='available'?'selected':'' ?>>Available</option>
                            <option value="unavailable" <?= $status_filter==='unavailable'?'selected':'' ?>>Unavailable</option>
                        </select>
                        <button type="submit" class="btn btn-teal">🔍 Filter</button>
                        <a href="cakes.php" class="btn btn-outline">Reset</a>
                    </form>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Products List (<?= $cakes->num_rows ?>)</h3>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; while ($cake = $cakes->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($cake['name']) ?></strong>
                                    <?php if ($cake['description']): ?>
                                    <br><small style="color:#999;"><?= htmlspecialchars(substr($cake['description'], 0, 50)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars(str_replace('_', ' ', ucfirst($cake['category']))) ?></td>
                                <td><strong>Rs. <?= number_format($cake['price'], 0) ?></strong></td>
                                <td><?= htmlspecialchars($cake['unit']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $cake['is_available'] ? 'available' : 'unavailable' ?>">
                                        <?= $cake['is_available'] ? '✅ Available' : '❌ Unavailable' ?>
                                    </span>
                                </td>
                                <td style="white-space:nowrap;">
                                    <a href="edit_cake.php?id=<?= $cake['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                                    <a href="delete_cake.php?id=<?= $cake['id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Kya aap ye product delete karna chahte hain?')">🗑️ Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if ($cakes->num_rows === 0): ?>
                            <tr><td colspan="7" style="text-align:center;padding:30px;color:#999;">Koi product nahi mila.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
