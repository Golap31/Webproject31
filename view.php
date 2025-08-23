<?php
include "db.php";
session_start();

// If you want to show all posts (for everyone):
$sql = "SELECT p.*, m.first_name, m.last_name 
        FROM posts p 
        JOIN members m ON p.member_id = m.id 
        ORDER BY p.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Blog Posts</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f5f1; margin: 0; padding: 0; }
        header { background: #6f4e37; color: white; text-align: center; padding: 15px; }
        .container { width: 80%; margin: 20px auto; }
        .post { background: #fff; padding: 15px; margin-bottom: 20px; border-radius: 10px;
                box-shadow: 0 3px 6px rgba(0,0,0,0.1);}
        .post h2 { color: #6f4e37; margin: 0 0 10px; }
        .post p { line-height: 1.5; }
        .post img { max-width: 400px; border-radius: 8px; margin-top: 10px; }
        .author { color: #777; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>

<header>
    <h1>☕ Coffee Blog - All Posts</h1>
</header>

<div class="container">
<?php 
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { ?>
        <div class="post">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
            <?php if ($row['image']) { ?>
                <img src="uploads/<?php echo $row['image']; ?>" alt="Post Image">
            <?php } ?>
            <div class="author">
                Posted by <?php echo htmlspecialchars($row['first_name']." ".$row['last_name']); ?> 
                on <?php echo $row['created_at']; ?>
            </div>
        </div>
<?php } 
} else {
    echo "<p>No posts yet!</p>";
} ?>
</div>

</body>
</html>
