<?php
include "db.php";
session_start();
$error = '';
$success = '';

if (isset($_POST['register'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Check if username exists
        $check = $conn->query("SELECT * FROM admins WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO admins (username, password) VALUES ('$username', '$hashed')");
            $success = "Admin registered successfully! <a href='admin_login.php'>Login here</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; }
        .box { width:300px; margin:100px auto; padding:20px; background:white; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2); }
        input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:6px; }
        button { width:100%; padding:10px; background:#6f4e37; color:white; border:none; border-radius:6px; cursor:pointer; }
        button:hover { background:#5a3e2c; }
        .error { color:red; }
        .success { color:green; }
    </style>
</head>
<body>
<div class="box">
    <h2>Admin Register</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already registered? <a href="admin_login.php">Login here</a></p>
</div>
</body>
</html>
