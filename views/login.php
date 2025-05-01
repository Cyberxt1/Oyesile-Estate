<?php
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

// Login logic
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "All fields are required!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            // Set session variables
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"]; // 'admin' or 'user'

            // Redirect based on role
            if ($user["role"] === "admin") {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/user_dashboard.php");
            }
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Oyesile Estate</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <h1 class="welcome-text">Welcome to Oyesile Estate</h1>

    <div class="auth-card">
        <h2>Login</h2>

        <!-- Error Display -->
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="auth-btn">Login</button>
            <p class="redirect-link">
                Don't have an account? <a href="signup.php">Sign up</a>
            </p>
        </form>
    </div>
</body>
</html>