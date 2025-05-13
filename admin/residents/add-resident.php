<?php include '../../includes/db.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = htmlspecialchars($_POST['full_name']);
  $house_no = htmlspecialchars($_POST['house_no']);
  $phone = htmlspecialchars($_POST['phone']);
  $email = htmlspecialchars($_POST['email']);
  $status = 'Active';

  // Set default password (e.g., for new resident login later)
  $default_password = 'changeme123';
  $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

  try {
    $stmt = $pdo->prepare("INSERT INTO residents (full_name, house_no, phone, email, password, status) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $house_no, $phone, $email, $hashed_password, $status]);

    header("Location: residents.php");
    exit;
  } catch (PDOException $e) {
    // Optional: handle duplicate email errors gracefully
    if ($e->getCode() == 23000) {
      die("Resident with this email already exists.");
    }
    die("Error adding resident: " . $e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Resident</title>
  <link rel="stylesheet" href="../../css/add-resident.css">
</head>
<body>
  <h2>Add New Resident</h2>
  <form method="post">
    <input name="full_name" placeholder="Full Name" required><br>
    <input name="house_no" placeholder="House Number" required><br>
    <input name="phone" placeholder="Phone Number" required><br>
    <input name="email" type="email" placeholder="Email" required><br>
    <button type="submit">Add Resident</button>
  </form>
</body>
</html>
