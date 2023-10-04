
<?php
require_once "session.php";
$mysqli = require __DIR__ . "/database.php";

$userId = isset($user) ? $user['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product_id']) && isset($_POST['update_quantity'])) {
    $productId = $_POST['update_product_id'];
    $quantity = $_POST['update_quantity'];

    $updateSql = "UPDATE cart SET quantity = $quantity WHERE id = $productId AND user_id = $userId";
    $mysqli->query($updateSql);


}
?>
