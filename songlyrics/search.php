<?php require_once __DIR__ . '/includes/header.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = null;

if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt = $conn->prepare(
        "SELECT id, title, artist FROM lyrics
         WHERE title LIKE ? OR artist LIKE ?
         ORDER BY created_at DESC"
    );
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $results = $stmt->get_result();
    $stmt->close();
}
?>

<h1 class="mb-4">Search Lyrics</h1>

<form class="mb-4" method="get">
  <div class="input-group">
    <input type="text" name="q" class="form-control"
           placeholder="Type song title or artist"
           value="<?php echo htmlspecialchars($q); ?>">
    <button class="btn btn-primary">Search</button>
  </div>
</form>

<?php if ($q !== ''): ?>
  <h5>Results for: <em><?php echo htmlspecialchars($q); ?></em></h5>
  <hr>
  <?php if ($results && $results->num_rows > 0): ?>
    <div class="list-group mb-4">
      <?php while ($row = $results->fetch_assoc()): ?>
        <a href="song.php?id=<?php echo (int)$row['id']; ?>" class="list-group-item list-group-item-action">
          <strong><?php echo htmlspecialchars($row['title']); ?></strong>
          <span class="text-muted"> – <?php echo htmlspecialchars($row['artist']); ?></span>
        </a>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No songs found.</div>
  <?php endif; ?>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
