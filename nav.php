<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-brand {
      font-weight: bold;
      letter-spacing: 1px;
    }

    .nav-link {
      font-size: 16px;
      margin-right: 15px;
    }

    .navbar-nav {
      align-items: center;
    }

    .navbar {
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">The Perfect Cup</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarMain">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="blog.php">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="posts.php">Posts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="quiz.php">Quiz</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php">Comment</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="rate_site.php">Rate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="calender.php">Event</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_login.php">Admin Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>




