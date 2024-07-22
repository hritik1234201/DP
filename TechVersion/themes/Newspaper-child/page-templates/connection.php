<?php
date_default_timezone_set('Asia/Kolkata');

$servername = "localhost";
$username = "root";
$password = "tieglobal1974";
$dbname = "techversions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>