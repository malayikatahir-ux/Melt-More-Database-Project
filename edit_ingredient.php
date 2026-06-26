<?php
require_once 'auth.php';
require_once '../db.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: cakes.php'); exit(); }

$cake = $conn->query("SELECT * FROM cakes WHERE id=$id")->fetch_assoc();
if (!$cake) { header('Location: cakes.php'); exit(); }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($conn, $_POST['name'] ?? '');
    $category = sanitize($conn, $_POST['category'] ?? '');
    $description = sanitize($conn, $_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $unit = sanitize($conn, $_POST['unit'] ?? '');
    $image_url = sanitize($conn, $_POST['image_url'] ?? '');
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    if (!$name || !$category || !$price) {
        $error = 'Name, category aur price zaroori hain.';
    } else {
        $stmt = $conn->prepare("UPDATE cakes SET name=?, category=?, description=?, price=?, unit=?, image_url=?, is_available=? WHERE id=?");
        $stmt->bind_param("sssdssii", $name, $category, $description, $price, $unit, $image_url, $is_available, $id);
        if ($stmt->execute()) {
            header('Location: cakes.php?updated=1');
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
    <title>Edit Product - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>✏️ Product Edit Karein</h1>
            <a href="cakes.php" class="btn btn-outline btn-sm">← Wapis</a>
        </div>
        <div class="admin-content">
            <?php if ($error): ?><div class="alert alert-error">❌ <?= $error ?></div><?php endif; ?>

            <div class="admin-card">
                <div class="admin-card-header"><h3>Edit: <?= htmlspecialchars($cake['name']) ?></h3></div>
                <div class="admin-card-body">
                    <form class="admin-form" method="POST">
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Product Name *</label>
                                <input type="text" name="name" required value="<?= htmlspecialchars($cake['name']) ?>">
                            </div>
                            <div class="form-group">
                                <label>Category *</label>
                                <select name="category" required>
                                    <option value="occasion_cakes" <?= $cake['category']=='occasion_cakes'?'selected':'' ?>>Occasion Cakes</option>
                                    <option value="cupcakes" <?= $cake['category']=='cupcakes'?'selected':'' ?>>Cupcakes</option>
                                    <option value="desserts" <?= $cake['category']=='desserts'?'selected':'' ?>>Desserts</option>
                                    <option value="special" <?= $cake['category']=='special'?'selected':'' ?>>Special Items</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Price (Rs.) *</label>
                                <input type="number" name="price" step="0.01" min="0" required value="<?= $cake['price'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="unit" value="<?= htmlspecialchars($cake['unit']) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description"><?= htmlspecialchars($cake['description']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Image URL</label>
                            <input type="url" name="image_url" value="<?= htmlspecialchars($cake['image_url']) ?>">
                        </div>
                        <div class="form-group">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                                <input type="checkbox" name="is_available" value="1" <?= $cake['is_available']?'checked':'' ?> style="width:auto;">
                                Available hai
                            </label>
                        </div>
                        <div style="display:flex;gap:15px;">
                            <button type="submit" class="btn btn-teal">✅ Update Karein</button>
                            <a href="cakes.php" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
