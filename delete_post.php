<?php
include "db.php";
session_start();

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "DELETE FROM posts WHERE post_id='$post_id' AND member_id='{$_SESSION['member_id']}'";

    if ($conn->query($sql) === TRUE) {
        echo "Post deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>



