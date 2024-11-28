<?php
$server = "localhost"; // Database server (e.g., localhost)
$username = "root"; // Database username
$password = ""; // Database password
$database = "users22"; // Your database name

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
