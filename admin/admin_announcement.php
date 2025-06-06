<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Post Announcement | Admin</title>
  <link rel="stylesheet" href="../css/admin_announce.css">
  <link rel="stylesheet" href="../css/sidebar.css">
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
  <div class="sidebar-overlay"></div>
  <div class="sidebar animated-sidebar closed">
    <h2 class="estate-title">Oyesile Estate</h2>
    <a href="/admin/dashboard.html" class="sidebar-link">Dashboard</a>
    <a href="/admin/residents/residents.html" class="sidebar-link">Residents</a>
    <a href="#" class="sidebar-link">Houses</a>
    <a href="#" class="sidebar-link">Payments</a>
    <a href="#" class="sidebar-link">Complaints</a>
    <a href="/admin/admin_profile.html" class="sidebar-link">Manage Profile</a>
    <a href="/admin/admin_announcement.html" class="sidebar-link">Announcements</a>
    <a href="/views/logout.html" class="sidebar-link">Logout</a>
  </div>

  <div style="margin-left: 270px; padding: 40px; width: 100%; max-width: 700px;">
    <h2 class="div-h2">Post Announcement</h2>

    <p class="success-msg" id="success-msg" style="display: none;">Announcement posted successfully!</p>
    <p class="error-msg" id="error-msg" style="display: none;">Error posting announcement.</p>

    <form id="announcement-form">
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

    <button class="btn-danger" id="delete-all">Delete All Announcements</button>
  </div>

  <script>
    document.getElementById('announcement-form').addEventListener('submit', function (e) {
      e.preventDefault();
      document.getElementById('success-msg').style.display = 'block';
      document.getElementById('error-msg').style.display = 'none';
    });

    document.getElementById('delete-all').addEventListener('click', function () {
      if (confirm('Are you sure you want to delete ALL announcements?')) {
        alert('All announcements deleted successfully!');
      }
    });
  </script>
</body>

</html>