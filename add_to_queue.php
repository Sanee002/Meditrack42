<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_number = $_POST['file_number'];
    $name = $_POST['name'];

    // Prevent duplicates
    $check = $pdo->prepare("SELECT COUNT(*) FROM patient_queue WHERE file_number = ?");
    $check->execute([$file_number]);

    if ($check->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO patient_queue (file_number, name) VALUES (?, ?)");
        $stmt->execute([$file_number, $name]);
    }

    header("Location: ../public/patient_queue.php");
    exit();
}
?>
