<?php
include "connect.php";

echo "<h2>Updating Database Schema...</h2>";


try {
    $sql = "ALTER TABLE customers ADD COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user' AFTER password";
    if ($con->query($sql) === TRUE) {
        echo "✅ Column 'role' added to 'customers' successfully.<br>";
    } else {
        if ($con->errno == 1060) {
            echo "ℹ️ Column 'role' in 'customers' already exists.<br>";
        } else {
            echo "❌ Error adding column 'role': " . $con->error . "<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}


try {
    $sql = "ALTER TABLE book ADD COLUMN created_by INT NULL AFTER file_path";
    if ($con->query($sql) === TRUE) {
        echo "✅ Column 'created_by' added to 'book' successfully.<br>";
    } else {
        if ($con->errno == 1060) {
            echo "ℹ️ Column 'created_by' in 'book' already exists.<br>";
        } else {
            echo "❌ Error adding column 'created_by': " . $con->error . "<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>Done.</h3>";
echo "<p>Next steps: Please manually update your admin account to have <code>role = 'admin'</code> in the database.</p>";
echo "<p>Example SQL: <code>UPDATE customers SET role = 'admin' WHERE username = 'admin';</code></p>";
?>