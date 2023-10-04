<?php
require_once "session.php";

if (!isset($user)) {
    header("Location: login.php");
    exit();
}

$productId = $_POST['remove_product_id'] ?? null;
$userId = $user['id'];

if (!$productId) {
    exit("Item ID not specified.");
}

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM cart WHERE user_id = $userId AND product_id = $productId";
$result = $mysqli->query($sql);

if ($result->num_rows == 0) {
    exit("Item not found in cart.");
}

$deleteSql = "DELETE FROM cart WHERE user_id = $userId AND product_id = $productId";
$mysqli->query($deleteSql);

header("Location: cart.php");
exit();
?>
