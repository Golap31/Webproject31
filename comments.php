<?php
include("db.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $comment = trim($_POST['comment']);

    if (!empty($name) && !empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO simple_comments (name, comment) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $comment);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comment Section</title>
    <link rel="stylesheet" href="css/style1.css"> <!-- Optional -->
</head>
<body>
    <div class="comment-container">
        <h2>Leave a Comment</h2>
        <a href="index.php" style="padding: 8px 16px; background: #6f4e37; color: white; text-decoration: none; border-radius: 5px;">← Back to Home</a>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Your Name" required><br><br>
            <textarea name="comment" rows="4" placeholder="Write your comment here..." required></textarea><br><br>
            <button type="submit">Submit Comment</button>
        </form>

        <hr>
        
        <h3>All Comments</h3>
        <?php
        $result = $conn->query("SELECT name, comment, created_at FROM simple_comments ORDER BY created_at DESC");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<strong>" . htmlspecialchars($row['name']) . "</strong> ";
                echo "<em>(" . $row['created_at'] . ")</em>";
                echo "<p>" . nl2br(htmlspecialchars($row['comment'])) . "</p>";
                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "<p>No comments yet. Be the first!</p>";
        }
        ?>
    </div>
</body>
</html>
