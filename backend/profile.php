<?php
session_start();

// DB connection
$servername = "localhost";
$username = "root";
$password = "Kani@2003";
$dbname = "shopping_db";
$conn = new mysqli($servername, $username, $password, $dbname);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT username, email, address, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $address, $profile_image);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
