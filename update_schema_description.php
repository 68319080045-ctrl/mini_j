<?php
include "connect.php";

try {
    $sql = "ALTER TABLE book ADD COLUMN description TEXT NULL AFTER category";
    if ($con->query($sql) === TRUE) {
        echo "Column 'description' added successfully";
    } else {
        
        if ($con->errno == 1060) {
            echo "Column 'description' already exists";
        } else {
            echo "Error adding column: " . $con->error;
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>