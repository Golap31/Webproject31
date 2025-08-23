<?php
session_start();
include "db.php";

// Fetch all users
$sql = "SELECT * FROM members";
$result = $conn->query($sql);

// Handle delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM members WHERE id=$id"); 
    header("Location: admin_users.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Users</title>
    <style>
        body { font-family: Arial; background: #f9f5f1; }
        h1 { background: #6f4e37; color: white; padding: 15px; text-align: center; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        .btn-delete { background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; }
        .btn-delete:hover { background: #b02a37; }
    </style>
</head>
<body>
    <a href="index.php" class="btn" style="background:#555;">⬅️ Back</a>
    <h1>☕ Admin Panel - Manage Users</h1>
    <table>
        <tr>
            <th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['fname']); ?></td>
            <td><?php echo htmlspecialchars($row['lname']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <a href="admin_users.php?delete=<?php echo $row['id']; ?>" 
                   class="btn-delete" onclick="return confirm('Delete this user?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
