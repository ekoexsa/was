<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP/local password is empty

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS prayer_app";
if ($conn->query($sql) === TRUE) {
  echo "Database 'prayer_app' created successfully or already exists.\n";
} else {
  echo "Error creating database: " . $conn->error . "\n";
}

// Select the database
$conn->select_db("prayer_app");

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS settings (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table 'settings' created successfully or already exists.\n";
} else {
  echo "Error creating table: " . $conn->error . "\n";
}

// Check if default data exists
$result = $conn->query("SELECT * FROM settings WHERE setting_key = 'city'");
if ($result->num_rows == 0) {
    // Insert default data
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('city', 'New York')");
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('country', 'USA')");
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('fajr_adjustment', '0')");
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('dhuhr_adjustment', '0')");
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('asr_adjustment', '0')");
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('maghrib_adjustment', '0')");
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('isha_adjustment', '0')");
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('theme', 'light')");
    echo "Default data inserted into 'settings' table.\n";
}

$conn->close();
?>