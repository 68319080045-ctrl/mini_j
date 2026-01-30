<?php
include "connect.php";

$sql = "CREATE TABLE IF NOT EXISTS book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    status ENUM('0', '1') DEFAULT '0' COMMENT '0=Not Borrowed, 1=Borrowed'
)";

if (mysqli_query($con, $sql)) {
    echo "Table 'book' created successfully or already exists.";
} else {
    echo "Error creating table: " . mysqli_error($con);
}
?>