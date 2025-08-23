<?php
include "db.php";
session_start();
$error = '';

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admins WHERE username='$username'");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; }
        .box { width:300px; margin:100px auto; padding:20px; background:white; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2); }
        input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:6px; }
        button { width:100%; padding:10px; background:#6f4e37; color:white; border:none; border-radius:6px; cursor:pointer; }
        button:hover { background:#5a3e2c; }
        .error { color:red; }
    </style>
</head>
<body>
<div class="box">
    <h2>Admin Login</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Not registered? <a href="admin_register.php">Register here</a></p>
</div>
</body>
</html>
