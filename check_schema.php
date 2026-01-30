<?php
include "connect.php";
$result = $con->query("SHOW COLUMNS FROM customers");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Error: " . $con->error;
}
?>