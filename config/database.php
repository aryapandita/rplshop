<?php
// config/database.php

$host = 'localhost';
$db   = 'rplshop';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
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
     // Don't leak DB credentials in case of failure, output simple message
     die("Connection failed: Please check if MySQL is running in XAMPP and database 'rplshop' has been imported.");
}

// Start PHP session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
