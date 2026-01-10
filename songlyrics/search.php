<?php
require_once __DIR__ . '/includes/header.php';
$q = trim($_GET['q'] ?? '');
$songs = [];
if ($q !== '') {
    $like = "%" . $q . "%";
    $stmt = $conn->prepare("
        SELECT songs_id, title, artist, created_at
        FROM songs
        WHERE title LIKE ? OR artist LIKE ? OR lyrics LIKE ?
        ORDER BY created_at DESC
        LIMIT 50
    ");

    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();

    $res = $stmt->get_result();
    $songs = $res->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
}
?>

<h1 class="mb-4">Search</h1>

<form method="get" class="mb-4">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search by title, artist, or lyrics..."
           value="<?= htmlspecialchars($q) ?>">
    <button class="btn btn-primary">Search</button>
  </div>
</form>

<?php if ($q === ''): ?>
  <div class="text-muted">Type something to search songs.</div>

<?php elseif (empty($songs)): ?>
  <div class="alert alert-warning">No results found for "<strong><?= htmlspecialchars($q) ?></strong>".</div>

<?php else: ?>
  <div class="list-group">
    <?php foreach ($songs as $s): ?>
      <a class="list-group-item list-group-item-action"
         href="<?= BASE_URL ?>song.php?id=<?= (int)$s['songs_id'] ?>">
        <div class="d-flex justify-content-between">
          <div>
            <strong><?= htmlspecialchars($s['title']) ?></strong>
            <div class="text-muted">by <?= htmlspecialchars($s['artist']) ?></div>
          </div>
          <small class="text-secondary"><?= htmlspecialchars($s['created_at']) ?></small>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
