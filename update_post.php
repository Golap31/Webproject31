<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id   = $_POST['post_id'];
    $title     = $_POST['title'];
    $content   = $_POST['content'];

    // Handle Image (optional)
    $image_sql = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        $image_sql = ", image='$image'";
    }

    $sql = "UPDATE posts SET title='$title', content='$content' $image_sql WHERE post_id='$post_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Post updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
