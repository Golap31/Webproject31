<?php
include("db.php"); // make sure this file connects to your DB

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
    $rating = intval($_POST['rating']);

    if ($rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO site_ratings (rating) VALUES (?)");
        $stmt->bind_param("i", $rating);
        if ($stmt->execute()) {
            $message = "Thanks for rating our website!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Invalid rating. Please select a value between 1 and 5.";
    }
}

// Fetch average rating
$result = $conn->query("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM site_ratings");
$data = $result->fetch_assoc();
$average = round($data['avg_rating'], 2);
$total = $data['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rate Our Website</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .rating-form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: #f2f2f2;
            border-radius: 10px;
            text-align: center;
        }
        .rating-form h2 {
            margin-bottom: 10px;
        }
        .stars input {
            display: none;
        }
        .stars label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
        }
        .stars input:checked ~ label,
        .stars label:hover,
        .stars label:hover ~ label {
            color: gold;
        }
        .message {
            margin: 10px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
<div class="rating-form">
    <h2>Rate This Website</h2>
    <a href="index.php" style="padding: 8px 16px; background: #6f4e37; color: white; text-decoration: none; border-radius: 5px;">← Back to Home</a>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="stars">
            <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
            <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
            <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
            <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
            <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
        </div>
        <br>
        <button type="submit">Submit Rating

