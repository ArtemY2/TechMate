<?php
require_once "../session.php";
$mysqli = require __DIR__ . '/../database.php';

$error = "";

$selectSql = "SELECT * FROM products";
$productsResult = $mysqli->query($selectSql);

if (!$productsResult) {
    $error = "Failed to fetch products. Please try again.";
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $error = "The product ID is missing.";
} else {
    $productId = $_GET['id'];

    $selectProductSql = "SELECT * FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($selectProductSql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $error = "Product not found.";
    } else {
        $product = $result->fetch_assoc();

        $id = $product['id'];
        $name = $product['name'];
        $description = $product['description'];
        $price = $product['price'];
        $type = $product['type'];
        $created_at = $product['created_at'];
        $discount = $product['discount'];
        $image = $product['image'];

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
<?php include 'modal.php'; ?>
<script>
    function openModal(id, name, description, price, type, discount, image) {
        var editModal = document.getElementById("editModal");
        var editForm = document.getElementById("editForm");
        var editProductId = document.getElementById("editProductId");
        var editName = document.getElementById("editName");
        var editDescription = document.getElementById("editDescription");
        var editPrice = document.getElementById("editPrice");
        var editType = document.getElementById("editType");
        var editDiscount = document.getElementById("editDiscount");
        var editImage = document.getElementById("editImage");

        editProductId.value = id;
        editName.value = name;
        editDescription.value = description;
        editPrice.value = price;
        editType.value = type;
        editDiscount.value = discount;
        editImage.value = image;

        editModal.style.display = "block";

        editForm.onsubmit = function (event) {
            event.preventDefault();

        };
    }

    function closeModal() {
        var editModal = document.getElementById("editModal");
        editModal.style.display = "none";
    }
</script>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="./style/edit-product.css">
    <link rel="stylesheet" href="./style/modal.css">
</head>
<body>
    <div class="container">
    <?php include 'admin-sidebar.php'; ?>
        <div class="edit-product">
            <h1>Edit Product</h1>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php else: ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $productId; ?>" method="POST">
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
                            <option value="audio" <?php if ($type === 'audio') echo 'selected'; ?>>Audio</option>
                            <option value="phone" <?php if ($type === 'phone') echo 'selected'; ?>>Phone</option>
                            <option value="computer" <?php if ($type === 'computer') echo 'selected'; ?>>Computer</option>
                            <option value="televisor" <?php if ($type === 'televisor') echo 'selected'; ?>>Televisor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Created At:</label>
                        <input type="text" id="created_at" name="created_at" value="<?php echo htmlspecialchars($created_at); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount:</label>
                        <input type="text" id="discount" name="discount" value="<?php echo htmlspecialchars($discount); ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($image); ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update product">
                    </div>
                </form>
            <?php endif; ?>
            <div class="product-list">
                <h2>Product List:</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($productRow = $productsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $productRow['id']; ?></td>
                                <td><?php echo $productRow['name']; ?></td>
                                <td><?php echo $productRow['description']; ?></td>
                                <td><?php echo $productRow['price']; ?></td>
                                <td><?php echo $productRow['type']; ?></td>
                                <td><?php echo $productRow['created_at']; ?></td>
                                <td><?php echo $productRow['discount']; ?></td>
                                <td>
                                    <button onclick="openModal('<?php echo $productRow['id']; ?>', '<?php echo htmlspecialchars($productRow['name']); ?>', '<?php echo htmlspecialchars($productRow['description']); ?>', '<?php echo $productRow['price']; ?>', '<?php echo $productRow['type']; ?>', '<?php echo $productRow['discount']; ?>', '<?php echo $productRow['image']; ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php include 'modal.php'; ?>
        </div>
    </div>
</body>
</html>
