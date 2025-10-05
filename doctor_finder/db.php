<?php
// db.php

$host = "localhost";
$user = "root";           // Default XAMPP username
$password = "";           // Default XAMPP password is empty
$database = "doctor_finder"; // Make sure this DB exists in phpMyAdmin

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
