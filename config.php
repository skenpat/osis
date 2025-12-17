<?php
// config.php - Konfigurasi Database
define('DB_HOST', 'db.fr-pari1.bengt.wasmernet.com');
define('DB_USER', '218212fb78408000caa68efa941e');
define('DB_PASS', '06942182-12fb-7b70-8000-ec49bfef5d57');
define('DB_NAME', 'dbE2UwDvxp5kGjWbgS36cCDe');

// Koneksi Database
 $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASS, DB_NAME);
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
