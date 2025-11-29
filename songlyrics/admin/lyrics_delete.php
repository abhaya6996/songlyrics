<?php
require_once __DIR__ . '/../includes/config.php';

if (!isAdmin()) {
    header('Location: ' . BASE_PATH . '/login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM lyrics WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: ' . BASE_PATH . '/admin/lyrics_list.php');
exit;
