<?php
// Start session (optional, useful later for login sessions)
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";       // your MySQL username
$password = "Kani@2003";           // your MySQL password
$dbname = "shopping_db"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function to sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Get POST data and sanitize
$user = sanitize($_POST['username'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';

// Validate required fields
if (!$user || !$email || !$pass) {
    echo "Please fill all the required fields.";
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}

// Check if user/email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $user, $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Username or Email already taken.";
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hash the password securely
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// Insert new user into database
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful! You can now login.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
