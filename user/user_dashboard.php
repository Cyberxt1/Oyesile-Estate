<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

echo "<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
        history.go(1);
    };
</script>";

require_once('../includes/db.php');

$residentEmail = $_SESSION['resident_email'];
$residentName = htmlspecialchars($_SESSION['resident_name']);
$residentRole = strtolower($_SESSION['resident_role']);

try {
    $stmt = $pdo->prepare("SELECT * FROM residents WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $residentEmail]);
    $residentData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$residentData) {
        die("Resident not found.");
    }

    $stmtAnnounce = $pdo->prepare("
        SELECT title, message, created_at
        FROM announcements
        WHERE target = 'all' OR target = :role
        ORDER BY created_at DESC
    ");
    $stmtAnnounce->execute(['role' => $residentRole]);
    $announcements = $stmtAnnounce->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching dashboard data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard - Estate Management</title>
    <link rel="stylesheet" href="../css/user/style-dashboard.css">
    <style>
        .announcements-container {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #ddd;
            display: flex;
            height: 400px;
            flex-direction: column;
            overflow-y: scroll;
        }
        
        .announcements-container h2 {
            color: blanchedalmond;
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            position: sticky;
            top: 0;
            background-color:rgb(2, 29, 56);
            border-radius: 10px;
        }

        .announcement-card {
            background-color: #fff8dc;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .announcement-card h3 {
            color: #003366;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .announcement-card p {
            color: #555;
            margin-bottom: 8px;
        }

        .announcement-card small {
            color: #777;
        }

        .no-announcements {
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2 style="color: gold;">Oyesile Estate</h2>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="user_profile.php">My Profile</a>
        <a href="complaints.php">My Complaints</a>
        <a href="payments.php">Pay Dues</a>
        <a href="announcements.php">Announcements</a>
        <a href="../views/logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="header">
            <h1>Your Dashboard</h1>
            <p>Welcome, <?= $residentName ?> (<?= ucfirst($residentRole) ?>)</p>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Your House Number</h3>
                <p>House Number: <?= htmlspecialchars($residentData['house_no']); ?></p>
            </div>

            <div class="card">
                <h3>Phone Number</h3>
                <p><?= htmlspecialchars($residentData['phone']); ?></p>
            </div>

            <div class="card">
                <h3>My Status</h3>
                <p>Status: <?= htmlspecialchars($residentData['status']); ?></p>
            </div>
        </div>

        <div class="announcements-container">
            <h2>📢 Announcements</h2>
            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <div class="announcement-card">
                        <h3><?= htmlspecialchars($announcement['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($announcement['message'])) ?></p>
                        <small>
                            Posted on: <?= date("F j, Y, g:i a", strtotime($announcement['created_at'])) ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-announcements">No announcements yet.</p>
            <?php endif; ?>
        </div>

        <footer>
            &copy; <?= date("Y") ?> Oyesile Estate Management Portal. All Rights Reserved.
        </footer>
    </div>
</body>

</html>