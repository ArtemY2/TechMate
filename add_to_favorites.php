<?php
$mysqli = require __DIR__ . "/database.php";
require_once "session.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($user['id'])) {
        $productId = $_POST['product_id'];
        $userId = $user['id'];

        $query = "SELECT * FROM favorite_products WHERE user_id = ? AND product_id = ?";
        
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $deleteQuery = "DELETE FROM favorite_products WHERE user_id = ? AND product_id = ?";
            
            $stmt = $mysqli->prepare($deleteQuery);
            $stmt->bind_param("ii", $userId, $productId);
            $stmt->execute();
        } else {
            $insertQuery = "INSERT INTO favorite_products (user_id, product_id) VALUES (?, ?)";
            
            $stmt = $mysqli->prepare($insertQuery);
            $stmt->bind_param("ii", $userId, $productId);
            $stmt->execute();
        }
        
        $stmt->close();
    }
}

$mysqli->close();

header("Location: products.php");
exit();


?>
