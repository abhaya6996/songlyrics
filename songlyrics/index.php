<?php require_once __DIR__ . '/includes/header.php';

$sql = "SELECT id, title, artist, created_at FROM lyrics ORDER BY created_at DESC LIMIT 12";
$result = $conn->query($sql);
?>
<div class="row">
<?php while ($row = $result->fetch_assoc()): ?>
  <div class="col-md-4 mb-4">
    <div class="card shadow-lg p-3">
      <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
      <p class="text-info mb-1"><?php echo htmlspecialchars($row['artist']); ?></p>
      <small class="text-secondary">Added: <?php echo $row['created_at']; ?></small>
      <hr>
      <a href="song.php?id=<?php echo $row['id']; ?>" class="btn btn-primary w-100">🎧 View Lyrics</a>
    </div>
  </div>
<?php endwhile; ?>
</div>

<div class="row mb-3">
  <div class="col-md-8">
    <h1 class="mb-3">Latest Lyrics</h1>
  </div>
  <div class="col-md-4">
    <form class="d-flex" method="get" action="search.php">
      <input class="form-control me-2" type="search" name="q" placeholder="Search songs or artists">
      <button class="btn btn-outline-light btn-primary" type="submit">Search</button>
    </form>
  </div>
</div>

<div class="row">
<?php if ($result && $result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-3">
      <div class="card h-100 shadow-sm">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
          <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($row['artist']); ?></h6>
          <p class="card-text"><small class="text-muted">Added: <?php echo htmlspecialchars($row['created_at']); ?></small></p>
          <a href="song.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-sm btn-primary mt-auto">View Lyrics</a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <div class="col-12">
    <div class="alert alert-info">No songs added yet.</div>
  </div>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
