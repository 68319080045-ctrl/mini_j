<?php
include "connect.php";


$sql = "SHOW COLUMNS FROM book LIKE 'file_path'";
$result = $con->query($sql);

if ($result->num_rows == 0) {
    
    $sql_alter = "ALTER TABLE book ADD COLUMN file_path VARCHAR(255) DEFAULT NULL COMMENT 'Path to uploaded file'";
    if ($con->query($sql_alter)) {
        echo "Successfully added 'file_path' column to 'book' table.<br>";
    } else {
        echo "Error adding column: " . $con->error . "<br>";
    }
} else {
    echo "'file_path' column already exists.<br>";
}


$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
    echo "Created 'uploads' directory.";
}
?>