<?php
$mysqli = require __DIR__ . "/database.php";
require_once "session.php";

$productId = $_POST['product_id'] ?? null;
$userId = isset($user) ? $user['id'] : 0;

if (!$productId) {
    exit("Item ID not specified.");
}

$sql = "SELECT * FROM products WHERE id = $productId";
$result = $mysqli->query($sql);

if ($result->num_rows == 0) {
    exit("Product not found.");
}

$product = $result->fetch_assoc();

$insertSql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, 1)";
$mysqli->query($insertSql);

header("Location: cart.php");
exit();
?>
