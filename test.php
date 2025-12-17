<?php
echo "PHP is working!<br>";
echo "PHP Version: " . phpversion() . "<br>";

// Test database connection
try {
    $conn = new mysqli("db.fr-pari1.bengt.wasmernet.com", "218212fb78408000caa68efa941e", "06942182-12fb-7b70-8000-ec49bfef5d57", "dbE2UwDvxp5kGjWbgS36cCDe");
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
}
?>