<?php
session_start();
include "db.php";

// Handle Approve
if (isset($_GET['approve'])) {
    $post_id = intval($_GET['approve']);
    $conn->query("UPDATE posts SET status='approved' WHERE post_id='$post_id'");
}

// Handle Reject
if (isset($_GET['reject'])) {
    $post_id = intval($_GET['reject']);
    $conn->query("UPDATE posts SET status='rejected' WHERE post_id='$post_id'");
}

// Fetch all posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Posts</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f3f3f3; }
        h1 { text-align:center; background:#333; color:white; padding:15px; }
        .container { width:80%; margin:20px auto; }
        .post { background:white; padding:15px; margin-bottom:15px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        .actions a { padding:6px 12px; margin:0 5px; border-radius:6px; text-decoration:none; }
        .approve { background:green; color:white; }
        .reject { background:red; color:white; }
        .pending { color:orange; }
        .approved { color:green; }
        .rejected { color:red; }

        /* Back button */
        .back-container { text-align:center; margin:20px; }
        .back-btn { background:#555; color:white; padding:10px 18px; border-radius:8px; text-decoration:none; font-size:16px; }
        .back-btn:hover { background:#333; }
    </style>
</head>
<body>
    <h1>Admin Panel - Manage Posts</h1>
    <div class="container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="post">
                <h3><?= htmlspecialchars($row['title']) ?> 
                    <span class="<?= $row['status'] ?>">(<?= ucfirst($row['status']) ?>)</span>
                </h3>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <?php if ($row['image']) { ?>
                    <img src="uploads/<?= $row['image'] ?>" style="max-width:200px;">
                <?php } ?>
                <div class="actions">
                    <?php if ($row['status'] == 'pending') { ?>
                        <a href="admin_posts.php?approve=<?= $row['post_id'] ?>" class="approve">Approve</a>
                        <a href="admin_posts.php?reject=<?= $row['post_id'] ?>" class="reject">Reject</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Back button -->
    <div class="back-container">
        <a href="admin_dashboard.php" class="back-btn">⬅️ Back to Dashboard</a>
    </div>
</body>
</html>


