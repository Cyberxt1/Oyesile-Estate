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
