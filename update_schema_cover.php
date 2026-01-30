<?php
include "connect.php";

try {
    $sql = "ALTER TABLE book ADD COLUMN cover_image VARCHAR(255) NULL AFTER category";
    if ($con->query($sql) === TRUE) {
        echo "Column 'cover_image' added successfully";
    } else {
        if ($con->errno == 1060) {
            echo "Column 'cover_image' already exists";
        } else {
            echo "Error adding column: " . $con->error;
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>