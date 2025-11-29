<?php
require_once __DIR__ . '/../includes/header.php';

if (!isAdmin()) {
    header('Location: ' . BASE_PATH . '/login.php');
    exit;
}

$result = $conn->query("SELECT id, title, artist, created_at FROM lyrics ORDER BY created_at DESC");
?>

<h1 class="mb-4">Manage Lyrics</h1>

<a href="lyrics_add.php" class="btn btn-success mb-3">Add New Song</a>

<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Artist</th>
      <th>Created</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['title']); ?></td>
          <td><?php echo htmlspecialchars($row['artist']); ?></td>
          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
          <td>
            <a href="lyrics_edit.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="lyrics_delete.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Delete this song?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">No songs yet.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
