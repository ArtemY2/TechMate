<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/admin_header.css">
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
                        <div class="login">
                            <i class="fa fa-user"></i>
                            <?php if (isset($user)): ?>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <p>Hello Admin: <?= htmlspecialchars($user["name"]) ?></p>
                                    <p><a href="logout.php" class="logout-link">Log out</a></p>
                                <?php else: ?>
                                    <p>Hello <?= htmlspecialchars($user["name"]) ?></p>
                                    <p><a href="logout.php" class="logout-link">Log out</a></p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p><a href="login.php" class="login-link">Log in</a> or <a href="signup.html" class="register-link">Sign up</a></p>
                            <?php endif; ?>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </header>
