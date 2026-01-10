<?php
require_once __DIR__ . '/../includes/header.php';

if (!isAdmin()) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

$countSongs = $conn->query("SELECT COUNT(*) AS c FROM lyrics")->fetch_assoc()['c'] ?? 0;
$countUsers = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'] ?? 0;
?>
<div class="card text-center shadow-lg p-4 mb-3">
  <h2 style="color:#8e00ff;"><?php echo $countSongs; ?></h2>
  <p>Total Songs</p>
</div>

<h1 class="mb-4">Admin Dashboard</h1>

<div class="row mb-4">
  <div class="col-md-4">
    <div class="card text-bg-primary mb-3">
      <div class="card-body">
        <h5 class="card-title">Total Songs</h5>
        <p class="card-text display-6"><?php echo (int)$countSongs; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-bg-secondary mb-3">
      <div class="card-body">
        <h5 class="card-title">Total Users</h5>
        <p class="card-text display-6"><?php echo (int)$countUsers; ?></p>
      </div>
    </div>
  </div>
</div>

<a href="lyrics_add.php" class="btn btn-success me-2">Add Lyrics</a>
<a href="lyrics_list.php" class="btn btn-outline-primary">Manage Lyrics</a>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
