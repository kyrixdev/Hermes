<?php
// Database configuration
$dbHost     = "66.11.118.4";
$dbUsername = "kyrixserver";
$dbPassword = "Test123!!";
$dbName     = "hermes";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>