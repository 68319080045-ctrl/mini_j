<?php
include "connect.php";


$sql_check = "SHOW COLUMNS FROM book LIKE 'delivery_lat'";
$result = $con->query($sql_check);

if ($result->num_rows == 0) {
    
    $sql = "ALTER TABLE book 
            ADD COLUMN borrower_id INT NULL AFTER created_by,
            ADD COLUMN delivery_address TEXT NULL AFTER borrower_id,
            ADD COLUMN delivery_lat DOUBLE NULL AFTER delivery_address,
            ADD COLUMN delivery_lng DOUBLE NULL AFTER delivery_lat";

    if ($con->query($sql)) {
        echo "Successfully added map/delivery columns to 'book' table.<br>";
    } else {
        echo "Error adding columns: " . $con->error . "<br>";
    }
} else {
    echo "Map columns already exist.<br>";
}
echo "<a href='index.php'>Back to Home</a>";
?>