<?php
require_once "session.php";
require_once "update_cart.php";
$mysqli = require __DIR__ . "/database.php";


$userId = isset($user) ? $user['id'] : 0;
$sql = "SELECT cart.id, products.id AS product_id, products.name, products.price, cart.quantity FROM cart
        INNER JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $userId";
$result = $mysqli->query($sql);

if ($result) {
    $cartProducts = $result->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_product_id'])) {
        $productId = $_POST['remove_product_id'];

        $deleteSql = "DELETE FROM cart WHERE id = $productId AND user_id = $userId";
        $mysqli->query($deleteSql);

        header("Location: cart.php");
        exit();
    } elseif (isset($_POST['update_product_id']) && isset($_POST['update_quantity'])) {
        $productId = $_POST['update_product_id'];
        $quantity = $_POST['update_quantity'];

        $updateSql = "UPDATE cart SET quantity = $quantity WHERE id = $productId AND user_id = $userId";
        $mysqli->query($updateSql);

        header("Location: cart.php");
        exit();
    } elseif (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['payment'])) {

        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $payment = $_POST['payment'];

        header("Location: order_confirmation.php");
        exit();
    }
}

function calculateTotal($cartProducts) {
    $total = 0;
    foreach ($cartProducts as $cartProduct) {
        $total += $cartProduct['price'] * $cartProduct['quantity'];
    }
    return $total;
}
?>

<html>
<head>
    <link rel="stylesheet" href="style/cart.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.quantity-input').on('input', function() {
                var productId = $(this).data('product-id');
                var quantity = $(this).val();

                $.ajax({
                    url: 'update_cart.php',
                    method: 'POST',
                    data: {
                        update_product_id: productId,
                        update_quantity: quantity
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <style>
        
.checkout-section {
        margin-top: 20px;
    }

    .checkout-section h2 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .checkout-section form {
        display: flex;
        flex-direction: column;
        width: 300px;
    }

    .checkout-section label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .checkout-section input,
    .checkout-section select {
        padding: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 14px;
    }

    .checkout-section button {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .checkout-section button:hover {
        background-color: #45a049;
    }

    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <table class="cart_main">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php if (!empty($cartProducts)): ?>
                <?php foreach ($cartProducts as $cartProduct): ?>
                    <tr>
                        <td><a href="product.php?id=<?php echo $cartProduct['product_id']; ?>"><?php echo $cartProduct['name']; ?></a></td>
                        <td><?php echo number_format($cartProduct['price'], 0, ',', ','); ?></td>
                        <td>
                            <input type="number" class="quantity-input" min="1" value="<?php echo $cartProduct['quantity']; ?>" data-product-id="<?php echo $cartProduct['id']; ?>" name="update_quantity">
                        </td>
                        <td><?php echo number_format($cartProduct['price'] * $cartProduct['quantity'], 0, ',', ','); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="remove_product_id" value="<?php echo $cartProduct['id']; ?>">
                                <button type="submit" class="remove-from-cart-button">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-message">Your cart is empty</td>
                </tr>
            <?php endif; ?>
            <tr class="total-row">
                <td colspan="3"></td>
                <td><?php echo number_format(calculateTotal($cartProducts), 0, ',', ','); ?></td>
                <td></td>
            </tr>
        </table>

        <div class="checkout-section">
            <h2>Checkout</h2>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="payment">Payment Method:</label>
                <select id="payment" name="payment" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="cash">Cash on Delivery</option>
                </select>

                <button type="submit">Place Order</button>
            </form>
        </div>
    </main>
</body>
</html>
