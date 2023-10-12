<?php
require_once "../session.php";
$mysqli = require __DIR__ . '/../database.php';

$name = $description = $price = $type = $discount = $image = "";
$error = "";
$successMessage = "";

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
        $insertSql = "INSERT INTO products (name, description, price, type, discount, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insertSql);
        $stmt->bind_param("ssdsss", $name, $description, $price, $type, $discount, $image);

        if ($stmt->execute()) {
            $successMessage = "Product was added successfully!";
        } else {
            $error = "Failed to add the product. Please try again.";
        }
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../admin/style/add-product.css">
</head>
<body>
<div class="container">
    <?php include 'admin-sidebar.php'; ?>
    <div class="add-product">
        <h1>Add Product</h1>
        <?php
        if (!empty($successMessage)) {
            echo '<div class="success">' . $successMessage . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type">
                    <option value="audio">Audio</option>
                    <option value="phone">Phone</option>
                    <option value="computer">Computer</option>
                    <option value="mobile">Mobile</option>
                    <option value="televisor">Televisor</option>
                </select>
            </div>
            <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="text" id="discount" name="discount" value="<?php echo htmlspecialchars($discount); ?>">
            </div>
            <div class="form-group">
                <label for="image">Image URL:</label>
                <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($image); ?>">
            </div>
            <div class="form-group">
                <input type="submit" value="Add Product">
            </div>
            <?php if (!empty($error)) : ?>
<div class="error"><?php echo $error; ?></div>
<?php endif; ?>

        </form>
    </div>
</div>
</body>
</html>