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
?>

<div class="sidebar animated-sidebar">
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