

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/style.css"> <!-- ✅ CSS linked here -->
</head>
<body>

<div class="container">
    <h2>Users</h2>
    <a href="add.php" class="add-btn">Add New User</a>

    <table class="styled-table" border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM users");
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['role']}</td>
                <td>
                    <a href='edit.php?id={$row['id']}' class='btn edit'>Edit</a>
                    <a href='delete.php?id={$row['id']}' class='btn delete' onclick=\"return confirm('Delete this user?');\">Delete</a>

                </td>
            </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
