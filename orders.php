<?php
require_once 'auth.php';
require_once '../db.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: orders.php'); exit(); }

$order = $conn->query("SELECT * FROM orders WHERE id=$id")->fetch_assoc();
if (!$order) { header('Location: orders.php'); exit(); }

$items = $conn->query("SELECT * FROM order_items WHERE order_id=$id");

if (isset($_POST['update_status'])) {
    $new_status = sanitize($conn, $_POST['status'] ?? '');
    $valid = ['pending','confirmed','preparing','delivered','cancelled'];
    if (in_array($new_status, $valid)) {
        $conn->query("UPDATE orders SET status='$new_status' WHERE id=$id");
        header('Location: order_detail.php?id='.$id.'&updated=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>📦 Order Detail</h1>
            <a href="orders.php" class="btn btn-outline btn-sm">← Orders Wapis</a>
        </div>
        <div class="admin-content">
            <?php if (isset($_GET['updated'])): ?><div class="alert alert-success">✅ Status update ho gaya.</div><?php endif; ?>

            <div style="display:grid;grid-template-columns:2fr 1fr;gap:25px;">
                <!-- ORDER ITEMS -->
                <div>
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h3>Order #<?= htmlspecialchars($order['order_number']) ?></h3>
                            <span class="badge badge-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span>
                        </div>
                        <div style="overflow-x:auto;">
                            <table>
                                <thead>
                                    <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
                                </thead>
                                <tbody>
                                    <?php while ($item = $items->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['cake_name']) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>Rs. <?= number_format($item['price'], 0) ?></td>
                                        <td><strong>Rs. <?= number_format($item['price'] * $item['quantity'], 0) ?></strong></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align:right;font-weight:700;padding:15px;">TOTAL:</td>
                                        <td style="font-weight:700;font-size:18px;color:#45b8ac;">Rs. <?= number_format($order['total_amount'], 0) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <?php if ($order['notes']): ?>
                    <div class="admin-card" style="margin-top:20px;">
                        <div class="admin-card-header"><h3>📝 Customer Notes</h3></div>
                        <div class="admin-card-body">
                            <p style="color:#555;line-height:1.6;"><?= htmlspecialchars($order['notes']) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- CUSTOMER INFO + STATUS -->
                <div>
                    <div class="admin-card" style="margin-bottom:20px;">
                        <div class="admin-card-header"><h3>👤 Customer Info</h3></div>
                        <div class="admin-card-body">
                            <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                            <p style="margin-top:10px;"><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
                            <p style="margin-top:10px;"><strong>Phone:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
                            <p style="margin-top:10px;"><strong>Address:</strong><br><?= htmlspecialchars($order['customer_address']) ?></p>
                            <p style="margin-top:10px;"><strong>Order Date:</strong><br><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                    </div>

                    <div class="admin-card">
                        <div class="admin-card-header"><h3>🔄 Status Update</h3></div>
                        <div class="admin-card-body">
                            <p style="margin-bottom:15px;">Current: <span class="badge badge-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span></p>
                            <form method="POST">
                                <div class="form-group">
                                    <label>Naya Status:</label>
                                    <select name="status" class="admin-form" style="width:100%;padding:10px;border:2px solid #e0e0e0;border-radius:8px;font-family:inherit;font-size:14px;outline:none;">
                                        <option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>⏳ Pending</option>
                                        <option value="confirmed" <?= $order['status']=='confirmed'?'selected':'' ?>>✅ Confirmed</option>
                                        <option value="preparing" <?= $order['status']=='preparing'?'selected':'' ?>>👨‍🍳 Preparing</option>
                                        <option value="delivered" <?= $order['status']=='delivered'?'selected':'' ?>>🚚 Delivered</option>
                                        <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>❌ Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" name="update_status" class="btn btn-teal" style="width:100%;">✅ Status Update Karein</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
