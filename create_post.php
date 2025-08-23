<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_SESSION['member_id']; // logged in user
    $title     = $_POST['title'];
    $content   = $_POST['content'];

    // Handle Image Upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    }

    $sql = "INSERT INTO posts (member_id, title, content, image) 
            VALUES ('$member_id', '$title', '$content', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Post created successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

