<?php
session_start();
$response = ['loggedIn' => false];

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $response['loggedIn'] = true;
    $response['username'] = $_SESSION['username'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
