<?php
include "connect.php";


$sql1 = "SHOW COLUMNS FROM book LIKE 'borrow_duration'";
$result1 = $con->query($sql1);
if ($result1->num_rows == 0) {
    $con->query("ALTER TABLE book ADD COLUMN borrow_duration INT DEFAULT 7 COMMENT 'Borrow duration in days'");
    echo "Added borrow_duration column.<br>";
} else {
    echo "borrow_duration column already exists.<br>";
}


$sql2 = "SHOW COLUMNS FROM book LIKE 'borrowed_at'";
$result2 = $con->query($sql2);
if ($result2->num_rows == 0) {
    $con->query("ALTER TABLE book ADD COLUMN borrowed_at DATETIME NULL");
    echo "Added borrowed_at column.<br>";
} else {
    echo "borrowed_at column already exists.<br>";
}

echo "Database schema updated successfully.";
?>