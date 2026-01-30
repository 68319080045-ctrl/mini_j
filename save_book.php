<?php
include "connect.php";
session_start();

if (!isset($_SESSION['is_logged_in'])) {
    header("location: login.php");
    exit;
}

$role = $_SESSION['role'] ?? 'user';
if ($role !== 'admin' && $role !== 'writer') {
    die("Unauthorized Access");
}

$created_by = $_SESSION['user_id'] ?? NULL;

$title = $_POST['title'] ?? '';
$category = $_POST['category'] ?? '';
$description = $_POST['description'] ?? ''; 
$borrow_duration = $_POST['borrow_duration'] ?? 7;

if (empty($title) || empty($category)) {
    die("Error: Title and Category are required.");
}


$cover_image_path = NULL;
if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid('cover_', true) . "." . $file_extension;
    $target_file = $target_dir . $new_filename;

    
    $check = getimagesize($_FILES['cover_image']['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file)) {
            $cover_image_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}


$sql = "INSERT INTO book (title, category, description, cover_image, status, borrow_duration, file_path, created_by) VALUES (?, ?, ?, ?, '0', ?, ?, ?)";
$stmt = $con->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $con->error);
}


$stmt->bind_param("ssssisi", $title, $category, $description, $cover_image_path, $borrow_duration, $file_path, $created_by);


$result = $stmt->execute();

if ($result) {
    header("location: index.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>