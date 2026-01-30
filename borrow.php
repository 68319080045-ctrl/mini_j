<?php
session_start();
if (!isset($_SESSION['is_logged_in'])) {
    header("location: login.php");
    exit;
}
include "connect.php";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        header("location: confirm_borrow.php?id=" . $_GET['id']);
        exit;
    } else {
        header("location: index.php");
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        die("Error: Missing ID");
    }

    $id = $_POST['id'];
    $borrower_id = $_SESSION['user_id'];
    $lat = $_POST['lat'] ?? NULL;
    $lng = $_POST['lng'] ?? NULL;
    $address = $_POST['delivery_address'] ?? '';

    
    $sql = "UPDATE book SET 
            status = '1', 
            borrowed_at = NOW(), 
            borrower_id = ?,
            delivery_lat = ?,
            delivery_lng = ?,
            delivery_address = ?
            WHERE id = ?";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("iddsi", $borrower_id, $lat, $lng, $address, $id);
    $result = $stmt->execute();

    if ($result) {
        echo "<script>alert('ยืนยันการยืมสำเร็จ! เราจะจัดส่งหนังสือไปตามตำแหน่งที่ระบุ'); window.location='index.php';</script>";
    } else {
        echo "Error updating record: " . $con->error;
    }
}
?>