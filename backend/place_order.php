<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please login before placing an order.";
    exit;
}

$data = file_get_contents("php://input");
$cart = json_decode($data, true);

if (!$cart || count($cart) === 0) {
    echo "Your cart is empty.";
    exit;
}

include 'db.php'; // make sure this defines $conn = new mysqli(...)

$user_id = $_SESSION['user_id'];
$total_price = 0;

foreach ($cart as $item) {
    $total_price += $item['price'] * $item['qty'];
}

// Insert into orders table
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();

$order_id = $stmt->insert_id;
$stmt->close();

// Insert each item
$item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");

foreach ($cart as $item) {
    $item_stmt->bind_param("isid", $order_id, $item['name'], $item['qty'], $item['price']);
    $item_stmt->execute();
}
$item_stmt->close();

echo "✅ Order placed successfully!";
?>
