<?php
require_once '../config/db.php';

// Replace these with your preferred credentials
$users = [
    ['admin', '123456', 'admin'],
    ['clerk', '123456', 'record_officer']
];

foreach ($users as [$username, $plain_password, $role]) {
    $hashed = password_hash($plain_password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashed, $role]);
        echo "User '$username' created successfully.<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
}
