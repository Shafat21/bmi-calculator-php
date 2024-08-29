<?php
$host = 'localhost';
$dbname = 'SHAFAT_BMI_PHP_APP';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    // Create the tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS AppUsers (
            AppUserID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(50) NOT NULL UNIQUE,
            Password VARCHAR(255) NOT NULL,  
            CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS BMIUsers (
            BMIUserID INT AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(100) NOT NULL,
            Age INT,
            Sex ENUM('Male', 'Female', 'Other'),
            CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS BMIRecords (
            RecordID INT AUTO_INCREMENT PRIMARY KEY,
            BMIUserID INT,
            Height FLOAT NOT NULL,
            Weight FLOAT NOT NULL,
            BMI FLOAT NOT NULL,
            RecordedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (BMIUserID) REFERENCES BMIUsers(BMIUserID) ON DELETE CASCADE
        );
    ");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
