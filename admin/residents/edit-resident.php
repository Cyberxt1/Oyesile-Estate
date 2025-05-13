<?php include '../config/db.php'; ?>
<?php
$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM residents WHERE id=$id");
$row = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = htmlspecialchars($_POST['full_name']);
  $house_no = htmlspecialchars($_POST['house_no']);
  $phone = htmlspecialchars($_POST['phone']);
  $email = htmlspecialchars($_POST['email']);

  $stmt = $conn->prepare("UPDATE residents SET full_name=?, house_no=?, phone=?, email=? WHERE id=?");
  $stmt->bind_param("ssssi", $full_name, $house_no, $phone, $email, $id);
  $stmt->execute();

  header("Location: residents.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Resident</title>
</head>
<body>
  <h2>Edit Resident</h2>
  <form method="post">
    <input name="full_name" value="<?= $row['full_name'] ?>" required><br>
    <input name="house_no" value="<?= $row['house_no'] ?>" required><br>
    <input name="phone" value="<?= $row['phone'] ?>" required><br>
    <input name="email" type="email" value="<?= $row['email'] ?>" required><br>
    <button type="submit">Save Changes</button>
  </form>
</body>
</html>
