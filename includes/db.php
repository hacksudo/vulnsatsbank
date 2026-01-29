<?php
// includes/db.php

$host     = "db";       // MySQL service name in docker-compose.yml
$username = "root";     // MySQL user
$password = "root";     // MySQL password
$database = "vulnbank"; // Database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
