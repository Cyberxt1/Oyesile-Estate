<?php
require_once '../config/db.php'; // Or wherever your DB connection file is

try {
    $stmt = $pdo->prepare("SELECT * FROM residents ORDER BY id DESC");
    $stmt->execute();
    $residents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching residents: " . $e->getMessage());
}
?>
