<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
  :root {
    --bg-gradient: radial-gradient(circle at 20% 20%, rgba(255, 0, 234, 0.16), transparent 26%),
                   radial-gradient(circle at 80% 0%, rgba(142, 0, 255, 0.18), transparent 30%),
                   linear-gradient(135deg, #0b0c1a, #130024);
    --card-glow: 0 20px 60px rgba(0, 0, 0, 0.35);
    --border-frost: 1px solid rgba(255, 255, 255, 0.12);
    --glass: rgba(255, 255, 255, 0.08);
    --accent: #ff5cf4;
    --accent-2: #9f6bff;
  }

  * { box-sizing: border-box; }

  body {
    font-family: 'Poppins', sans-serif;
    background: var(--bg-gradient);
    color: #f5f6ff;
    min-height: 100vh;
    margin: 0;
  }

  a { color: #e6d8ff; }

  .navbar {
    background: rgba(0, 0, 0, 0.45) !important;
    backdrop-filter: blur(12px);
    border-bottom: var(--border-frost);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
  }

  .navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    letter-spacing: 0.5px;
    color: #fff !important;
  }

  .navbar-brand span {
    color: var(--accent);
  }

  .nav-link { color: #e6d8ff !important; }
  .nav-link:hover { color: #fff !important; }

  .card {
    background: var(--glass);
    border: var(--border-frost);
    backdrop-filter: blur(18px);
    border-radius: 18px;
    color: #f5f6ff;
    box-shadow: var(--card-glow);
    transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
  }

  .card-title {
    font-size: 1.25rem;
    font-weight: 700;
  }

  .card-subtitle { color: #cdd0f7; }

  .card:hover {
    transform: translateY(-8px);
    border-color: rgba(255, 92, 244, 0.5);
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.45);
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    border: none;
    font-weight: 600;
    letter-spacing: 0.3px;
  }
  .btn-primary:hover { opacity: 0.9; }

  .btn-outline-light {
    border-color: rgba(255, 255, 255, 0.35);
    color: #fff;
  }

  .search-bar {
    background: rgba(0, 0, 0, 0.28);
    border-radius: 50px;
    padding: 10px 12px;
    border: var(--border-frost);
  }

  .search-bar input {
    background: transparent;
    border: none;
    color: #fff;
  }

  .search-bar input::placeholder { color: #c7c8d9; }

  .hero {
    background: rgba(255, 255, 255, 0.03);
    border: var(--border-frost);
    border-radius: 24px;
    padding: 36px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--card-glow);
  }

  .hero:before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255, 92, 244, 0.25), transparent 35%);
    pointer-events: none;
  }

  .hero:after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 90% 30%, rgba(142, 0, 255, 0.22), transparent 35%);
    pointer-events: none;
  }

  .hero h1 { font-weight: 800; letter-spacing: 0.3px; }
  .hero p { color: #dcdff7; }

  footer {
    background: rgba(0, 0, 0, 0.5);
    border-top: var(--border-frost);
  }

  pre {
    background: var(--glass);
    padding: 20px;
    border-radius: 12px;
    color: #fff;
    border: var(--border-frost);
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 sticky-top">
  <div class="container py-1">
    <a class="navbar-brand" href="<?php echo BASE_PATH; ?>/index.php">Lyrics<span>Hub</span></a>
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

      <ul class="navbar-nav ms-auto align-items-lg-center">
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
