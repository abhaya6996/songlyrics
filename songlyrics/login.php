<?php
require_once __DIR__ . '/includes/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($email === '' || $pass === '') {
        $errors[] = 'Email and password are required.';
    } else {

        $stmt = $conn->prepare(
            "SELECT user_id, username, email, password_hash, role
             FROM users
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $res  = $stmt->get_result();
        $user = $res->fetch_assoc();

        $stmt->close();

        if ($user && password_verify($pass, $user['password_hash'])) {

            $_SESSION['user'] = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'email'    => $user['email'],
                'role'     => $user['role']
            ];

            if (isAdmin()) {
                header('Location: ' . BASE_URL . 'admin/index.php');
            } else {
                header('Location: ' . BASE_URL . 'index.php');
            }
            exit;

        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
}
?>

<h1 class="mb-4">Login</h1>

<?php foreach ($errors as $e): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>

<form method="post">

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button class="btn btn-primary">Login</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
