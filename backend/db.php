<?php
$host = "localhost";
$user = "root";
$pass = "Kani@2003"; // or your actual password
$dbname = "Shopping_db";  // make sure this database exists

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
