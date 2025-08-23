<?php
include "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle new post submission
if (isset($_POST['create'])) {
    $title   = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $image);
    }

    $sql = "INSERT INTO posts (title, content, image, status) 
            VALUES ('$title', '$content', '$image', 'pending')";
    $conn->query($sql);
    echo "<script>alert('✅ Your post has been submitted! Waiting for admin approval.');</script>";
}

// Handle delete
if (isset($_GET['delete'])) {
    $post_id = (int)$_GET['delete'];
    $conn->query("DELETE FROM posts WHERE post_id='$post_id'");
    echo "<script>alert('Post deleted successfully'); window.location='posts.php';</script>";
}

// Handle update
if (isset($_POST['update'])) {
    $post_id = (int)$_POST['post_id'];
    $title   = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $image = $_POST['existing_image']; // keep old image by default
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $image);
    }

    $conn->query("UPDATE posts SET title='$title', content='$content', image='$image' WHERE post_id='$post_id'");
    echo "<script>alert('Post updated successfully'); window.location='posts.php';</script>";
}

// Fetch all posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <style>
        body { font-family: "Segoe UI"; background:#f9f5f1; margin:0; padding:0; }
        header { background:#6f4e37; color:white; padding:15px; text-align:center; }
        .container { width:80%; margin:20px auto; }
        form, .post { background:white; padding:15px; border-radius:10px; margin-bottom:20px;
                      box-shadow:0 3px 6px rgba(0,0,0,0.1); }
        input, textarea, button { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:6px; }
        button { background:#6f4e37; color:white; border:none; cursor:pointer; }
        button:hover { background:#5a3e2c; }
        .status { font-size:13px; color:#777; font-style:italic; }
        .approved { color:green; }
        .pending { color:orange; }
        .rejected { color:red; }
        img { max-width:300px; margin-top:10px; }
        .actions button { width:auto; margin-right:5px; }
    </style>
</head>
<body>
<header>
    <h1>☕ Coffee Blog</h1>
    <p>Share your coffee moments</p>
</header>
<div class="container">
    <h2>Create a New Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Post Title" required>
        <textarea name="content" placeholder="Write your post..." required></textarea>
        <input type="file" name="image">
        <button type="submit" name="create">Create Post</button>
    </form>

    <h2>All Posts</h2>
    <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="post">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <?php if (!empty($row['image'])) { ?>
                    <img src="uploads/<?= htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') ?>">
                <?php } ?>
                <p class="status <?= htmlspecialchars($row['status']) ?>">Status: <?= ucfirst(htmlspecialchars($row['status'])) ?></p>

                <?php if ($row['status'] == 'approved') { ?>
                <!-- Edit/Delete actions -->
                <div class="actions">
                    <!-- Delete -->
                    <a href="posts.php?delete=<?= $row['post_id'] ?>" onclick="return confirm('Are you sure?');">
                        <button type="button">Delete</button>
                    </a>
                    <!-- Update -->
                    <button type="button" onclick="document.getElementById('edit-<?= $row['post_id'] ?>').style.display='block';">Update</button>
                </div>

                <!-- Update form -->
                <div id="edit-<?= $row['post_id'] ?>" style="display:none; margin-top:10px;">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="post_id" value="<?= $row['post_id'] ?>">
                        <input type="hidden" name="existing_image" value="<?= $row['image'] ?>">
                        <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
                        <textarea name="content" required><?= htmlspecialchars($row['content']) ?></textarea>
                        <input type="file" name="image">
                        <button type="submit" name="update">Update Post</button>
                    </form>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No posts yet. Be the first to create one!</p>
    <?php } ?>
        <!-- Back button -->
    <div class="back-container">
        <a href="index.php" class="back-btn">⬅️ Back to Home page</a>
    </div>
</div>
</body>
</html>








