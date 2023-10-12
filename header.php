<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/header.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<title>TechMate</title>
<body>
    <div class="page">
        <header class="header">
            <div class="container">
                <div class="header_logo">
                    <a href="index.php" class="logo">TechMate</a>
                    <div class="nav">
                    <form class="search-form" action="search.php" method="GET">
                        <input class="search-form_txt" type="text" name="query" placeholder="Search...">
                        <button class="search-form_btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                        <div class="login">
                            <i class="fa fa-user"></i>
                            <?php if (isset($user)): ?>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <p>Hello Admin: <?= htmlspecialchars($user["name"]) ?></p>
                                    <p><a href="logout.php" class="logout-link">Log out</a></p>
                                    <p><a href="admin/admin_panel.php" class="add-product-link">Admin Panel</a></p>
                                <?php else: ?>
                                    <p>Hello <?= htmlspecialchars($user["name"]) ?></p>
                                    <p><a href="logout.php" class="logout-link">Log out</a></p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p><a href="login.php" class="login-link">Log in</a> or <a href="signup.html" class="register-link">Sign up</a></p>
                            <?php endif; ?>
                        </div>
                        <div class="cart">
                            <a href="cart.php" class="fa fa-shopping-cart"></a>
                            <?php
                            $mysqli = require __DIR__ . "/database.php";
                            $userId = isset($user) ? $user['id'] : 0;
                            $countSql = "SELECT COUNT(*) AS count FROM cart WHERE user_id = $userId";
                            $countResult = $mysqli->query($countSql);

                            if ($countResult && $countResult->num_rows > 0) {
                                $cartCount = $countResult->fetch_assoc()['count'];

                                if ($cartCount > 0) {
                                    echo "<span class='cart-count'>$cartCount</span>";
                                }
                            }

                            $mysqli->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_ght"></div>
            <nav class="navbar">
                <a href="sale.php">Sale</a>
                <a href="shopall.php">Shop all</a>
                <a href="computer.php">Computer</a>
                <a href="phone.php">Phone</a>
                <a href="audio.php">Audio</a>
                <a href="tv.php">T.V & Home Cinema</a>
            </nav>
        </header>
