<?php
session_start();  // Start the session to store user data

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

// ✅ DB connection (adjust according to your setup)
require_once('../includes/db.php');

// Initialize error message
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the POST request
    $email = strtolower(trim($_POST['email']));   // Clean the email, trim spaces and make lowercase
    $password = $_POST['password'];   // Get the password entered by the user

    // Check if email or password is empty
    if (empty($email) || empty($password)) {
        $error = "Both email and password are required.";
    } else {
        try {
            // ✅ Fetch user by email from the database
            $stmt = $pdo->prepare("SELECT * FROM residents WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $resident = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if resident exists and the password matches the hashed password
            if ($resident && password_verify($password, $resident['password'])) {
                // ✅ Set session variables for user
                $_SESSION['resident_email'] = $resident['email'];   // Store email
                $_SESSION['resident_name'] = $resident['full_name'];   // Store full name
                $_SESSION['resident_role'] = $resident['role'];   // Store role (admin, resident, etc.)
                $_SESSION['house_no'] = $resident['house_no'];   // Store house number if needed

                // Redirect to appropriate dashboard based on the role
                if ($resident['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");   // Redirect to admin dashboard
                    exit();   // Stop script execution after redirect
                } elseif ($resident['role'] === 'user') {
                    header("Location: ../user/user_dashboard.php");   // Redirect to resident dashboard
                    exit();   // Stop script execution after redirect
                } else {
                    $error = "Unknown role. Please contact support.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            // Catch any errors from the database connection
            $error = "Login failed. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Oyesile Estate</title>
    <link rel="stylesheet" href="../css/login.css" />
</head>

<body>
    <h1 class="welcome-text">Welcome to Oyesile Estate</h1>

    <div class="auth-card">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red;">
                <?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />
            </div>

            <button type="submit" class="auth-btn">Login</button>

            <p class="redirect-link">
                Don't have an account? <a href="./signup.html">Sign up</a>
            </p>
        </form>
    </div>
</body>

</html>