<?php
// Database config

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'lyricsdb';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to DB
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

// Base URL of your project (folder name after localhost)
define("BASE_URL", "/songlyrics/");


// Helper functions
function isLoggedIn(): bool {
    return !empty($_SESSION['user']);
}
function isAdmin(): bool {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}
