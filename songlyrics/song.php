<?php
require_once __DIR__ . '/includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$userId = $_SESSION['user']['user_id'] ?? null;

/* =======================
   LIKE TOGGLE (POST)
   ======================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_like'])) {
    if (!$userId) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }

    $chk = $conn->prepare("SELECT like_id FROM likes WHERE songs_id = ? AND user_id = ? LIMIT 1");
    $chk->bind_param("ii", $id, $userId);
    $chk->execute();
    $likedRow = $chk->get_result()->fetch_assoc();
    $chk->close();

    if ($likedRow) {
        $del = $conn->prepare("DELETE FROM likes WHERE songs_id = ? AND user_id = ?");
        $del->bind_param("ii", $id, $userId);
        $del->execute();
        $del->close();
    } else {
        $ins = $conn->prepare("INSERT INTO likes (songs_id, user_id) VALUES (?, ?)");
        $ins->bind_param("ii", $id, $userId);
        $ins->execute();
        $ins->close();
    }

    header("Location: " . BASE_URL . "song.php?id=" . $id);
    exit;
}

/* =======================
   ADD COMMENT (POST)
   ======================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_comment'])) {
    if (!$userId) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }

    $commentText = trim($_POST['comment_text'] ?? '');
    if ($commentText !== '') {
        $ins = $conn->prepare("INSERT INTO comments (songs_id, user_id, comment_text) VALUES (?, ?, ?)");
        $ins->bind_param("iis", $id, $userId, $commentText);
        $ins->execute();
        $ins->close();
    }

    header("Location: " . BASE_URL . "song.php?id=" . $id);
    exit;
}

// Now output header HTML
require_once __DIR__ . '/includes/header.php';

/* =======================
   FETCH SONG
   ======================= */
$stmt = $conn->prepare("SELECT title, artist, album, lyrics, created_at FROM songs WHERE songs_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$song = $result->fetch_assoc();
$stmt->close();

if (!$song): ?>
    <div class="alert alert-danger">Song not found.</div>
<?php
require_once __DIR__ . '/includes/footer.php';
exit;
endif;

/* =======================
   LIKE COUNT + USER LIKED
   ======================= */
$likeCount = 0;
$lc = $conn->prepare("SELECT COUNT(*) AS c FROM likes WHERE songs_id = ?");
$lc->bind_param("i", $id);
$lc->execute();
$likeCount = (int)($lc->get_result()->fetch_assoc()['c'] ?? 0);
$lc->close();

$userLiked = false;
if ($userId) {
    $ul = $conn->prepare("SELECT 1 FROM likes WHERE songs_id = ? AND user_id = ? LIMIT 1");
    $ul->bind_param("ii", $id, $userId);
    $ul->execute();
    $userLiked = (bool)$ul->get_result()->fetch_assoc();
    $ul->close();
}

/* =======================
   LOAD COMMENTS
   ======================= */
$comments = [];
$cm = $conn->prepare("
    SELECT c.comment_text, c.created_at, u.username
    FROM comments c
    JOIN users u ON u.user_id = c.user_id
    WHERE c.songs_id = ?
    ORDER BY c.created_at DESC
");
$cm->bind_param("i", $id);
$cm->execute();
$comments = $cm->get_result()->fetch_all(MYSQLI_ASSOC);
$cm->close();
?>

<h1 style="font-weight:700; color:#ff00ea; text-shadow:0 0 10px #ff00ea;">
  <?= htmlspecialchars($song['title']) ?>
</h1>
<h4 class="text-info">By <?= htmlspecialchars($song['artist']) ?></h4>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <h1><?= htmlspecialchars($song['title']) ?></h1>
    <h4 class="text-muted">by <?= htmlspecialchars($song['artist']) ?></h4>

    <?php if (!empty($song['album'])): ?>
      <p><strong>Album:</strong> <?= htmlspecialchars($song['album']) ?></p>
    <?php endif; ?>

    <p><small class="text-secondary">Added: <?= htmlspecialchars($song['created_at']) ?></small></p>
    <hr>

    <pre class="mt-3" style="white-space: pre-wrap;"><?= htmlspecialchars($song['lyrics']) ?></pre>

    <hr class="mt-4">

    <!-- LIKE -->
    <div class="d-flex align-items-center gap-3">
      <div><strong>Likes:</strong> <?= (int)$likeCount ?></div>

      <?php if (isLoggedIn()): ?>
        <form method="post" class="m-0">
          <button type="submit" name="toggle_like"
                  class="btn btn-sm <?= $userLiked ? 'btn-danger' : 'btn-outline-danger' ?>">
            <?= $userLiked ? '♥ Liked' : '♡ Like' ?>
          </button>
        </form>
      <?php else: ?>
        <a class="btn btn-sm btn-outline-light" href="<?= BASE_URL ?>login.php">Login to Like</a>
      <?php endif; ?>
    </div>

    <!-- COMMENTS -->
    <div class="mt-4">
      <h5>Comments (<?= count($comments) ?>)</h5>

      <?php if (isLoggedIn()): ?>
        <form method="post" class="mt-2">
          <div class="mb-2">
            <textarea name="comment_text" rows="3" class="form-control"
                      placeholder="Write a comment..." required></textarea>
          </div>
          <button type="submit" name="add_comment" class="btn btn-primary btn-sm">Post Comment</button>
        </form>
      <?php else: ?>
        <div class="alert alert-secondary mt-2">
          Please <a href="<?= BASE_URL ?>login.php">login</a> to comment.
        </div>
      <?php endif; ?>

      <div class="mt-3">
        <?php if (empty($comments)): ?>
          <div class="text-muted">No comments yet.</div>
        <?php else: ?>
          <?php foreach ($comments as $c): ?>
            <div class="p-3 mb-2 rounded" style="background:#12132a;">
              <div class="d-flex justify-content-between">
                <strong><?= htmlspecialchars($c['username']) ?></strong>
                <small class="text-secondary"><?= htmlspecialchars($c['created_at']) ?></small>
              </div>
              <div class="mt-2"><?= nl2br(htmlspecialchars($c['comment_text'])) ?></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
