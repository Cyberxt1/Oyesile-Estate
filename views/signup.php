<!-- Seperate Login For both User and Admin -->







<?php
require_once '../includes/db.php'; // Adjust if needed based on actual structure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $full_name = trim(htmlspecialchars($_POST['full_name']));
    $house_no = trim(htmlspecialchars($_POST['house_no']));
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim(htmlspecialchars($_POST['phone']));
    $resident_type = trim($_POST['resident_type']); // Resident type (Landlord or Tenant)
    $status = 'Active'; // Default status

    // Validate essential fields
    if (!$full_name || !$house_no || !$email || !$password || !$phone || !$resident_type) {
        die("Please fill all required fields.");
    }

    try {
        // Check if email already exists
        $check = $pdo->prepare("SELECT * FROM residents WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            header("Location: ../Error_Pages/email-registered.html");
            exit;
        }

        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new resident with resident type
        $stmt = $pdo->prepare("INSERT INTO residents (full_name, house_no, email, password, phone, resident_type, status) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $house_no, $email, $hashed_password, $phone, $resident_type, $status]);

        // Redirect to login or dashboard
        header("Location: ./login.php");
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
