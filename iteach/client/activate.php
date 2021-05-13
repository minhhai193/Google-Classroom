<?php
    $email = "";
    $token = "";

    if (isset($_GET["email"]) and isset($_GET["token"])) {
        $email = $_GET["email"];
        $token = $_GET["token"];
    }
?>

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

            if (isset($_POST["signin"])) {
                if (active($email, $token) == 0) {
                    header("location: https://iteaching.000webhostapp.com/client/login.php");
                }
                else {
                    $error = "Error!";
                }
            }
        ?>
        <div class="signin">
            <div class="container">
                <div class="signin-content">
                    <div class="activate-form">
                        <figure>
                            <img src="../img/activate-img.png" alt="">
                        </figure>

                        <h2 class="form-title">Congrats!</h2>
    
                        <p>Your account is created!</p>

                        <form method="POST" class="login-form" id="signin-form" action="">
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in">
                            </div>
                        </form>
                    </div>
                </div>
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