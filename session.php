<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM member WHERE id = " . $_SESSION["user_id"];
    $result = $mysqli->query($sql);

    if ($result) {
        $user = $result->fetch_assoc();
    }
}
?>
