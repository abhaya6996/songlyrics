<?php
require_once __DIR__ . '/../includes/header.php';

if (!isAdmin()) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT title, artist, album, lyrics FROM lyrics WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$song = $res->fetch_assoc();
$stmt->close();

if (!$song) {
    echo '<div class="alert alert-danger">Song not found.</div>';
    require_once __DIR__ . '/../includes/footer.php';
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
        $stmt = $conn->prepare("UPDATE lyrics SET title=?, artist=?, album=?, lyrics=? WHERE id=?");
        $stmt->bind_param('ssssi', $title, $artist, $album, $lyrics, $id);
        if ($stmt->execute()) {
            $success = 'Song updated.';
            $song['title']  = $title;
            $song['artist'] = $artist;
            $song['album']  = $album;
            $song['lyrics'] = $lyrics;
        } else {
            $errors[] = 'Database error.';
        }
        $stmt->close();
    }
}
?>

<h1 class="mb-4">Edit Lyrics</h1>

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
           value="<?php echo htmlspecialchars($song['title']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Artist</label>
    <input type="text" name="artist" class="form-control"
           value="<?php echo htmlspecialchars($song['artist']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Album (optional)</label>
    <input type="text" name="album" class="form-control"
           value="<?php echo htmlspecialchars($song['album']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Lyrics</label>
    <textarea name="lyrics" rows="8" class="form-control"><?php echo htmlspecialchars($song['lyrics']); ?></textarea>
  </div>
  <button class="btn btn-primary">Save Changes</button>
  <a href="lyrics_list.php" class="btn btn-secondary">Back</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
