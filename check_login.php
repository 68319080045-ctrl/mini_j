<?php
session_start();
include_once 'connect.php';

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "<script>alert('Please enter username and password'); window.history.back();</script>";
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $con->prepare("SELECT * FROM customers WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $_SESSION['is_logged_in'] = true;
    $_SESSION['user_id'] = $row['cus_id']; 
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'setting.php';

    echo "<script>alert('Login Successful!'); window.location='$redirect';</script>";
} else {
    echo "<script>alert('Login Failed!'); window.history.back();</script>";
}
?>