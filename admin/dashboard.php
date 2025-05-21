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
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <div class="sidebar-overlay"></div>
    <div class="sidebar animated-sidebar closed">
        <h2 class="estate-title">Oyesile Estate</h2>
        <a href="/admin/dashboard.php" class="sidebar-link">Dashboard</a>
        <a href="/admin/residents/residents.php" class="sidebar-link">Residents</a>
        <a href="#" class="sidebar-link">Houses</a>
        <a href="#" class="sidebar-link">Payments</a>
        <a href="#" class="sidebar-link">Complaints</a>
        <a href="/admin/admin_profile.php" class="sidebar-link">Manage Profile</a>
        <a href="/admin/admin_announcement.php" class="sidebar-link">Announcements</a>
        <a href="/views/logout.php" class="sidebar-link">Logout</a>
    </div>

    <div class="main">
        <div class="header animated-header">
            <h1>Dashboard</h1>
            <p>Welcome, <span class="user-name"><?= htmlspecialchars($_SESSION['resident_name']); ?></span> (<span class="user-role"><?= htmlspecialchars($_SESSION['resident_role']); ?></span>)</p>
        </div>

        <div class="cards">
            <div class="card dashboard-card fade-in">
                <a href="./residents/residents.php" style="text-decoration: none; color: inherit;">
                    <h3>Total Residents</h3>
                </a>
                <p><?= $totalResidents; ?> Residents</p>
            </div>
            <div class="card dashboard-card fade-in" style="animation-delay: 0.1s;">
                <h3>Houses Occupied</h3>
                <p><?= $housesOccupied; ?> Houses</p>
            </div>
            <div class="card dashboard-card fade-in" style="animation-delay: 0.2s;">
                <h3>Pending Complaints</h3>
                <p><?= $pendingComplaints; ?> Issues</p>
            </div>
            <div class="card dashboard-card fade-in" style="animation-delay: 0.3s;">
                <h3>Outstanding Payments</h3>
                <p>$<?= number_format($outstandingPayments, 2); ?> Due</p>
            </div>
        </div>

        <footer class="footer">
            &copy; 2025 Estate Management Portal. All Rights Reserved.
        </footer>
    </div>
    <!-- <script src="../js/sidebar-toggle.js"></script> -->
</body>

</html>