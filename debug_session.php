<?php
session_start();
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo '<a href="logout.php">Logout</a>';
?>