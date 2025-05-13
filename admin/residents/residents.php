<?php
include(__DIR__ . '/../../includes/db.php');

try {
  $stmt = $pdo->prepare("SELECT * FROM residents ORDER BY full_name ASC");
  $stmt->execute();
  $residents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error fetching residents: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Residents Management | Oyesile Estate</title>
  <link rel="stylesheet" href="../../css/residents.css">
  <style>
    .status.active {
      color: green;
      font-weight: bold;
    }

    .status.suspended {
      color: red;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>Oyesile Estate</h2>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../admin_profile.php" class="active">Manage Profile</a>
    <a href="residents.php">Manage Users</a>
    <a href="manage_dues.php">Manage Dues</a>
    <a href="../admin_announcement.php">Announcements</a>
    <a href="../../views/logout.php">Logout</a>
  </div>


  <div class="container">
    <h1>Residents Management</h1>

    <div class="top-bar">
      <input type="text" id="searchInput" placeholder="Search by name or house number" />
      <a href="add-resident.php" class="add-btn">+ Add Resident</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>Full Name</th>
          <th>House No.</th>
          <th>Phone</th>
          <th>Resident Type</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="residentsTable">
        <?php foreach ($residents as $row): ?>
          <?php
          $status = strtolower($row['status']);
          $action = ($status === 'active') ? 'Suspend' : 'Restore';
          $actionClass = ($status === 'active') ? 'suspend' : 'restore';
          ?>
          <tr data-email="<?= htmlspecialchars($row['email']) ?>">
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['house_no']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['resident_type']) ?></td>
            <td><span class="status <?= $status ?>"><?= ucfirst($status) ?></span></td>
            <td>
              <a href="edit-resident.php?email=<?= urlencode($row['email']) ?>" class="edit">Edit</a>
              <button class="toggle-status <?= $actionClass ?>"><?= $action ?></button>
              <button class="delete" data-email="<?= htmlspecialchars($row['email']) ?>">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    // Delete resident
    document.querySelectorAll('.delete').forEach(btn => {
      btn.onclick = () => {
        if (confirm('Are you sure you want to delete this resident?')) {
          fetch('delete-resident.php?email=' + encodeURIComponent(btn.dataset.email))
            .then(() => location.reload());
        }
      };
    });

    // Suspend/Restore resident with live DOM updates
    document.querySelectorAll('.toggle-status').forEach(btn => {
      btn.onclick = () => {
        const row = btn.closest('tr');
        const email = row.dataset.email;
        const span = row.querySelector('.status');
        const currentStatus = span.textContent.toLowerCase();
        const action = currentStatus === 'active' ? 'suspend' : 'restore';

        fetch(`suspend-resident.php?email=${encodeURIComponent(email)}&action=${action}`)
          .then(res => res.text())
          .then(response => {
            if (response.toLowerCase().includes("success")) {
              if (action === 'suspend') {
                span.textContent = 'Suspended';
                span.className = 'status suspended';
                btn.textContent = 'Restore';
                btn.classList.remove('suspend');
                btn.classList.add('restore');
              } else {
                span.textContent = 'Active';
                span.className = 'status active';
                btn.textContent = 'Suspend';
                btn.classList.remove('restore');
                btn.classList.add('suspend');
              }
            } else {
              alert(response);
            }
          });
      };
    });
  </script>
</body>

</html>