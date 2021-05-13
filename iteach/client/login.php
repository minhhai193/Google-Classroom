<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>iTech</title>

        <link rel="shortcut icon" type="image/x-icon" href="../img/logo-img.png" sizes="16x16"/>

        <!-- Style CSS -->
        <link rel="stylesheet" href="../style.css">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

        <?php 
            require_once "database.php";
        ?>
    </head>

    <body>
        <?php   
            $code = 0;
            $username = '';
            $password = '';
            $error = '';

            if (isset($_COOKIE["PHPSID"])) {
                $token = $_COOKIE["PHPSID"];

                $conn = connection();

                $sql = "SELECT username FROM account WHERE token='$token'";
                $rows = $conn->query($sql);

                if ($rows->num_rows > 0) {
                    while ($row = $rows->fetch_assoc()) {
                        $username = $row["username"];
                    }
                }
            }

            if (isset($_POST["signin"])) {
                if (isset($_POST["username"]) and isset($_POST["password"])) {
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    if (empty($username)) {
                        $error = "Please enter your username";
                    }
                    else if (empty($password)) {
                        $error = "Please enter your password";
                    }
                    else {
                        if (login($username, $password) == 1) {
                            $error = "Invalid username/ password";
                        }
                        else {
                            session_start();

                            $conn = connection();
                            $sql = "SELECT token FROM account WHERE username='$username'";
                            $rows = $conn->query($sql);

                            if ($rows->num_rows > 0) {
                                while ($row = $rows->fetch_assoc()) {
                                    $token = $row["token"];
                                }
                            }

                            $_SESSION["SESSID"] = $token;

                            if (isset($_POST["remember-me"])) {
                                setcookie("PHPSID", $token, time() + 86400);
                            }

                            header("location: dashboard.php");
                        }
                    }
                }
            }
        ?>
        <div class="signin">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure>
                            <img src="../img/signin-image.jpg" alt="">
                        </figure>
    
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>
    
                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
    
                        <form method="POST" class="login-form" id="signin-form" action="">
                            <div class="form-group">
                                <label for="username">
                                    <i class="zmdi zmdi-account material-icons-name"></i>
                                </label>
                                <input type="text" name="username" id="username" placeholder="Username" value="<?= $username; ?>">
                            </div>
    
                            <div class="form-group">
                                <label for="password">
                                    <i class="zmdi zmdi-lock"></i>
                                </label>
                                <input type="password" name="password" id="password" placeholder="Password" value="<?= $password; ?>">
                            </div>
    
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" <?php if(isset($_COOKIE["PHPSID"])) { ?> checked <?php } ?>>
                                <label for="remember-me" class="label-agree-term">
                                    <span>
                                        <span>
                                        </span>
                                    </span>
                                    Remember me
                                </label>
                            </div>
    
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in">
                            </div>
                        </form>
                    </div>
                </div>
                <a href="register.php" class="signup-image-link" id="register_link">Create an account</a>
            </div>

            <div class="container">
                <?php 
                    if (!empty($error)){
                        ?>
                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </body>
</html>