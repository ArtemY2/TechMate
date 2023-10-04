<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $waterLevel = $_POST['waterLevel'];


    echo 'Данные успешно получены и обработаны.';
} else {
    echo 'Неверный метод запроса.';
}
?>
