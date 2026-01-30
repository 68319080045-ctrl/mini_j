<?php
include "connect.php";
session_start();

$_SESSION['role'] = 'admin';
$_SESSION['user_id'] = 1;

$title = "Test Book " . rand(100, 999);
$category = "novel";
$description = "Test Description";
$borrow_duration = 7;
$cover_image_path = NULL;
$file_path = NULL;
$created_by = 1;

$stmt = $con->prepare("INSERT INTO book (title, category, description, cover_image, status, borrow_duration, file_path, created_by) VALUES (?, ?, ?, ?, '0', ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $con->error);
}
$stmt->bind_param("ssssisi", $title, $category, $description, $cover_image_path, $borrow_duration, $file_path, $created_by);
$result = $stmt->execute();

if ($result) {
    echo "Success! ID: " . $stmt->insert_id;
} else {
    echo "Error: " . $stmt->error;
}
?>