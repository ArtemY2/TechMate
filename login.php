<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM member WHERE login = '%s'",
        $mysqli->real_escape_string($_POST["login"]));
    
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    
    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        } else {
            $is_invalid = true;
        }
    } else {
        $is_invalid = true;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <script>
        const validation = new JustValidate("#login");

        validation
          .addField("#login", [
            {
              rule: "required",
              errorMessage: "Please enter your login"
            },
            {
              rule: "minLength",
              value: 5,
              errorMessage: "Login should be at least 5 characters long"
            },
            {
              rule: "maxLength",
              value: 15,
              errorMessage: "Login should not exceed 15 characters"
            }
          ])
          .addField("#password", [
            {
              rule: "required",
              errorMessage: "Please enter your password"
            },
            {
              rule: "minLength",
              value: 8,
              errorMessage: "Password should be at least 8 characters long"
            },
            {
              rule: "maxLength",
              value: 20,
              errorMessage: "Password should not exceed 20 characters"
            }
          ])
          .onSuccess((event) => {
            document.getElementById("login").submit();
          });
    </script>
    <style>
        form {
            margin: 10px auto;
            width: 500px;
            border: 2px solid #ccc;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
        }
        
        input {
            display: block;
            border: 2px solid #ccc;
            width: 95%;
            padding: 10px;
            border-radius: 5px;
        }
        label {
            color: #888;
            font-size: 18px;
            padding: 10px;
        }
        
        button {
            float: right;
            background: #68EBD3;
            padding: 10px 15px;
            color: #fff;
            border-radius: 5px;
            margin-right: 10px;
            border: none;
            cursor: pointer;
        }
        
        button:hover{
            opacity: .7;
        }
        .error {
            background: #F2DEDE;
            color: #A94442;
            padding: 10px;
            width: 500px;
            border-radius: 5px;
            margin: auto auto;
        }
    
        .success {
            background: #D4EDDA;
            color: #40754C;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
            margin: 20px auto;
        }
    
        h1 {
            text-align: center;
            color: #050404;
        }
    
        
        .ca {
            font-size: 14px;
            display: inline-block;
            padding: 10px;
            text-decoration: none;
        }
        .ca:hover {
            color: #68EBD3;
        } 
    
        *{
            font-family: sans-serif;
            box-sizing: border-box;
        }
        .logo{
            padding: 30px;
        }
    
    </style>
</head>
<body>



<a href="index.php" class="logo"><h1>TechMate</h1></a>

    <?php if ($is_invalid): ?>
        <p class="error">Invalid login or password</p>
    <?php endif; ?>

<form method="post" id="login">
    <h1>Login</h1>
    
    <label for="login">Login <span class="required">*</span></label>
    <input type="text" name="login" id="login" value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '' ?>" required>
    
    <label for="password">Password <span class="required">*</span></label>
    <input type="password" name="password" id="password" required><br>
    
    <button type="submit">Log in</button>
    New to TechMate? <a href="signup.html" class="ca">Create an account.</a>
</form>

    
</body>
</html>

