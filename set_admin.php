<?php
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Set Admin Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white container mt-5">
    <h1>Set User as Admin</h1>
    <form method="POST">
        <div class="mb-3">
            <label>Username to promote:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Make Admin</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $stmt = $con->prepare("UPDATE customers SET role = 'admin' WHERE username = ?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<div class='alert alert-success mt-3'>User '$username' is now an ADMIN.</div>";
            } else {
                echo "<div class='alert alert-warning mt-3'>User '$username' not found or already admin.</div>";
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . $con->error . "</div>";
        }
    }

    
    echo "<h3 class='mt-4'>Current Admins:</h3><ul>";
    $result = $con->query("SELECT username FROM customers WHERE role = 'admin'");
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['username']) . "</li>";
    }
    echo "</ul>";
    ?>

    <a href="login.php" class="btn btn-secondary mt-3">Go to Login</a>
</body>

</html>