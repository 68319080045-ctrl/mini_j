<?php
include "connect.php";

$username = 'admin';
$password = '1234';
$role = 'admin';


$stmt = $con->prepare("SELECT cus_id FROM customers WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    $stmt = $con->prepare("UPDATE customers SET password = ?, role = ? WHERE username = ?");
    $stmt->bind_param("sss", $password, $role, $username);
    if ($stmt->execute()) {
        echo "<h1>Success!</h1>";
        echo "<p>Updated existing user 'admin'.</p>";
    } else {
        echo "Error: " . $con->error;
    }
} else {
    
    $stmt = $con->prepare("INSERT INTO customers (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    if ($stmt->execute()) {
        echo "<h1>Success!</h1>";
        echo "<p>Created new user 'admin'.</p>";
    } else {
        echo "Error: " . $con->error;
    }
}

echo "<hr>";
echo "<h3>Login Credentials:</h3>";
echo "<ul>";
echo "<li>Username: <strong>admin</strong></li>";
echo "<li>Password: <strong>1234</strong></li>";
echo "</ul>";
echo "<a href='login.php'>Go to Login Page</a>";
?>