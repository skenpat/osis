<?php
// Database Configuration
define('DB_HOST', getenv('DB_HOST'));
define('DB_PORT', 10272);
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));

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
define('SITE_URL', 'https://osis-skenpat.wasmer.app');
define('SITE_NAME', 'OSIS SMK Negeri 4 Banjarmasin');
define('ADMIN_EMAIL', 'skenpat-people@gmail.com');

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
        redirect('/admin/login.php');
    }
}

function format_date($date) {
    return date('d F Y', strtotime($date));
}

function format_datetime($datetime) {
    return date('d F Y H:i', strtotime($datetime));
}
?>
