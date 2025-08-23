<?php
include("db.php");

$result = $conn->query("SELECT * FROM events ORDER BY event_date");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Calendar</title>
    <link rel="stylesheet" href="css/style3.css">
</head>
<body>
    <h2>Event Calendar</h2>
    <a href="index.php" style="padding: 8px 16px; background: #6f4e37; color: white; text-decoration: none; border-radius: 5px;">← Back to Home</a>

    <a href="create_event.php" class="button">Add New Event</a>

    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
            <li>
                <strong><?= htmlspecialchars($row['event_date']) ?>:</strong>
                <?= htmlspecialchars($row['title']) ?><br>
                <em><?= nl2br(htmlspecialchars($row['description'])) ?></em><br>
                <a href="edit_event.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_event.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
