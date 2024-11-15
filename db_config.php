<?php
$servername = "localhost";  // Database server (localhost if it's running locally)
$username = "root";         // Database username (usually "root" for local)
$password = "";             // Database password (usually empty for local development)
$dbname = "hall_management_system";  // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
