<?php require_once __DIR__ . '/includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT title, artist, album, lyrics, created_at FROM songs WHERE songs_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$song = $result->fetch_assoc();
$stmt->close();
?>
<h1 style="font-weight:700; color:#ff00ea; text-shadow:0 0 10px #ff00ea;">
  <?php echo htmlspecialchars($song['title']); ?>
</h1>
<h4 class="text-info">By <?php echo htmlspecialchars($song['artist']); ?></h4>

<?php if ($song): ?>
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <h1><?php echo htmlspecialchars($song['title']); ?></h1>
      <h4 class="text-muted">by <?php echo htmlspecialchars($song['artist']); ?></h4>
      <?php if (!empty($song['album'])): ?>
        <p><strong>Album:</strong> <?php echo htmlspecialchars($song['album']); ?></p>
      <?php endif; ?>
      <p><small class="text-secondary">Added: <?php echo htmlspecialchars($song['created_at']); ?></small></p>
      <hr>
      <pre class="mt-3" style="white-space: pre-wrap;"><?php echo htmlspecialchars($song['lyrics']); ?></pre>
    </div>
  </div>
<?php else: ?>
  <div class="alert alert-danger">Song not found.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
