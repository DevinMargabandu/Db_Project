<?php
// Replace with your actual database credentials
$servername = "localhost"; // Update with your actual server name and port if needed 
$username = "root";
$password = "Amorosy";
$dbname = "university_db"; // Update with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
