<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentresults";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
