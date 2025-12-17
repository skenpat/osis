<?php
// config.php - Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dbE2UwDvxp5kGjWbgS36cCDe');

// Koneksi Database
 $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Session start
session_start();

// Fungsi helper
function clean_input($data) {
    global $conn;
    return htmlspecialchars($conn->real_escape_string($data));
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}
?>
