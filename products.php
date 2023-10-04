<?php
$mysqli = require __DIR__ . "/database.php";
require_once "session.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        header("Location: cart.php");
        exit();
    }
}

$type = $_GET['type'] ?? 'all';
$order = $_GET['order'] ?? 'name';

$sql = "SELECT * FROM products";

if ($type === 'televisor') {
    $sql .= " WHERE type = 'televisor'";
} elseif ($type === 'phone') {
    $sql .= " WHERE type = 'phone'";
} elseif ($type === 'computer') {
    $sql .= " WHERE type = 'computer'"; 
} elseif ($type === 'audio') {
    $sql .= " WHERE type = 'audio'"; 
} elseif ($type === 'sale') {
    $sql .= " WHERE discount > 0";
}

$sql .= " ORDER BY $order ASC";

$products = [];
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$mysqli->close();
?>

<html>
<head>
    <style>
        .parentBox {
            position: relative;
        }

        .sale-marker {
            position: absolute;
            top: 5px;
            left: 5px;
            background-color: red;
            color: white;
            padding: 5px;
        }

        .wish-button {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 40px;
            height: 40px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .wish-button svg {
            width: 100%;
            height: 100%;
            fill: #ccc;
        }

        .wish-button.added-to-wishlist svg {
            fill: red;
        }

        .f1, .f2, .f3 {
            margin: 0;
        }

        .buy-button, .add-to-cart-button {
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="style/prod_style.css">
    <script>
    function addToFavorites(productId) {
        var formData = new FormData();
        formData.append('product_id', productId);

        fetch('add_to_favorites.php', {
            method: 'POST',
            body: formData
        }).then(function(response) {
            if (response.ok) {
                var wishButton = document.querySelector('.js-wish-button[data-product-id="' + productId + '"]');
                wishButton.classList.add('added-to-wishlist');
                wishButton.setAttribute('aria-label', 'Remove from favorites');
                localStorage.setItem('favorite_' + productId, 'true'); 
            } else {
                console.error('Error when adding product to favorites');
            }
        }).catch(function(error) {
            console.error('ERROR:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.wishlist-form').forEach(function(form) {
            var productId = form.dataset.productId; 
            var wishButton = form.querySelector('.js-wish-button');

            if (localStorage.getItem('favorite_' + productId) === 'true') {
                wishButton.classList.add('added-to-wishlist');
                wishButton.setAttribute('aria-label', 'Remove from favorites');
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                }).then(function(response) {
                    if (response.ok) {
                        wishButton.classList.add('added-to-wishlist');
                        wishButton.setAttribute('aria-label', 'Remove from favorites');
                        localStorage.setItem('favorite_' + productId, 'true');
                    } else {
                        console.error('Error when adding product to favorites');
                    }
                }).catch(function(error) {
                    console.error('ERROR:', error);
                });
            });
        });
    });
</script>

</head>
<body>
<?php foreach ($products as $product): ?>
    <div class="parentBox">
        <?php if ($product['discount'] > 0): ?>
            <div class="sale-marker">SALE <?php echo number_format($product['discount'], 0, '.', ','); ?>%</div>
        <?php endif; ?>
        <a href="product.php?id=<?php echo $product['id']; ?>">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        </a>
        <h3><a href="product.php?id=<?php echo $product['id']; ?>" style="text-decoration: none; color: inherit;"><?php echo $product['name']; ?></a></h3>
        <p class="f1"><?php echo $product['description']; ?></p>
        <form class="wishlist-form" action="add_to_favorites.php" method="POST" data-product-id="<?php echo $product['id']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="wish-button js-wish-button" aria-label="Add to favorite">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.131l2.965 5.77L20 9.5l-4.75 4.619.965 5.61L12 17.347l-5.215 2.782.965-5.61L4 9.5l5.035.401L12 4.131z" />
                </svg>
            </button>

        </form>
        <?php if ($product['discount'] > 0): ?>
            <p class="f2">
                <del><?php echo number_format($product['price'], 0, '.', ','); ?>원</del>
            </p>
            <p class="f3">
                <?php echo number_format($product['price'] * (1 - $product['discount'] / 100), 0, '.', ','); ?>원
            </p>
        <?php else: ?>
            <p class="f2"><?php echo number_format($product['price'], 0, '.', ','); ?>원</p>
        <?php endif; ?>
        <a href="product.php?id=<?php echo $product['id']; ?>">
            <button class="buy-button">Buy</button>
        </a>
    </div>
<?php endforeach; ?>
</body>

</html>
