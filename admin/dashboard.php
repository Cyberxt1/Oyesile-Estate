<?php
// ✅ Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Restrict access to only logged-in users
if (!isset($_SESSION['resident_email']) || empty($_SESSION['resident_email'])) {
    header("Location: ../views/login.php");
    exit();
}

// ✅ Connect to DB
require_once('../includes/db.php');

try {
    // Total residents
    $stmt = $pdo->query("SELECT COUNT(*) FROM residents");
    $totalResidents = $stmt->fetchColumn();

    // Houses occupied
    $stmt = $pdo->query("SELECT COUNT(DISTINCT house_no) FROM residents WHERE house_no IS NOT NULL");
    $housesOccupied = $stmt->fetchColumn();

    // Temporary placeholders for now
    $pendingComplaints = 0;
    $outstandingPayments = 0.00;
} catch (PDOException $e) {
    die("Error fetching dashboard data: " . $e->getMessage());
}
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
        <h2 style="color: Gold;">Oyesile Estate</h2>
        <a href="#">Dashboard</a>
        <a href="./residents/residents.php">Residents</a>
        <a href="#">Houses</a>
        <a href="#">Payments</a>
        <a href="#">Complaints</a>
        <a href="./admin_profile.php">Manage Profile</a>
        <a href="./admin_announcement.php">Announcements</a>
        <a href="../views/logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="header">
            <h1>Dashboard</h1>
            <p>Welcome, <?= htmlspecialchars($_SESSION['resident_name']); ?> (<?= htmlspecialchars($_SESSION['resident_role']); ?>)</p>
        </div>

        <div class="cards">
            <div class="card">
                <a href="./residents/residents.php" style="text-decoration: none;">
                    <h3>Total Residents</h3>
                </a>
                <p><?= $totalResidents; ?> Residents</p>
            </div>
            <div class="card">
                <h3>Houses Occupied</h3>
                <p><?= $housesOccupied; ?> Houses</p>
            </div>
            <div class="card">
                <h3>Pending Complaints</h3>
                <p><?= $pendingComplaints; ?> Issues</p>
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