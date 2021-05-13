<?php
    $email = "";
    $token = "";

    if (isset($_GET["receiver"]) and isset($_GET["sender"]) and isset($_GET["email"]) and isset($_GET["classroom_id"]) and isset($_GET["email_lecture"]) and isset($_GET["name"]) and isset($_GET["user_id"])) {
        $receiver = $_GET["receiver"];
        $sender = $_GET["sender"];
        $email = $_GET["email"];
        $email_lecture = $_GET["email_lecture"];
        $classroom_id = $_GET["classroom_id"];
        $name = $_GET["name"];
        $user_id = $_GET["user_id"];
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
    
        <style type="text/css">
            .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
                margin-bottom: .5rem;
                font-family: inherit;
                font-weight: 500;
                line-height: 1.2;
                color: inherit;
            }

            .h3, h3 {
                font-size: 1.75rem;
            }

            .h1, h1 {
                font-size: 2.5rem;
            }

            p {
                font-size: 1.25em;
                font-weight: 300;
                line-height: 1.7em;
                color: black;
                margin-top: 0;
                margin-bottom: 1rem;
            }

            .verify {
                margin-bottom: 1rem;
                cursor: pointer !important;
                display: inline-block;
                font-weight: 400;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                border: 1px solid transparent;
                padding: 15px 39px;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: .25rem;
                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            }

            .verify {
                color: #fff !important;
                background-color: #28a745;
                border-color: #28a745;
            }

            .verify:hover {
                background-color: #248a3b;
                border-color: #248a3b;
            }
        </style>
    </head>

    <body>
        <div style="padding: 15px 25px;">
            <h1 style="color: #ED8074;">iTech</h1>
    
            <div>
                <h3>Hi <?=$receiver?>, </h3>
                <p><?=$sender?>(<a style="color: #ED8074; font-weight: 600;"><?=$email_lecture?></a>) invited you to the class <i><?=$name?></i>. </p>
                
                <a class="verify" href="https://iteaching.000webhostapp.com/client/email_add_user_active.php?user_id=<?=$user_id?>&course=<?=$classroom_id?>">Join</a>
            
                <p>If you didn't attempt to join with this class, please delete this email.</p>
            
                <p>Thanks,</p>

                <img src='https://dewey.tailorbrands.com/production/brand_version_mockup_image/24/4145183024_9fb6f089-e0c0-4870-9608-99b93ae57ed3.png?cb=1605674841' alt='' width='80'>
            </div>
        </div>
    </body>
</html>