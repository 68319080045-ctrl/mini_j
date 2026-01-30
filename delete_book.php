<?php
session_start();
include "connect.php";


if (!isset($_SESSION['is_logged_in']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    
    
    
    

    $sql = "DELETE FROM book WHERE id = ?";
    try {
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            
            header("Location: index.php?msg=deleted");
        } else {
            
            header("Location: index.php?error=delete_failed");
        }
        $stmt->close();
    } catch (Exception $e) {
        header("Location: index.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: index.php");
}
$con->close();
?>