<?php
require_once 'auth.php';
require_once '../db.php';

$error = '';
$success = '';

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
        $stmt = $conn->prepare("INSERT INTO cakes (name, category, description, price, unit, image_url, is_available) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssdssi", $name, $category, $description, $price, $unit, $image_url, $is_available);
        if ($stmt->execute()) {
            header('Location: cakes.php?added=1');
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
    <title>Naya Product - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>➕ Naya Product Add Karein</h1>
            <a href="cakes.php" class="btn btn-outline btn-sm">← Wapis</a>
        </div>
        <div class="admin-content">
            <?php if ($error): ?><div class="alert alert-error">❌ <?= $error ?></div><?php endif; ?>

            <div class="admin-card">
                <div class="admin-card-header"><h3>Product Information</h3></div>
                <div class="admin-card-body">
                    <form class="admin-form" method="POST">
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Product Name *</label>
                                <input type="text" name="name" placeholder="e.g. Chocolate Cake 1 Pound" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Category *</label>
                                <select name="category" required>
                                    <option value="">-- Category Select Karein --</option>
                                    <option value="occasion_cakes" <?= ($_POST['category']??'')=='occasion_cakes'?'selected':'' ?>>Occasion Cakes</option>
                                    <option value="cupcakes" <?= ($_POST['category']??'')=='cupcakes'?'selected':'' ?>>Cupcakes</option>
                                    <option value="desserts" <?= ($_POST['category']??'')=='desserts'?'selected':'' ?>>Desserts</option>
                                    <option value="special" <?= ($_POST['category']??'')=='special'?'selected':'' ?>>Special Items</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label>Price (Rs.) *</label>
                                <input type="number" name="price" placeholder="e.g. 1400" step="0.01" min="0" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="unit" placeholder="e.g. 1 Pound, 6 Pieces, 1 Cup" value="<?= htmlspecialchars($_POST['unit'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" placeholder="Product ki description..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Image URL (optional)</label>
                            <input type="url" name="image_url" placeholder="https://example.com/image.jpg" value="<?= htmlspecialchars($_POST['image_url'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                                <input type="checkbox" name="is_available" value="1" <?= isset($_POST['is_available'])?'checked':'checked' ?> style="width:auto;">
                                Available hai (website par show karega)
                            </label>
                        </div>

                        <div style="display:flex;gap:15px;">
                            <button type="submit" class="btn btn-teal">✅ Product Save Karein</button>
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
