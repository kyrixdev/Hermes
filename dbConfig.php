<?php
// Database configuration
<<<<<<< HEAD
$dbHost     = "66.11.118.4";
$dbUsername = "kyrixserver";
$dbPassword = "Test123!!";
=======
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "Kefikefi12";
>>>>>>> e665a55d2383eeccd2f52b18f956be931cba63ee
$dbName     = "hermes";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>