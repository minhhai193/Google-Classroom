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
            $error = '';
            $code = 0;
            $username = '';
            $name = '';
            $email = '';
            $password = '';
            $pass_confirm = '';

            if (isset($_POST['signup'])) {
                if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['re-pass'])) {
                    $username = $_POST['username'];
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $pass_confirm = $_POST['re-pass'];
                    
                    if (empty($name)) {
                        $error = 'Please enter your name';
                    }
                    else if (empty($email)) {
                        $error = 'Please enter your email';
                    }
                    else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                        $error = 'This is not a valid email address';
                    }
                    else if (empty($username)) {
                        $error = 'Please enter your username';
                    }
                    else if (empty($password)) {
                        $error = 'Please enter your password';
                    }
                    else if (strlen($password) < 6) {
                        $error = 'Password must have at least 6 characters';
                    }
                    else if ($password != $pass_confirm) {
                        $error = 'Password does not match';
                    }
                    else {
                        if (exist($email) == 1) {
                            $error = 'This email has been registerd';
                        }
                        else {
                            if (register($name, $email, $username, $password) == 1) {
                                $error = 'System error - INSERT VALUES FAILED';
                            }
                            
                            $code = 1;
                        }
                    }
                }

            }
        ?>

        <div class="register">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
    
                        <form method="POST" class="register-form" id="signup-form" action="" novalidate>
                            <div class="form-group">
                                <label for="name">
                                    <i class="zmdi zmdi-account"></i>
                                </label>
                                <input type="text" name="name" value="<?= $name; ?>"  id="name" placeholder="Your name" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="zmdi zmdi-email"></i>
                                </label>
                                <input type="text" name="email" value="<?= $email; ?>"  id="email" placeholder="Email" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="username">
                                    <i class="zmdi zmdi-account material-icons-name"></i>
                                </label>
                                <input type="text" value="<?= $username; ?>" name="username" id="username" placeholder="Username" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="password">
                                    <i class="zmdi zmdi-lock"></i>
                                </label>
                                <input type="password" name="password" value="<?= $password; ?>"  id="password" placeholder="Password">
                            </div>

                            <div class="form-group">
                                <label for="re-pass">
                                    <i class="zmdi zmdi-lock-outline"></i>
                                </label>
                                <input type="password" name="re-pass" value="<?= $pass_confirm; ?>"  id="re-pass" placeholder="Repeat your password">
                            </div>
    
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register">
                            </div>
                        </form>
                    </div>

                    <div class="signup-image">
                        <figure>
                            <img src="../img/signup-image.jpg" alt="">
                        </figure>

                        <a href="login.php" class="signup-image-link">Already a member</a>
                    </div>
                </div>

                <a href="login.php" class="signup-image-link" id="register_link">Already a member</a>
            </div>

            <div class="container">
                <?php 
                    if (empty($error) and $code == 1)  {
                        ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> 
                            <br> Please verify your email to finish signing up for <span><img src="../img/logo-img.png" alt=""></span> , or go back to <a href="login.php">login</a>
                        </div>
                        <?php
                    }
                    else if (!empty($error)){
                        ?>
                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>

        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

        <script type="text/javascript" src="../main.js">
        </script>
    </body>
</html>