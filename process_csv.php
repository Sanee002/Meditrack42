<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Unauthorized access.");
}

if (isset($_FILES['csv_file']['tmp_name'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($file, 'r');

    // Skip header
    fgetcsv($handle);

    $imported = 0;
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $file_number = trim($data[0]);
        $name = trim($data[1]);
        $file_type = trim($data[2]);
        $sex = trim($data[3]);
        $address = trim($data[4]);
        $phone = trim($data[5]);
        $registration_date = trim($data[6]);

        if (!$file_number || !$name) continue; // skip invalid rows

        // Insert into DB
        $stmt = $pdo->prepare("INSERT INTO patient_registry 
            (file_number, name, file_type, sex, address, phone, registration_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        try {
            $stmt->execute([$file_number, $name, $file_type, $sex, $address, $phone, $registration_date]);
            $imported++;
        } catch (PDOException $e) {
            // Skip duplicates or errors silently
            continue;
        }
    }

    fclose($handle);
    header("Location: ../public/view_patients.php?imported=$imported");
    exit();
} else {
    die("No file selected.");
}
