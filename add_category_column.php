<?php
include "connect.php";


$sql = "SHOW COLUMNS FROM book LIKE 'category'";
$result = $con->query($sql);

if ($result->num_rows == 0) {
    
    $sql_alter = "ALTER TABLE book ADD COLUMN category VARCHAR(50) NOT NULL DEFAULT 'novel' AFTER title";
    if ($con->query($sql_alter)) {
        echo "Successfully added 'category' column to 'book' table.\n";
    } else {
        echo "Error adding column: " . $con->error . "\n";
    }
} else {
    echo "'category' column already exists.\n";
}
?>