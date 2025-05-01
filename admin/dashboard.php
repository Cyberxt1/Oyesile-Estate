<?php
session_start();
if ($_SESSION["role"] !== "admin") {
    header("Location: ../views/login.php"); // Redirect to login if not admin
    exit;
}

// Check if the user is logged in (redirect if not)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetching dynamic data from the database (just an example)
include('../includes/db.php'); // Include your DB connection

// Sample data fetching - replace this with actual queries to fetch data
$totalResidents = 245; // Example: get from DB
$housesOccupied = 180; // Example: get from DB
$pendingComplaints = 5; // Example: get from DB
$outstandingPayments = 12500; // Example: get from DB
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estate Management Portal</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Estate Portal</h2>
        <a href="#">Dashboard</a>
        <a href="#">Residents</a>
        <a href="#">Houses</a>
        <a href="#">Payments</a>
        <a href="#">Complaints</a>
        <a href="#">Announcements</a>
        <a href="#">Settings</a>
        <a href="../views/logout.php">Logout</a> <!-- Logout link -->
    </div>

    <div class="main">
        <div class="header">
            <h1>Dashboard</h1>
            <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p> <!-- Displaying the username -->
        </div>

        <div class="cards">
            <div class="card">
                <h3>Total Residents</h3>
                <p><?= $totalResidents; ?> Residents</p>
            </div>
            <div class="card">
                <h3>Houses Occupied</h3>
                <p><?= $housesOccupied; ?> Houses</p>
            </div>
            <div class="card">
                <h3>Pending Complaints</h3>
                <p><?= $pendingComplaints; ?> New Issues</p>
            </div>
            <div class="card">
                <h3>Outstanding Payments</h3>
                <p>$<?= number_format($outstandingPayments, 2); ?> Due</p>
            </div>
        </div>

        <footer>
            &copy; 2025 Estate Management Portal. All Rights Reserved.
        </footer>
    </div>
</body>
</html>
