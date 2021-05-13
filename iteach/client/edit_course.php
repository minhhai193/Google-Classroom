<?php
    require_once "database.php";

    $conn = connection();

    $user_id = $_POST["user_id"];
    $classroom_id = $_POST["classroom_id"];
    $name = $_POST["name"];
    $description = htmlspecialchars($_POST["description"], ENT_QUOTES);
    $staring_date = $_POST["staring_date"];
    $lecture = $_POST["lecture"];

    $sql = "UPDATE classroom SET name='$name', description='$description', staring_date='$staring_date' WHERE user_id=$user_id AND classroom_id='$classroom_id'";
    $conn->query($sql);

    get_dashboard($user_id);
?>