<?php
require_once 'auth.php';
require_once '../db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($conn, $_POST['name'] ?? '');
    $quantity = floatval($_POST['quantity'] ?? 0);
    $unit = sanitize($conn, $_POST['unit'] ?? '');
    $min_stock = floatval($_POST['min_stock'] ?? 0);

    if (!$name || !$unit) {
        $error = 'Name aur unit zaroori hain.';
    } else {
        $stmt = $conn->prepare("INSERT INTO ingredients (name, quantity, unit, min_stock) VALUES (?,?,?,?)");
        $stmt->bind_param("sdsd", $name, $quantity, $unit, $min_stock);
        if ($stmt->execute()) {
            header('Location: ingredients.php?added=1');
            exit();
        } else {
            $error = 'Error: ' . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ingredient - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>➕ Naya Ingredient Add Karein</h1>
            <a href="ingredients.php" class="btn btn-outline btn-sm">← Wapis</a>
        </div>
        <div class="admin-content">
            <?php if ($error): ?><div class="alert alert-error">❌ <?= $error ?></div><?php endif; ?>
            <div class="admin-card">
                <div class="admin-card-header"><h3>Ingredient Information</h3></div>
                <div class="admin-card-body">
                    <form class="admin-form" method="POST">
                        <div class="form-group">
                            <label>Ingredient Name *</label>
                            <input type="text" name="name" placeholder="e.g. All Purpose Flour" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Current Quantity *</label>
                                <input type="number" name="quantity" placeholder="e.g. 5000" step="0.01" min="0" value="<?= htmlspecialchars($_POST['quantity'] ?? '0') ?>">
                            </div>
                            <div class="form-group">
                                <label>Unit *</label>
                                <select name="unit" required>
                                    <option value="">-- Unit Select Karein --</option>
                                    <option value="grams">Grams</option>
                                    <option value="kg">Kilograms</option>
                                    <option value="ml">Milliliters</option>
                                    <option value="liters">Liters</option>
                                    <option value="pieces">Pieces</option>
                                    <option value="cups">Cups</option>
                                    <option value="tbsp">Tablespoons</option>
                                    <option value="tsp">Teaspoons</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Minimum Stock Level (alert ke liye)</label>
                            <input type="number" name="min_stock" placeholder="e.g. 500" step="0.01" min="0" value="<?= htmlspecialchars($_POST['min_stock'] ?? '100') ?>">
                        </div>
                        <div style="display:flex;gap:15px;">
                            <button type="submit" class="btn btn-teal">✅ Save Karein</button>
                            <a href="ingredients.php" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
