<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM patient_queue WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ../public/patient_queue.php");
exit();
?>
