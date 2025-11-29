<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Song Lyrics Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- YOUR GLOBAL CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body style="font-family: 'Poppins', sans-serif; background: #0b0c1a; color: #f5f6ff;">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 sticky-top">
  <div class="container py-1">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">
      Lyrics<span style="color:#ff5cf4;">Hub</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>search.php">Search</a>
        </li>

        <?php if (isAdmin()): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>admin/index.php">Admin</a>
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
            <a class="nav-link" href="<?php echo BASE_URL; ?>logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>login.php">Login</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>

    </div>
  </div>
</nav>

<div class="container mb-5">

