<?php
require_once '../config/db.php';

$pdo->exec("TRUNCATE TABLE patient_queue");

header("Location: ../public/patient_queue.php");
exit();
?>
