<?php
session_start();
$conn = new mysqli("localhost", "root", "Kani@2003", "shopping_db");

$data = json_decode(file_get_contents("php://input"), true);
$name = $conn->real_escape_string($data['username']);
$email = $conn->real_escape_string($data['email']);
$address = $conn->real_escape_string($data['address']);
$user_id = $_SESSION['user_id'];

$conn->query("UPDATE users SET username='$name', email='$email', address='$address' WHERE id=$user_id");

echo "Profile updated successfully.";
