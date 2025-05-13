

<?php
session_start();
session_destroy(); // Destroy all session data

// Prevent the browser from caching logged-in pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

// Redirect to login page
header("Location: ../views/login.php");
exit();
