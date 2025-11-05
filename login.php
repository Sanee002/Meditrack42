<?php
session_start();
require_once '../config/db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;

    if ($user['role'] === 'admin') {
        header('Location: ../public/dashboard.php');
    } else {
        header('Location: ../public/view_patients.php');
    }
    exit();
} else {
    echo "Invalid username or password.";
}
