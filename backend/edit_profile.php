<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "Kani@2003";
$dbname = "shopping_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$username = htmlspecialchars(strip_tags($_POST['username']));
$email = htmlspecialchars(strip_tags($_POST['email']));
$address = htmlspecialchars(strip_tags($_POST['address']));

// Optional: validate email format here
$sql = "UPDATE users SET username=?, email=?, address=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $username, $email, $address, $user_id);

if ($stmt->execute()) {
    echo "Profile updated successfully.";
} else {
    echo "Update failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
