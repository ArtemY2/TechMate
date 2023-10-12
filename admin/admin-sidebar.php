<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./style/admin-sidebar.css">
    <script>
        function toggleSubMenu(event) {
  const listItem = event.target.parentElement;
  const subMenu = listItem.querySelector('.sub-menu');
  subMenu.style.display = subMenu.style.display === 'block' ? 'none' : 'block';
}

function hideSubMenu(event) {
  const listItem = event.target.parentElement;
  const subMenu = listItem.querySelector('.sub-menu');
  subMenu.style.display = 'none';
}

    </script>
</head>
<body>
    <div class="admin-panel">
        <div class="sidebar" id="sidebar">
            <h1><a href="/html/index.php">TechAdmin</a></h1>
            <ul>
                <li onclick="toggleSubMenu(event)"><a href="#"><i class="fas fa-box-open box-icon"></i>Product Manage</a>
                    <ul class="sub-menu">
                        <li><a href="add-product.php"><i class="fas fa-plus"></i> Add Product</a></li>
                        <li><a href="edit-product.php"><i class="far fa-edit"></i> Edit Product</a></li>
                    </ul>
                </li>
                <li onclick="toggleSubMenu(event)"><a href="#"><i class="fas fa-users"></i> User Manage</a>
                    <ul class="sub-menu">
                        <li><a href="#"><i class="fas fa-user-plus"></i> Add User</a></li>
                        <li><a href="#"><i class="fas fa-user-edit"></i> Edit User</a></li>
                        <li><a href="#"><i class="fas fa-user-slash"></i> Delete User</a></li>
                    </ul>
                </li>
                <li onclick="toggleSubMenu(event)"><a href="#"><i class="fas fa-cubes"></i> Inventory Manage</a>
                    <ul class="sub-menu">
                        <li><a href="#"><i class="fas fa-shopping-cart"></i> Manage Stock</a></li>
                        <li><a href="#"><i class="fas fa-exchange-alt"></i> Update Inventory</a></li>
                        <li><a href="#"><i class="fas fa-chart-bar"></i> Sales Report</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fas fa-star"></i> Reviews and Ratings</a></li>
                <li><a href="#"><i class="fas fa-bullhorn"></i> Marketing Tools</a></li>
                <li><a href="#"><i class="fas fa-undo"></i> Returns and Exchanges</a></li>
                <li><a href="#"><i class="fas fa-globe"></i> International Shipping</a></li>
                <li><a href="#"><i class="fas fa-language"></i> Multilingual Support</a></li>
                <li><a href="#"><i class="fab fa-facebook"></i> Social Media Integration</a></li>
                <li><a href="#"><i class="fas fa-shield-alt"></i> Security Management</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
