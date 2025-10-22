<?php
$host = "localhost";
$user = "root"; // default sa XAMPP
$pass = "";
$db = "ramos_db"; // pangalan ng database mo

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
