<?php require_once __DIR__ . '/includes/header.php';

$sql = "SELECT id, title, artist, created_at FROM lyrics ORDER BY created_at DESC LIMIT 12";
$result = $conn->query($sql);
$songs = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
$spotlight = array_slice($songs, 0, 3);
$latest = $songs;
?>

<section class="hero mb-5">
  <div class="row align-items-center">
    <div class="col-lg-7 position-relative">
      <h1 class="display-5 mb-3">Discover lyrics, vibe with your favorites.</h1>
      <p class="lead mb-4">Dive into a curated collection of songs from timeless classics to fresh drops. Explore, search, and save the verses that move you.</p>
      <form class="search-bar d-flex align-items-center" method="get" action="search.php">
        <input class="form-control me-2" type="search" name="q" placeholder="Search by song or artist" aria-label="Search">
        <button class="btn btn-primary px-4" type="submit">Search</button>
      </form>
    </div>
    <div class="col-lg-5 mt-4 mt-lg-0">
      <div class="card h-100 p-4">
        <div class="d-flex align-items-center mb-3">
          <span class="badge bg-primary me-2">New</span>
          <small class="text-uppercase text-muted">Freshly added</small>
        </div>
        <div class="vstack gap-3">
          <?php if (!empty($songs)): ?>
            <?php foreach (array_slice($songs, 0, 4) as $song): ?>
              <div class="d-flex justify-content-between align-items-center pb-2 border-bottom border-secondary-subtle">
                <div>
                  <div class="fw-semibold"><?php echo htmlspecialchars($song['title']); ?></div>
                  <small class="text-muted"><?php echo htmlspecialchars($song['artist']); ?></small>
                </div>
                <a class="btn btn-sm btn-outline-light" href="song.php?id=<?php echo (int)$song['id']; ?>">Play</a>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted mb-0">No songs yet. Be the first to add one!</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <p class="text-uppercase text-muted mb-1">Spotlight</p>
      <h2 class="fw-bold">Featured picks</h2>
    </div>
    <a href="search.php" class="btn btn-outline-light">Browse all</a>
  </div>
  <div class="row g-4">
    <?php if (!empty($spotlight)): ?>
      <?php foreach ($spotlight as $song): ?>
        <div class="col-md-4">
          <div class="card h-100 p-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <span class="badge" style="background: linear-gradient(135deg, #ff5cf4, #9f6bff);">Hot</span>
              <small class="text-muted">Added: <?php echo htmlspecialchars($song['created_at']); ?></small>
            </div>
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($song['title']); ?></h5>
            <p class="card-subtitle mb-4"><?php echo htmlspecialchars($song['artist']); ?></p>
            <p class="text-muted flex-grow-1">Sing along with the latest verses and relive your favorite hooks.</p>
            <a href="song.php?id=<?php echo (int)$song['id']; ?>" class="btn btn-primary mt-auto">🎧 View Lyrics</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-info">No songs added yet.</div>
      </div>
    <?php endif; ?>
  </div>
</section>

<section>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <p class="text-uppercase text-muted mb-1">Library</p>
      <h2 class="fw-bold">Latest uploads</h2>
    </div>
  </div>
  <div class="row g-4">
    <?php if (!empty($latest)): ?>
      <?php foreach ($latest as $song): ?>
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo htmlspecialchars($song['title']); ?></h5>
              <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($song['artist']); ?></h6>
              <p class="card-text"><small class="text-muted">Added: <?php echo htmlspecialchars($song['created_at']); ?></small></p>
              <a href="song.php?id=<?php echo (int)$song['id']; ?>" class="btn btn-primary mt-auto">View Lyrics</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-info">No songs added yet.</div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
