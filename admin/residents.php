<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Residents Management | Oyesile Estate</title>
  <link rel="stylesheet" href="../css/residents.css">
</head>
<body>
  <div class="container">
    <h1>Residents Management</h1>

    <!-- Top Bar -->
    <div class="top-bar">
      <input type="text" placeholder="Search by name or house number" />
      <button class="add-btn">+ Add Resident</button>
    </div>

    <!-- Residents Table -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>House No.</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Example data (to be replaced with PHP loop) -->
        <tr>
          <td>1</td>
          <td>John Doe</td>
          <td>A12</td>
          <td>08012345678</td>
          <td>johndoe@email.com</td>
          <td><span class="status active">Active</span></td>
          <td>
            <button class="edit">Edit</button>
            <button class="suspend">Suspend</button>
            <button class="delete">Delete</button>
          </td>
        </tr>
        <!-- Add PHP loop to populate more -->
      </tbody>
    </table>
  </div>
</body>
</html>
