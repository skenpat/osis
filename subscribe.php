<?php
require_once 'config.php';
require_once 'functions.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email from form
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    
    // Validate CSRF token (if implemented)
    // if (!verify_csrf_token($_POST['csrf_token'])) {
    //     die('Invalid CSRF token');
    // }
    
    // Subscribe to newsletter
    $result = subscribe_newsletter($conn, $email);
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

// If not a POST request, redirect to home page
redirect('index.php');
?>