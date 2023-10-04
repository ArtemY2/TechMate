<?php

$mysqli = require __DIR__ . "/database.php";

$imageId = $_GET['id'];

$sql = "SELECT image FROM products WHERE id = '$imageId'";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    header("Content-Type: image/jpeg"); 
    echo $row['image'];
} else {
    echo "Image not found.";
}

?>
