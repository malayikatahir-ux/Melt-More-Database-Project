<?php
require_once 'auth.php';
require_once '../db.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: ingredients.php'); exit(); }
$ing = $conn->query("SELECT * FROM ingredients WHERE id=$id")->fetch_assoc();
if (!$ing) { header('Location: ingredients.php'); exit(); }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($conn, $_POST['name'] ?? '');
    $quantity = floatval($_POST['quantity'] ?? 0);
    $unit = sanitize($conn, $_POST['unit'] ?? '');
    $min_stock = floatval($_POST['min_stock'] ?? 0);

    if (!$name || !$unit) { $error = 'Name aur unit zaroori hain.'; }
    else {
        $stmt = $conn->prepare("UPDATE ingredients SET name=?,quantity=?,unit=?,min_stock=? WHERE id=?");
        $stmt->bind_param("sdsdi", $name, $quantity, $unit, $min_stock, $id);
        if ($stmt->execute()) { header('Location: ingredients.php?updated=1'); exit(); }
        else { $error = 'Error: ' . $conn->error; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ingredient - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>✏️ Ingredient Edit</h1>
            <a href="ingredients.php" class="btn btn-outline btn-sm">← Wapis</a>
        </div>
        <div class="admin-content">
            <?php if ($error): ?><div class="alert alert-error">❌ <?= $error ?></div><?php endif; ?>
            <div class="admin-card">
                <div class="admin-card-header"><h3>Edit: <?= htmlspecialchars($ing['name']) ?></h3></div>
                <div class="admin-card-body">
                    <form class="admin-form" method="POST">
                        <div class="form-group">
                            <label>Ingredient Name *</label>
                            <input type="text" name="name" required value="<?= htmlspecialchars($ing['name']) ?>">
                        </div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Current Quantity</label>
                                <input type="number" name="quantity" step="0.01" min="0" value="<?= $ing['quantity'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Unit *</label>
                                <select name="unit" required>
                                    <?php foreach (['grams','kg','ml','liters','pieces','cups','tbsp','tsp'] as $u): ?>
                                    <option value="<?= $u ?>" <?= $ing['unit']==$u?'selected':'' ?>><?= ucfirst($u) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Minimum Stock Level</label>
                            <input type="number" name="min_stock" step="0.01" min="0" value="<?= $ing['min_stock'] ?>">
                        </div>
                        <div style="display:flex;gap:15px;">
                            <button type="submit" class="btn btn-teal">✅ Update</button>
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
