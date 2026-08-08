<?php
require_once 'auth.php';
require_once '../db.php';

$status_filter = isset($_GET['status']) ? sanitize($conn, $_GET['status']) : '';
$search = isset($_GET['search']) ? sanitize($conn, $_GET['search']) : '';

$where = "WHERE 1=1";
if ($status_filter) $where .= " AND status = '$status_filter'";
if ($search) $where .= " AND (order_number LIKE '%$search%' OR customer_name LIKE '%$search%' OR customer_phone LIKE '%$search%')";

$orders = $conn->query("SELECT * FROM orders $where ORDER BY created_at DESC");

$msg = '';
if (isset($_GET['updated'])) $msg = '✅ Order status update ho gaya.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1>📦 Orders Management</h1>
        </div>
        <div class="admin-content">
            <?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>

            <!-- FILTER TABS -->
            <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
                <?php
                $statuses = [''=>'Sab Orders', 'pending'=>'⏳ Pending', 'confirmed'=>'✅ Confirmed', 'preparing'=>'👨‍🍳 Preparing', 'delivered'=>'🚚 Delivered', 'cancelled'=>'❌ Cancelled'];
                foreach ($statuses as $val => $label):
                    $count = $conn->query("SELECT COUNT(*) as c FROM orders" . ($val ? " WHERE status='$val'" : ""))->fetch_assoc()['c'];
                ?>
                <a href="orders.php?status=<?= $val ?>" style="padding:8px 18px;border-radius:20px;text-decoration:none;font-size:13px;font-weight:700;
                    background:<?= $status_filter==$val ? '#45b8ac' : '#fff' ?>;
                    color:<?= $status_filter==$val ? '#fff' : '#333' ?>;
                    border:2px solid <?= $status_filter==$val ? '#45b8ac' : '#e0e0e0' ?>;">
                    <?= $label ?> (<?= $count ?>)
                </a>
                <?php endforeach; ?>
            </div>

            <!-- SEARCH -->
            <div class="admin-card" style="margin-bottom:20px;">
                <div class="admin-card-body" style="padding:15px 25px;">
                    <form method="GET" style="display:flex;gap:15px;align-items:center;">
                        <input type="hidden" name="status" value="<?= htmlspecialchars($status_filter) ?>">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                            placeholder="Order number ya customer search karein..."
                            style="flex:1;padding:9px 15px;border:2px solid #e0e0e0;border-radius:8px;font-family:inherit;font-size:14px;outline:none;">
                        <button type="submit" class="btn btn-teal">🔍 Search</button>
                        <a href="orders.php" class="btn btn-outline">Reset</a>
                    </form>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Orders (<?= $orders->num_rows ?>)</h3>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($order['order_number']) ?></strong></td>
                                <td>
                                    <?= htmlspecialchars($order['customer_name']) ?><br>
                                    <small style="color:#999;"><?= htmlspecialchars($order['customer_email']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($order['customer_phone']) ?></td>
                                <td><strong>Rs. <?= number_format($order['total_amount'], 0) ?></strong></td>
                                <td>
                                    <form method="POST" action="update_order_status.php" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <input type="hidden" name="redirect" value="orders.php?status=<?= $status_filter ?>">
                                        <select name="status" class="order-status-select" onchange="this.form.submit()">
                                            <?php foreach (['pending','confirmed','preparing','delivered','cancelled'] as $s): ?>
                                            <option value="<?= $s ?>" <?= $order['status']==$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <a href="order_detail.php?id=<?= $order['id'] ?>" class="btn btn-outline btn-sm">👁️ Details</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if ($orders->num_rows === 0): ?>
                            <tr><td colspan="7" style="text-align:center;padding:30px;color:#999;">Koi order nahi mila.</td></tr>
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
