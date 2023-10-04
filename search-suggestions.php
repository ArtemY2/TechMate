<?php
$mysqli = require './database.php';

$searchQuery = $_GET['query'];

$sql = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['description'] . "</p>";
        echo "</div>";
    }
} else {
    echo "No suggestions found.";
}

$mysqli->close();
?>
