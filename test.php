<?php
echo "PHP is working!<br>";
echo "PHP Version: " . phpversion() . "<br>";

// Test database connection
try {
    $conn = new mysqli("localhost", "username", "password", "database");
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
}
?>