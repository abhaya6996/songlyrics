<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #101020, #1e003a);
    color: #fff;
    min-height: 100vh;
  }

  .navbar {
    background: rgba(0, 0, 0, 0.4) !important;
    backdrop-filter: blur(10px);
  }

  .navbar-brand {
    font-weight: 700;
    font-size: 1.4rem;
    color: #ff00ea !important;
  }

  .card {
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    color: #fff;
  }
  .card-title {
    font-size: 1.3rem;
    font-weight: 600;
  }

  .card:hover {
    transform: translateY(-6px);
    transition: 0.3s;
    border-color: #ff00ea;
  }

  .btn-primary {
    background: linear-gradient(to right, #ff00ea, #8e00ff);
    border: none;
  }
  .btn-primary:hover {
    opacity: 0.85;
  }

  footer {
    background: rgba(255, 255, 255, 0.05);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }

  pre {
    background: rgba(255, 255, 255, 0.07);
    padding: 20px;
    border-radius: 10px;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
  }
</style>

<head>
    <meta charset="UTF-8">
    <title>Song Lyrics Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_PATH; ?>/index.php">LyricsHub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_PATH; ?>/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_PATH; ?>/search.php">Search</a>
        </li>
        <?php if (isAdmin()): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_PATH; ?>/admin/index.php">Admin</a>
        </li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php if (isLoggedIn()): ?>
          <li class="nav-item">
            <span class="navbar-text me-2">
              Hi, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
            </span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_PATH; ?>/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_PATH; ?>/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_PATH; ?>/register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container mb-5">
