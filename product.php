<?php
$mysqli = require __DIR__ . "/database.php";
require_once "session.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    exit("Item ID not specified.");
}

$sql = "SELECT * FROM products WHERE id = $id";
$result = $mysqli->query($sql);

if ($result->num_rows == 0) {
    exit("Product not found.");
}

$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buy'])) {
        $userId = isset($user) ? $user['id'] : 0;
        $productId = $product['id'];
        $quantity = 1; 
        $checkSql = "SELECT * FROM cart WHERE user_id = $userId AND product_id = $productId";
        $checkResult = $mysqli->query($checkSql);
        if ($checkResult->num_rows > 0) {
            $updateSql = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $userId AND product_id = $productId";
            $mysqli->query($updateSql);
        } else {
            $insertSql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, $quantity)";
            $mysqli->query($insertSql);
        }

        header("Location: cart.php");
        exit();
    }
}

$mysqli->close();
?>

<html>
<head>
    <link rel="stylesheet" href="style\prod2_style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="product2-page">
        <?php if ($product['discount'] > 0): ?>
        <div class="sale-marker">SALE<br> <?php echo number_format($product['discount'], 0, '.', ','); ?>%</div>
        <?php endif; ?>
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <div class="product2-details">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <?php if ($product['discount'] > 0): ?>
                    <p class="price">Price: <del><?php echo number_format($product['price'], 0, '.', ','); ?>원.</del></p>
                    <p class="price">Discount price: <?php echo number_format($product['price'] * (1 - $product['discount'] / 100), 0, '.', ','); ?>원.</p>
                <?php else: ?>
                    <p class="price">Price: <?php echo number_format($product['price'], 0, '.', ','); ?>원.</p>
                <?php endif; ?>
                <form action="add_to_cart.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <button type="submit" class="buy-button">Buy</button>
</form>

            </div>
        </div>
    </main>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
