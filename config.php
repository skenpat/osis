<?php
// Database Configuration
define('DB_HOST', 'db.fr-pari1.bengt.wasmernet.com');
define('DB_PORT', 10272);
define('DB_NAME', 'dbE2UwDvxp5kGjWbgS36cCDe');
define('DB_USER', '218212fb78408000caa68efa941e');
define('DB_PASS', '06942182-12fb-7b70-8000-ec49bfef5d57');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database Connection Error: " . $e->getMessage());
}

// Site Configuration
define('SITE_URL', 'http://localhost/osis-project');
define('SITE_NAME', 'OSIS SMK Negeri 4 Banjarmasin');
define('ADMIN_EMAIL', 'admin@osis.sman1.sch.id');

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Functions
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function is_logged_in() {
    return isset($_SESSION['admin_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect('admin/login.php');
    }
}

function format_date($date) {
    return date('d F Y', strtotime($date));
}

function format_datetime($datetime) {
    return date('d F Y H:i', strtotime($datetime));
}
?>