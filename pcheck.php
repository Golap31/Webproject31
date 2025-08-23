<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Open connection
$mysqli = new mysqli('localhost', 'root', '', 'perfectcup');

if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Fetch user by email
$query = "SELECT * FROM members WHERE email='$email'";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if ($num_row >= 1) {
    if (password_verify($password, $row['password'])) {

        // Store session variables
        $_SESSION['login'] = $row['id'];           // existing
        $_SESSION['user_id'] = $row['id'];    // <-- ADD THIS LINE
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];

        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}
?>
