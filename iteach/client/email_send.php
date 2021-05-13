<?php 
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["email"]) and isset($_POST["content"]) and isset($_POST["email_lecture"])  and isset($_POST["name"])) {
        $email = $_POST["email"];
        $name = $_POST["name"];
        $email_lecture = $_POST["email_lecture"];
        $content = $_POST["content"];

        email_send($email, $email_lecture, utf8_encode($name), $content);
    }
?>