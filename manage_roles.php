<?php
include "connect.php";
session_start();





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage User Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white container mt-5">
    <h1>Manage User Roles</h1>

    <div class="card p-4 text-dark mb-4">
        <h4>Update User Role</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Select Role:</label>
                <select name="role" class="form-select">
                    <option value="user">User (Reader - No Edit)</option>
                    <option value="admin">Admin (Full Access)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['username']) || !isset($_POST['role'])) {
            echo "<div class='alert alert-danger'>Error: Missing required fields.</div>";
        } else {
            $username = $_POST['username'];
            $role = $_POST['role'];
            
    
            $stmt = $con->prepare("UPDATE customers SET role = ? WHERE username = ?");
            $stmt->bind_param("ss", $role, $username);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo "<div class='alert alert-success'>Successfully updated '$username' to '$role'.</div>";
                } else {
                    echo "<div class='alert alert-info'>No changes made (User not found or role already set).</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error: " . $con->error . "</div>";
            }
        }
    }
    ?>

    <div class="row">
        <div class="col-md-4">
            <h3>Admins</h3>
            <ul class="list-group">
                <?php
                $result = $con->query("SELECT username FROM customers WHERE role = 'admin'");
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>" . htmlspecialchars($row['username']) . "</li>";
                }
                ?>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Writers</h3>
            <ul class="list-group">
                <?php
                $result = $con->query("SELECT username FROM customers WHERE role = 'writer'");
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>" . htmlspecialchars($row['username']) . "</li>";
                }
                ?>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Recent Users</h3>
            <ul class="list-group">
                <?php
                $result = $con->query("SELECT username FROM customers WHERE role = 'user' ORDER BY cus_id DESC LIMIT 5");
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>" . htmlspecialchars($row['username']) . "</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">Back to Home</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>