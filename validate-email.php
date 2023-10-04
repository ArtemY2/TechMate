<?php

$mysqli = require __DIR__ . "/database.php";

$email = $_GET["email"];
$email = $mysqli->real_escape_string($email);

$sql = "SELECT * FROM member WHERE email = '$email'";
$result = $mysqli->query($sql);

$is_available = $result->num_rows === 0;

header("Content-Type: application/json");

echo json_encode(["available" => $is_available]);

?>
