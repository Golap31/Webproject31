<?php
session_start();
include("db.php");

// Simulated login (remove when real login works)
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "You must be logged in to take the quiz.";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $favorite = $_POST['favorite_coffee'] ?? '';
    $time = $_POST['drink_time'] ?? '';
    $cups = $_POST['cups_per_day'] ?? 0;
    $roast = $_POST['roast_level'] ?? '';

    // Check if user already has a quiz record
    $check = $conn->prepare("SELECT id FROM coffee_quiz WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE coffee_quiz SET favorite_coffee=?, drink_time=?, cups_per_day=?, roast_level=? WHERE user_id=?");
        $stmt->bind_param("ssisi", $favorite, $time, $cups, $roast, $user_id);
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO coffee_quiz (user_id, favorite_coffee, drink_time, cups_per_day, roast_level) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issis", $user_id, $favorite, $time, $cups, $roast);
    }

    if ($stmt->execute()) {
        $message = "Thank you! Your quiz has been submitted.";
    } else {
        $message = "Error submitting quiz: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coffee Quiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Coffee Quiz</h2>
    <a href="index.php" style="padding: 8px 16px; background: #6f4e37; color: white; text-decoration: none; border-radius: 5px;">← Back to Home</a>

    <?php if ($message): ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php endif; ?>

    <form method="post" action="quiz.php">
        <label>1. Favorite Coffee Type:</label>
        <select name="favorite_coffee" required>
            <option value="">--Select--</option>
            <option value="Espresso">Espresso</option>
            <option value="Latte">Latte</option>
            <option value="Cappuccino">Cappuccino</option>
            <option value="Cold Brew">Cold Brew</option>
        </select>

        <label>2. When do you usually drink coffee?</label>
        <select name="drink_time" required>
            <option value="Morning">Morning</option>
            <option value="Afternoon">Afternoon</option>
            <option value="Evening">Evening</option>
            <option value="All day">All day</option>
        </select>

        <label>3. How many cups per day?</label>
        <input type="number" name="cups_per_day" min="0" required>

        <label>4. Preferred Roast Level:</label>
        <select name="roast_level" required>
            <option value="Light">Light</option>
            <option value="Medium">Medium</option>
            <option value="Dark">Dark</option>
        </select>

        <button type="submit">Submit Quiz</button>
    </form>
</div>
</body>
</html>
