<?php
require_once '../../includes/db.php';

if (isset($_GET['email']) && isset($_GET['action'])) {
    $email = $_GET['email'];
    $action = strtolower($_GET['action']); // 'suspend' or 'restore'

    try {
        // Check if resident exists
        $stmt = $pdo->prepare("SELECT status FROM residents WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $resident = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resident) {
            $currentStatus = strtolower($resident['status']);

            if ($action === 'suspend' && $currentStatus === 'active') {
                // Suspend the resident
                $updateStmt = $pdo->prepare("UPDATE residents SET status = 'Suspended' WHERE email = :email");
                $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);
                $updateStmt->execute();
                echo "Suspended successfully";
            } elseif ($action === 'restore' && $currentStatus === 'suspended') {
                // Restore the resident
                $updateStmt = $pdo->prepare("UPDATE residents SET status = 'Active' WHERE email = :email");
                $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);
                $updateStmt->execute();
                echo "Restored successfully";
            } else {
                echo "No action taken (Already " . ucfirst($currentStatus) . ")";
            }
        } else {
            echo "Resident not found";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "Required parameters not provided";
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