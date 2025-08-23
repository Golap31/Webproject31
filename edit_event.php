<?php
include("db.php");

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['event_date'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("UPDATE events SET title = ?, event_date = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $date, $desc, $id);
    $stmt->execute();

    header("Location: calender.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>
    <h2>Edit Event</h2>
    <form method="post">
        Title: <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" required><br>
        Date: <input type="date" name="event_date" value="<?= $event['event_date'] ?>" required><br>
        Description:<br>
        <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea><br>
        <button type="submit">Update Event</button>
    </form>
</body>
</html>

