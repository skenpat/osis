<?php
require_once 'config.php';

// configuration
$username = 'admin';
$password = 'raisya'; // The password you want to use

// Create secure hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update database
$query = "UPDATE admins SET password = ? WHERE username = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("ss", $hashed_password, $username);
    
    if ($stmt->execute()) {
        echo "<h1>Password Fix Successful</h1>";
        echo "<p>User '<strong>$username</strong>' password has been securely hashed and updated.</p>";
        echo "<p>You can now <a href='admin/login.php'>Login here</a> with password: <strong>$password</strong></p>";
    } else {
        echo "<h1>Error</h1>";
        echo "<p>Failed to update password: " . $stmt->error . "</p>";
    }
    $stmt->close();
} else {
    echo "<h1>Database Error</h1>";
    echo "<p>Prepare failed: " . $conn->error . "</p>";
}

$conn->close();
?>
