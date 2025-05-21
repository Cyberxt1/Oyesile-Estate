<?php
session_start();
require_once('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['resident_email'])) {
  header("Location: ../views/login.php");
  exit;
}

$email = $_SESSION['resident_email'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = htmlspecialchars(trim($_POST['name']));  // Changed 'name' to 'full_name'
  $phone = htmlspecialchars(trim($_POST['phone']));

  $stmt = $pdo->prepare("UPDATE residents SET full_name = :full_name, phone = :phone WHERE email = :email");  // Changed 'name' to 'full_name'
  $stmt->execute([
    'full_name' => $full_name,  // Changed 'name' to 'full_name'
    'phone' => $phone,
    'email' => $email
  ]);
  $_SESSION['resident_name'] = $full_name;  // Changed 'name' to 'full_name'
  header("Location: user_profile.php?success=1");
  exit;
}

// Fetch resident data
$stmt = $pdo->prepare("SELECT * FROM residents WHERE email = :email LIMIT 1");
$stmt->execute(['email' => $email]);
$resident = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resident) {
  die("User not found.");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>
  <link rel="stylesheet" href="../css/user/user_profile.css">
</head>

<body>
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

  <div class="main">
    <div class="header">
      <h1>My Profile</h1>
      <button id="editBtn">Edit</button>
    </div>

    <form method="POST" id="profileForm">
      <div class="cards">
        <div class="card">
          <h3>Full Name</h3>
          <input type="text" name="name" required value="<?= htmlspecialchars($resident['full_name'] ?? '') ?>" readonly>
        </div>
        <div class="card">
          <h3>Email</h3>
          <input type="email" value="<?= htmlspecialchars($resident['email']) ?>" readonly disabled>
        </div>
        <div class="card">
          <h3>Phone</h3>
          <input type="text" name="phone" value="<?= htmlspecialchars($resident['phone']) ?>" readonly>
        </div>
        <div class="card">
          <h3>House Number</h3>
          <input type="text" value="<?= htmlspecialchars($resident['house_no']) ?>" readonly disabled>
        </div>
        <div class="card">
          <h3>Status</h3>
          <input type="text" value="<?= htmlspecialchars($resident['status']) ?>" readonly disabled>
        </div>
      </div>
      <button type="submit" id="saveBtn" style="display:none;">Save</button>
    </form>

    <footer>&copy; <?= date("Y") ?> Oyesile Estate</footer>
  </div>

  <script>
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const inputs = document.querySelectorAll('input[name]');

    editBtn.addEventListener('click', () => {
      inputs.forEach(input => input.removeAttribute('readonly'));
      saveBtn.style.display = 'inline-block';
    });
  </script>
</body>

</html>