<?php
require_once "session.php";
$mysqli = require __DIR__ . '/database.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $productId = $_GET["id"];

    $deleteSql = "DELETE FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($deleteSql);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Failed to delete the product. Please try again.";
    }
}

$mysqli->close();
?>
