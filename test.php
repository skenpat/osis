<?php
echo "<h1>Database Connection Test</h1>";

// Basic PHP check
echo "<h2>PHP Configuration</h2>";
echo "PHP is working!<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Loaded Extensions: " . implode(', ', get_loaded_extensions()) . "<br>";

// Database connection test
echo "<h2>Database Connection Test</h2>";

// Database configuration
 $db_host = "db.fr-pari1.bengt.wasmernet.com";
 $db_port = 10272;
 $db_user = "218212fb78408000caa68efa941e";
 $db_pass = "06942182-12fb-7b70-8000-ec49bfef5d57";
 $db_name = "dbE2UwDvxp5kGjWbgS36cCDe";

// Test connection
echo "<p>Attempting to connect to database...</p>";

try {
    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<div style='color: green; font-weight: bold;'>✓ Database connection successful!</div>";
    
    // Test database selection
    echo "<p>Testing database selection...</p>";
    if ($conn->select_db($db_name)) {
        echo "<div style='color: green; font-weight: bold;'>✓ Database selected successfully!</div>";
    } else {
        throw new Exception("Database selection failed: " . $conn->error);
    }
    
    // Test query execution
    echo "<p>Testing query execution...</p>";
    $query = "SHOW TABLES";
    $result = $conn->query($query);
    
    if ($result) {
        echo "<div style='color: green; font-weight: bold;'>✓ Query executed successfully!</div>";
        
        // Display tables
        if ($result->num_rows > 0) {
            echo "<h3>Tables in Database:</h3>";
            echo "<ul>";
            while ($row = $result->fetch_row()) {
                echo "<li>" . $row[0] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No tables found in the database.</p>";
        }
    } else {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    // Test reading from a specific table
    echo "<p>Testing data retrieval from 'admins' table...</p>";
    $query = "SELECT * FROM admins LIMIT 1";
    $result = $conn->query($query);
    
    if ($result) {
        echo "<div style='color: green; font-weight: bold;'>✓ Data retrieval successful!</div>";
        
        if ($result->num_rows > 0) {
            echo "<h3>Sample Admin Record:</h3>";
            echo "<pre>";
            print_r($result->fetch_assoc());
            echo "</pre>";
        } else {
            echo "<p>No records found in 'admins' table.</p>";
        }
    } else {
        throw new Exception("Data retrieval failed: " . $conn->error);
    }
    
    // Close connection
    $conn->close();
    echo "<div style='color: green; font-weight: bold;'>✓ Connection closed successfully!</div>";
    
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold;'>✗ Error: " . $e->getMessage() . "</div>";
    
    // Additional debugging information
    echo "<h3>Debugging Information:</h3>";
    echo "<p><strong>Host:</strong> " . $db_host . ":" . $db_port . "</p>";
    echo "<p><strong>Username:</strong> " . $db_user . "</p>";
    echo "<p><strong>Database:</strong> " . $db_name . "</p>";
    echo "<p><strong>PHP MySQLi Support:</strong> " . (function_exists('mysqli_connect') ? 'Enabled' : 'Disabled') . "</p>";
    echo "<p><strong>PHP PDO MySQL Support:</strong> " . (extension_loaded('pdo_mysql') ? 'Enabled' : 'Disabled') . "</p>";
}

// Additional system information
echo "<h2>System Information</h2>";
echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Server Protocol:</strong> " . $_SERVER['SERVER_PROTOCOL'] . "</p>";
echo "<p><strong>Request Method:</strong> " . $_SERVER['REQUEST_METHOD'] . "</p>";
echo "<p><strong>Remote Address:</strong> " . $_SERVER['REMOTE_ADDR'] . "</p>";
echo "<p><strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
?>