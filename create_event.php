<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['event_date'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO events (title, event_date, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $date, $desc);

    if ($stmt->execute()) {
        // ✅ SUCCESS — redirect to calendar page
        header("Location: calender.php");
        exit;
    } else {
        // ❌ FAIL — show error
        $error = "Failed to save event.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <link rel="stylesheet" href="css/style3.css">
</head>
<body>
    <div class="container">
        <h2>Add a New Event</h2>

        <?php if (!empty($error)): ?>
            <div style="color: red;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="title">Title:</label><br>
            <input type="text" name="title" id="title" required><br><br>

            <label for="event_date">Date:</label><br>
            <input type="date" name="event_date" id="event_date" required><br><br>

            <label for="description">Description:</label><br>
            <textarea name="description" id="description" required></textarea><br><br>

            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>




