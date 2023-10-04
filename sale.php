<?php
require_once "session.php";
?>


<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/prod_style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Sale</h2><br>
        <div class="new">    
            <?php
            $_GET['type'] = 'sale';
            include 'products.php';
            ?>
        </div>
    </main>
    <footer>
        <hr>
        <p>TechMate</p>
    </footer>
</body>
</html>
