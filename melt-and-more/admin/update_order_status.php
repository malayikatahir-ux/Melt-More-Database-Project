<?php
require_once 'auth.php';
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $status = sanitize($conn, $_POST['status'] ?? '');
    $valid_statuses = ['pending','confirmed','preparing','delivered','cancelled'];
    $redirect = $_POST['redirect'] ?? 'orders.php';

    if ($order_id && in_array($status, $valid_statuses)) {
        $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();
    }
    header('Location: ' . $redirect . '&updated=1');
    exit();
}
header('Location: orders.php');
exit();
?>
