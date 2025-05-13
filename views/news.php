<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "estate_portal";
$user = "root";
$pass = "N3xtk3v!n05"; // Replace with your password



// Connection to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}




// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("All fields required.");
    }

    // Query the residents table by email
    $stmt = $pdo->prepare("SELECT * FROM residents WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $resident = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resident && password_verify($password, $resident['password'])) {
        // Successful login
        $_SESSION['resident_name'] = $resident['name'];
        $_SESSION['resident_role'] = $resident['role'];

        // Redirect based on role
        if ($resident["role"] === "admin") {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/user_dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>















































<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "estate_portal";
$user = "root";
$pass = "N3xtk3v!n05"; // Replace with your password

// Connect to database
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }

    // Query the residents table by email
    $stmt = $pdo->prepare("SELECT * FROM residents WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $resident = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resident && password_verify($password, $resident['pass_word'])) {
        // Successful login
        $_SESSION['resident_id'] = $resident['id'];
        $_SESSION['resident_name'] = $resident['name'];
        $_SESSION['resident_role'] = $resident['role'];

        echo "✅ Login successful! Welcome, " . htmlspecialchars($resident['name']) . ".<br>";
        echo "🔐 Role: " . htmlspecialchars($resident['role']);
        // Redirect or show dashboard link
        // header("Location: dashboard.php");
        exit;
    } else {
        echo "❌ Invalid email or password.";
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
                <label for="email">Username</label>
                <input type="email" id="email" name="email" required>
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













<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "estate_portal";
$user = "root";
$pass = "N3xtk3v!n05"; // Replace with your password



// Connection to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}




// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("All fields required.");
    }

    // Query the residents table by email
    $stmt = $pdo->prepare("SELECT * FROM residents WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $resident = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resident && password_verify($password, $resident['password'])) {
        // Successful login
        $_SESSION['resident_name'] = $resident['name'];
        $_SESSION['resident_role'] = $resident['role'];

        // Redirect based on role
        if ($resident["role"] === "admin") {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/user_dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
