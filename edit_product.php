<?php
require_once "session.php";
$mysqli = require __DIR__ . '/database.php';

$error = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $error = "The product ID is missing.";
} else {
    $productId = $_GET['id'];

    $selectSql = "SELECT * FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($selectSql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $error = "Продукт не найден.";
    } else {
        $product = $result->fetch_assoc();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST["name"]);
            $description = trim($_POST["description"]);
            $price = trim($_POST["price"]);
            $type = $_POST["type"];
            $discount = trim($_POST["discount"]);
            $image = trim($_POST["image"]);

            if (empty($name) || empty($description) || empty($price) || empty($type)) {
                $error = "All fields are required.";
            } else {
                $updateSql = "UPDATE products SET name = ?, description = ?, price = ?, type = ?, discount = ?, image = ? WHERE id = ?";
                $stmt = $mysqli->prepare($updateSql);
                $stmt->bind_param("ssdsssi", $name, $description, $price, $type, $discount, $image, $productId);

                if ($stmt->execute()) {

                    header("Location: admin_panel.php");
                    exit();
                } else {
                    $error = "Failed to update product. Please try again.";
                }
            }
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style/edit_product.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="edit-product">
            <h1>Edit Product</h1>

            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php else: ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $productId; ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select id="type" name="type">
                            <option value="audio" <?php if ($product['type'] === 'audio') echo 'selected'; ?>>Audio</option>
                            <option value="phone" <?php if ($product['type'] === 'phone') echo 'selected'; ?>>Phone</option>
                            <option value="computer" <?php if ($product['type'] === 'computer') echo 'selected'; ?>>Computer</option>
                            <option value="televisor" <?php if ($product['type'] === 'televisor') echo 'selected'; ?>>Televisor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount:</label>
                        <input type="text" id="discount" name="discount" value="<?php echo htmlspecialchars($product['discount']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update product">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
