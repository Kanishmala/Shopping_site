<?php
session_start();

// DB connection settings
$servername = "localhost";
$username = "root";
$password = "Kani@2003";
$dbname = "shopping_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input helper
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$userInput = sanitize($_POST['username'] ?? '');
$passInput = $_POST['password'] ?? '';

if (!$userInput || !$passInput) {
    echo "Please fill all the fields.";
    exit;
}

// Prepare SQL to fetch user by username OR email
$stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $userInput, $userInput);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();

if (password_verify($passInput, $user['password'])) {
    // Login success, save user info in session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    echo "success";
} else {
    echo "Invalid password.";
}

$stmt->close();
$conn->close();
?>
