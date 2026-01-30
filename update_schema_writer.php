<?php
include "connect.php";

echo "<h2>Updating Database Schema for Writer Role...</h2>";

try {
    
    $sql = "ALTER TABLE customers MODIFY COLUMN role ENUM('admin', 'user', 'writer') NOT NULL DEFAULT 'user'";
    if ($con->query($sql) === TRUE) {
        echo "✅ Column 'role' updated to include 'writer'.<br>";
    } else {
        echo "❌ Error updating column 'role': " . $con->error . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>Done.</h3>";
?>