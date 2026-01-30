<?php
include "connect.php";

if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['confirm_password'])) {
    die("Error: Missing required fields.");
}

$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];


if ($password !== $confirm_password) {
    echo "<script>alert('รหัสผ่านไม่ตรงกัน กรุณาลองใหม่'); window.history.back();</script>";
    exit();
}


$check_sql = "SELECT username FROM customers WHERE username = ?";
$stmt = $con->prepare($check_sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('ชื่อผู้ใช้นี้ถูกใช้งานแล้ว'); window.history.back();</script>";
    exit();
}


$sql = "INSERT INTO customers (username, password) VALUES (?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "<script>alert('ลงทะเบียนสำเร็จ! กรุณาเข้าสู่ระบบ'); window.location='login.php';</script>";
} else {
    echo "<script>alert('เกิดข้อผิดพลาดในการลงทะเบียน: " . $con->error . "'); window.history.back();</script>";
}
?>