<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $role);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <link rel="stylesheet" href="css/style.css"> <!-- ✅ Styling applied -->
</head>
<body>

<div class="container">
    <h2>Add New User</h2>
    <form method="POST" class="form">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Role:</label><br>
        <input type="text" name="role" required><br><br>

        <button type="submit" class="btn">Add User</button>
        <a href="index.php" class="btn cancel">Cancel</a>
    </form>
</div>

</body>
</html>
