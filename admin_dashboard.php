<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>



<?php
include "db.php";

// Get stats
$total_posts   = $conn->query("SELECT COUNT(*) as c FROM posts")->fetch_assoc()['c'];
$approved_posts = $conn->query("SELECT COUNT(*) as c FROM posts WHERE status='approved'")->fetch_assoc()['c'];
$pending_posts  = $conn->query("SELECT COUNT(*) as c FROM posts WHERE status='pending'")->fetch_assoc()['c'];
$rejected_posts = $conn->query("SELECT COUNT(*) as c FROM posts WHERE status='rejected'")->fetch_assoc()['c'];

// Check if you have a members table
$total_users = 0;
if ($conn->query("SHOW TABLES LIKE 'members'")->num_rows > 0) {
    $total_users = $conn->query("SELECT COUNT(*) as c FROM members")->fetch_assoc()['c'];
}
$total_ratings = 0;
if ($conn->query("SHOW TABLES LIKE 'site_ratings'")->num_rows > 0) {
    $total_users = $conn->query("SELECT COUNT(*) as c FROM site_ratings")->fetch_assoc()['c'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background:#f9f9f9; margin:0; }
        header { background:#333; color:white; padding:20px; text-align:center; }
        .container { width:90%; margin:20px auto; }
        .stats { display:flex; justify-content:space-around; margin-bottom:30px; }
        .card { background:white; padding:20px; border-radius:12px; box-shadow:0 3px 6px rgba(0,0,0,0.1); flex:1; margin:0 10px; text-align:center; }
        .card h2 { margin:10px 0; }
        .actions { text-align:center; margin-top:30px; }
        .btn { display:inline-block; padding:12px 20px; margin:10px; border:none; border-radius:8px; background:#6f4e37; color:white; text-decoration:none; font-size:16px; cursor:pointer; transition:0.3s; }
        .btn:hover { background:#5a3e2c; }
        canvas { background:white; border-radius:12px; padding:20px; box-shadow:0 3px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <header>
        <h1>☕ Admin Dashboard</h1>
        <p>Manage the coffee blog</p>
    </header>
    <div class="container">
        <!-- Quick Stats -->
        <div class="stats">
            <div class="card">
                <h3>Total Posts</h3>
                <h2><?= $total_posts ?></h2>
            </div>
            <div class="card">
                <h3>Total Users</h3>
                <h2><?= $total_users ?></h2>
            </div>
            <div class="card">
                <h3>Total Ratings</h3>
                <h2><?= $total_users ?></h2> 
            </div>
        </div>

        <!-- Chart -->
        <h2>Posts Overview</h2>
        <div class="chart-container">
            <canvas id="postsChart"></canvas>
        </div>

        <style>
            .chart-container {
                width: 400px;
                height: 400px;
                margin: 0 auto;
            }
        </style>


        <!-- Buttons -->
        <div class="actions">
            <a href="admin_posts.php" class="btn">📄 Manage Posts</a>
            <a href="admin_users.php" class="btn">👤 Manage Users</a>
            <a href="index.php" class="btn" style="background:#555;">⬅️ Back</a>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('postsChart');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Approved', 'Pending', 'Rejected'],
                datasets: [{
                    label: 'Posts',
                    data: [<?= $approved_posts ?>, <?= $pending_posts ?>, <?= $rejected_posts ?>],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
</body>
</html>
