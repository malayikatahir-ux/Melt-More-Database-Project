<?php
require_once 'auth.php';
require_once '../db.php';

$id = intval($_GET['id'] ?? 0);
if ($id) {
    $conn->query("DELETE FROM cakes WHERE id=$id");
}
header('Location: cakes.php?deleted=1');
exit();
?>
