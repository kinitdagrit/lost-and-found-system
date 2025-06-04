<?php
// db.php

$host = 'localhost';
$user = 'root';       // Default user in XAMPP
$pass = '';           // Empty if not set
$dbname = 'lost_and_found';

// Enable error reporting for debugging (remove or disable in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create a new MySQLi connection
    $conn = new mysqli($host, $user, $pass, $dbname);
    
    // Set proper character encoding
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    // Catch any errors and stop script
    die("Database connection failed: " . $e->getMessage());
}
?>
