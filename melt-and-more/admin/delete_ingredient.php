<?php
require_once 'auth.php';
require_once '../db.php';
$id = intval($_GET['id'] ?? 0);
if ($id) $conn->query("DELETE FROM ingredients WHERE id=$id");
header('Location: ingredients.php?deleted=1');
exit();
?>
