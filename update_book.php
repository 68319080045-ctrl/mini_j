<?php
include "connect.php";
session_start();




if (!isset($_SESSION['is_logged_in'])) {
    header("location: login.php");
    exit;
}

if (!isset($_POST['id'])) {
    die("Invalid Request: ID is missing.");
}

$id = $_POST['id'];
$current_user_id = $_SESSION['user_id'];
$current_user_role = $_SESSION['role'] ?? 'user';


$check_sql = "SELECT created_by FROM book WHERE id = ?";
$check_stmt = $con->prepare($check_sql);
if ($check_stmt) {
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    $check_stmt->close();
} else {
    die("Database Error (Check): " . $con->error);
}

if (!$check_row) {
    die("Book not found!");
}


if ($current_user_role !== 'admin') {
    die("Unauthorized: Only admins can update books.");
}

$title = $_POST['title'] ?? '';
$category = $_POST['category'] ?? '';
$borrow_duration = $_POST['borrow_duration'] ?? 7;
$file_path = $_POST['old_file_path'] ?? NULL;
$cover_image_path = $_POST['old_cover_image'] ?? NULL;
$description = $_POST['description'] ?? '';





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
        }
    }
}


$update_sql = "UPDATE book SET title=?, category=?, description=?, cover_image=?, borrow_duration=?, file_path=? WHERE id=?";
$stmt = $con->prepare($update_sql);

if (!$stmt) {
    die("Prepare failed: " . $con->error);
}

$stmt->bind_param("ssssisi", $title, $category, $description, $cover_image_path, $borrow_duration, $file_path, $id);
$result = $stmt->execute();

if ($result) {
    header("location: index.php");
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
?>