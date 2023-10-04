<?php

$host = "localhost";
$dbname = "techmate";
$username = "techmate";
$password = "wjqthr12!";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;

?>
