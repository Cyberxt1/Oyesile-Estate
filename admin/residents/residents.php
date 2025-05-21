<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Residents Management | Oyesile Estate</title>
  <link rel="stylesheet" href="../../css/residents.css">
  <link rel="stylesheet" href="../../css/sidebar.css">
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

  <div class="container" id="mainContainer">
    <h1>Residents Management</h1>

    <div class="top-bar">
      <input type="text" id="searchInput" placeholder="Search by name or house number" />
      <a href="add-resident.html" class="add-btn">+ Add Resident</a>
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
        <!-- Populate rows dynamically using JavaScript -->
      </tbody>
    </table>
  </div>

  <script>
    // Example data for residents
    const residents = [
      { fullName: "John Doe", houseNo: "12A", phone: "1234567890", residentType: "Owner", status: "active" },
      { fullName: "Jane Smith", houseNo: "15B", phone: "0987654321", residentType: "Tenant", status: "suspended" }
    ];

    const residentsTable = document.getElementById('residentsTable');

    residents.forEach(resident => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${resident.fullName}</td>
        <td>${resident.houseNo}</td>
        <td>${resident.phone}</td>
        <td>${resident.residentType}</td>
        <td><span class="status ${resident.status}">${resident.status.charAt(0).toUpperCase() + resident.status.slice(1)}</span></td>
        <td>
          <button class="edit">Edit</button>
          <button class="toggle-status">${resident.status === 'active' ? 'Suspend' : 'Restore'}</button>
          <button class="delete">Delete</button>
        </td>
      `;
      residentsTable.appendChild(row);
    });
  </script>
</body>

</html>