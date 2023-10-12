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
<html>
 <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
    <style>
        

    .tekst_sverhu_kartinki {
     position: absolute;
     top: 20;
     left: 6px;
     text-transform: uppercase;
     color: white;
     width: 170px;
     padding: 10px;
     text-align: center;
     font: bold 12px/17px Marcellus;
}
.btn {
    background-color: #68EBD3;
    position: absolute;
    top: 135px;
    left: 44px;
    text-transform: uppercase;
    color: white;
    width: 87;
    height: 38;
    border-radius: 23%;
    padding: 14px;
    text-align: center;
    font: bold 10px/10px Marcellus;
}
        
        </style>
 </head>
 <title>TechMate</title>
 <body>
    <div class="page">
    
    <?php include 'header.php'; ?>
    <main>
    <div class="page2">
        <div id="tekst_sverhu_kartinki">
            <img src="front.png" class="imgfront" >
            <div class="tekst_sverhu_kartinki">Incredible<br>Prices on All Your Favorite Items</div>
            <a href="shopall.php" class="btn">Shop now</a>
        </div>
    </div>
    <div class="page3">
        <a href="phone.php"><img src="image/iphone.png" class="iphone"></a>
        <a href="computer.php"><img src="image/mac .png" class="mac"></a>
    </div>
    <div class="page4">
        <img src="image/garant.png" class="grant">
    </div>
    <div class="page5">
        <img src="image/shopcap.png" class="shopcap">
    </div>
    </div>
    </main>
    <footer>
    <?php include 'footer.php'; ?>
    </footer>
<table>
</table>
 </body>
 </html>