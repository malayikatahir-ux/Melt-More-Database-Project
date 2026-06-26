<?php
require_once 'auth.php';
require_once '../db.php';

$msg = '';
if (isset($_GET['deleted'])) $msg = '✅ Ingredient delete ho gaya.';
if (isset($_GET['added'])) $msg = '✅ Naya ingredient add ho gaya.';
if (isset($_GET['updated'])) $msg = '✅ Ingredient update ho gaya.';

// Quick stock update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
    $ing_id = intval($_POST['ing_id']);
    $qty = floatval($_POST['quantity']);
    $conn->query("UPDATE ingredients SET quantity=$qty WHERE id=$ing_id");
    header('Location: ingredients.php?updated=1');
    exit();
}

$ingredients = $conn->query("SELECT * FROM ingredients ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredients - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>🥣 Ingredients Management</h1>
            <a href="add_ingredient.php" class="btn btn-teal">➕ Naya Ingredient</a>
        </div>
        <div class="admin-content">
            <?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Ingredients Stock (<?= $ingredients->num_rows ?>)</h3>
                    <span style="font-size:13px;color:#999;">Low stock = current ≤ min stock</span>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ingredient</th>
                                <th>Current Stock</th>
                                <th>Min Stock</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Stock Update</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; while ($ing = $ingredients->fetch_assoc()):
                                $pct = $ing['min_stock'] > 0 ? min(100, ($ing['quantity'] / ($ing['min_stock'] * 2)) * 100) : 100;
                                $status = $ing['quantity'] <= 0 ? 'empty' : ($ing['quantity'] <= $ing['min_stock'] ? 'low' : 'ok');
                            ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><strong><?= htmlspecialchars($ing['name']) ?></strong></td>
                                <td>
                                    <?= number_format($ing['quantity'], 0) ?>
                                    <div class="stock-bar">
                                        <div class="stock-bar-fill <?= $status ?>" style="width:<?= $pct ?>%;"></div>
                                    </div>
                                </td>
                                <td><?= number_format($ing['min_stock'], 0) ?></td>
                                <td><?= htmlspecialchars($ing['unit']) ?></td>
                                <td>
                                    <?php if ($status === 'empty'): ?>
                                        <span class="badge badge-cancelled">❌ Out of Stock</span>
                                    <?php elseif ($status === 'low'): ?>
                                        <span class="badge badge-low">⚠ Low Stock</span>
                                    <?php else: ?>
                                        <span class="badge badge-ok">✅ OK</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" style="display:flex;gap:8px;align-items:center;">
                                        <input type="hidden" name="ing_id" value="<?= $ing['id'] ?>">
                                        <input type="number" name="quantity" value="<?= $ing['quantity'] ?>" step="0.01" min="0"
                                            style="width:80px;padding:5px 8px;border:2px solid #e0e0e0;border-radius:6px;font-family:inherit;font-size:13px;">
                                        <button type="submit" name="update_stock" class="btn btn-success btn-sm">✅</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="edit_ingredient.php?id=<?= $ing['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                    <a href="delete_ingredient.php?id=<?= $ing['id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete karein?')">🗑️</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
