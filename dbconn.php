<!-- dbconn.php -->
<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "inventorythree";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Can't connect: " . $conn->connect_error);
}

?> 