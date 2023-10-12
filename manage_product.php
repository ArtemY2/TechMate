<!DOCTYPE html>
<html>
<head>
    <title>Edit Panel</title>
    <link rel="stylesheet" href="style/admin_panel.css">
<!DOCTYPE html>
<html>
<head>
    <title>Edit Panel</title>
    <link rel="stylesheet" href="style/admin_panel.css">
    
</head>
<body>
<?php include 'sidebar.php'; ?>
        <?php
        require_once "session.php";
        $mysqli = require __DIR__ . '/database.php';

        $error = "";

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
                    header("Location: admin_panel.php");
                    exit();
                } else {
                    $error = "Failed to add the product. Please try again.";
                }
            }
        }

        $sql = "SELECT * FROM products";
        $result = $mysqli->query($sql);

        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        $mysqli->close();
        ?>


        <main>
            <div class="admin-panel">
                <h1>Manage Products</h1>

                <a href="add_product.php">Add New Product</a>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['description']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                                <a href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </main>
</body>
</html>
