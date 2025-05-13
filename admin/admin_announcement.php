<?php
session_start();
require_once('../includes/db.php');

$success = "";
$error = "";

// Handle POST request for new announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'post') {
  $title = htmlspecialchars(trim($_POST['title']));
  $message = htmlspecialchars(trim($_POST['message']));
  $target = $_POST['target']; // all, tenant, landlord

  if (!in_array($target, ['all', 'tenant', 'landlord'])) {
    $error = "Invalid target selected.";
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO announcements (title, message, target) VALUES (:title, :message, :target)");
      $stmt->execute([
        'title' => $title,
        'message' => $message,
        'target' => $target
      ]);
      $success = "Announcement posted successfully!";
    } catch (PDOException $e) {
      $error = "Error posting announcement: " . $e->getMessage();
    }
  }
}

// Handle DELETE ALL
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_all') {
  try {
    $stmt = $pdo->prepare("DELETE FROM announcements");
    $stmt->execute();
    $success = "All announcements deleted successfully!";
  } catch (PDOException $e) {
    $error = "Error deleting announcements: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Post Announcement | Admin</title>
  <link rel="stylesheet" href="../css/admin_announce.css">
  <style>
    .success-msg {
      color: green;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .error-msg {
      color: red;
      font-weight: bold;
      margin-bottom: 10px;
    }

    form {
      margin-top: 20px;
    }

    .btn-danger {
      background-color: darkred;
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 5px;
      margin-top: 10px;
      cursor: pointer;
    }

    .btn-danger:hover {
      background-color: red;
    }

    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h2 class="side-h2">Admin Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="./admin_profile.php">Profile</a>
    <a href="admin_announcement.php" class="active">Post Announcement</a>
    <a href="../views/logout.php">Logout</a>
  </div>

  <div style="margin-left: 270px; padding: 40px; width: 100%; max-width: 700px;">
    <h2 class="div-h2">Post Announcement</h2>

    <?php if (!empty($success)): ?>
      <p class="success-msg"><?= $success ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <p class="error-msg"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="hidden" name="action" value="post">
      <div class="card">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
      </div>
      <div class="card">
        <label for="message">Message</label>
        <textarea name="message" id="message" rows="5" required></textarea>
      </div>
      <div class="card">
        <label for="target">Send To</label>
        <select name="target" id="target" required>
          <option value="all">All Residents</option>
          <option value="tenant">Only Tenants</option>
          <option value="landlord">Only Landlords</option>
        </select>
      </div>
      <button type="submit" style="padding: 10px 25px; background-color: #003366; color: white; border: none; border-radius: 5px;">Post</button>
    </form>

    <form method="POST" onsubmit="return confirm('Are you sure you want to delete ALL announcements?');">
      <input type="hidden" name="action" value="delete_all">
      <button type="submit" class="btn-danger">Delete All Announcements</button>
    </form>
  </div>
</body>

</html>