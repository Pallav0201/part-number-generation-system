<?php
$server = "localhost";   // Your database server (usually 'localhost')
$username = "root";      // Your database username
$password = " ";        // Your database password
$database = "users22"; // Your database name

// Establishing the connection to the database
$conn = mysqli_connect($server, $username, $password, $database);


// Checking the connection
if (!$conn) {
    die("Error: " . mysqli_connect_error()); // Display connection error if it fails
}
?>
