<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'melt_and_more');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="background:#f8d7da;color:#721c24;padding:20px;margin:20px;border-radius:8px;font-family:Arial;">
        <strong>Database Connection Error!</strong><br>
        Please make sure XAMPP (MySQL) is running and you have imported <code>database.sql</code>.<br>
        Error: ' . $conn->connect_error . '
    </div>');
}

$conn->set_charset("utf8mb4");

function sanitize($conn, $data) {
    return $conn->real_escape_string(htmlspecialchars(strip_tags(trim($data))));
}

function generateOrderNumber() {
    return 'MM-' . date('Y') . '-' . str_pad(rand(100, 9999), 4, '0', STR_PAD_LEFT);
}
?>
