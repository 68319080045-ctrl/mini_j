<?php
session_start();
if (!isset($_SESSION['is_logged_in'])) {
    header("location: login.php");
    exit;
}
include "connect.php";

if (!isset($_GET['id'])) {
    header("location: index.php");
    exit;
}
$id = $_GET['id'];


$stmt = $con->prepare("UPDATE book SET status = '0', borrowed_at = NULL WHERE id = ?");
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($result) {
    header("location: index.php");
} else {
    echo "Error updating record: " . mysqli_error($con);
}
?>