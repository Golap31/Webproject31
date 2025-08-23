<?php include("db.php"); ?>
<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();
?>

<h2>Edit User</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?= $user['name'] ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>" required><br><br>
    Role: <input type="text" name="role" value="<?= $user['role'] ?>" required><br><br>
    <input type="submit" name="update" value="Update User">
</form>

<?php
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['name'], $_POST['email'], $_POST['role'], $id);
    $stmt->execute();
    echo "User updated. <a href='index.php'>Back to users</a>";
}
?>
