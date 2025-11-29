<?php require_once __DIR__ . '/includes/header.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($name === '' || $email === '' || $pass === '') {
        $errors[] = 'All fields are required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }
    if ($pass !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param('sss', $name, $email, $hash);
        if ($stmt->execute()) {
            $success = 'Registration successful. You can now login.';
        } else {
            if ($conn->errno === 1062) {
                $errors[] = 'Email already registered.';
            } else {
                $errors[] = 'Database error.';
            }
        }
        $stmt->close();
    }
}
?>

<h1 class="mb-4">Register</h1>

<?php foreach ($errors as $e): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($e); ?></div>
<?php endforeach; ?>

<?php if ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="post" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control"
           value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
  </div>
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
  </div>
  <div class="col-md-6">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control">
  </div>
  <div class="col-md-6">
    <label class="form-label">Confirm Password</label>
    <input type="password" name="confirm_password" class="form-control">
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Register</button>
  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
 