<?php
require_once __DIR__ . '/../includes/header.php';

if (!isAdmin()) {
header('Location: ' . BASE_URL . '/login.php');
exit;

}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = trim($_POST['title'] ?? '');
    $artist = trim($_POST['artist'] ?? '');
    $album  = trim($_POST['album'] ?? '');
    $lyrics = trim($_POST['lyrics'] ?? '');

    if ($title === '' || $artist === '' || $lyrics === '') {
        $errors[] = 'Title, artist and lyrics are required.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO lyrics (title, artist, album, lyrics) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $title, $artist, $album, $lyrics);
        if ($stmt->execute()) {
            $success = 'Song added successfully.';
        } else {
            $errors[] = 'Database error.';
        }
        $stmt->close();
    }
}
?>

<h1 class="mb-4">Add New Lyrics</h1>

<?php foreach ($errors as $e): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($e); ?></div>
<?php endforeach; ?>

<?php if ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control"
           value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Artist</label>
    <input type="text" name="artist" class="form-control"
           value="<?php echo htmlspecialchars($_POST['artist'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Album (optional)</label>
    <input type="text" name="album" class="form-control"
           value="<?php echo htmlspecialchars($_POST['album'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Lyrics</label>
    <textarea name="lyrics" rows="8" class="form-control"><?php echo htmlspecialchars($_POST['lyrics'] ?? ''); ?></textarea>
  </div>
  <button class="btn btn-success">Save</button>
  <a href="lyrics_list.php" class="btn btn-secondary">Back</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
