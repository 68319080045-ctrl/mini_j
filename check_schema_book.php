<?php
include "connect.php";
$result = $con->query("SHOW CREATE TABLE book");
if ($row = $result->fetch_assoc()) {
    echo "<pre>" . htmlspecialchars($row['Create Table']) . "</pre>";
} else {
    echo "Error: " . $con->error;
}
?>