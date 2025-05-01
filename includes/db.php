<?php
$host = '127.0.0.1';
$db   = 'estate_portal';
$user = 'root';
$pass = 'N3xtk3v!n05'; // Replace with your password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>


<?php
$host = 'localhost'; // MySQL host
$username = 'root';  // Database username
$password = 'your_password'; // Password for root user (if set)
$dbname = 'your_database_name'; // Database name

// Using PDO for MySQL connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "DB connection failed: " . $e->getMessage();
}
?>
