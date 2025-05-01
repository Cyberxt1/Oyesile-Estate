<?php
// Start session
session_start();

// Database connection
$host = "localhost";
$dbname = "estate_portal";
$user = "root";
$pass = "N3xtk3v!n05"; // Replace with your password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Sign up logic
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"]; // either 'admin' or 'user'

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validation
    if (empty($username) || empty($full_name) || empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required!";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, full_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $full_name, $email, $hashed_password, $role]);

            // Redirect after successful signup
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $error = "Signup failed: " . $e->getMessage();
        }
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up | Oyesile Estate</title>
  <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
  <h1 class="welcome-text">Welcome to Oyesile Estate</h1>

  <div class="auth-card">
    <h2>Sign Up</h2>

    <?php if (!empty($error)): ?>
      <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="signup.php" method="POST" class="auth-form">
      <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required />
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role" required>
          <option value="">Select role</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <button type="submit" class="auth-btn">Sign Up</button>
      <p class="redirect-link">
        Already have an account? <a href="login.php">Login</a>
      </p>
    </form>
  </div>
</body>
</html>
