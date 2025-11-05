<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Unauthorized access.");
}

require_once '../config/db.php';

// Input validation
$file_number = trim($_POST['file_number']);
$name = trim($_POST['name']);
$file_type = $_POST['file_type'];
$sex = $_POST['sex'];
$address = trim($_POST['address']);
$phone = trim($_POST['phone']);
$registration_date = $_POST['registration_date'];

// Ensure 6-digit format
if (!preg_match('/^\d{6}$/', $file_number)) {
    die("File number must be exactly 6 digits.");
}

try {
    $stmt = $pdo->prepare("INSERT INTO patient_registry 
        (file_number, name, file_type, sex, address, phone, registration_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$file_number, $name, $file_type, $sex, $address, $phone, $registration_date]);

    header("Location: ../public/view_patients.php");
    exit();
} catch (PDOException $e) {
    echo "Error saving patient: " . $e->getMessage();
}
