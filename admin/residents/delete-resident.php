<?php
require_once '../../includes/db.php'; // Include the database connection file

if (isset($_GET['email'])) {
    $residentEmail = $_GET['email'];

    try {
        // Delete the resident from the database using email
        $stmt = $pdo->prepare("DELETE FROM residents WHERE email = :email");
        $stmt->bindParam(':email', $residentEmail, PDO::PARAM_STR);
        $stmt->execute();

        // Optionally, you can add a success message or redirect
        header("Location: residents.php?message=Resident deleted successfully");
        exit();
    } catch (PDOException $e) {
        die("Error deleting resident: " . $e->getMessage());
    }
} else {
    echo "Invalid resident email.";
}


