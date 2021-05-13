<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"]) and isset($_POST["classroom_name"]) and isset($_POST["description"]) and isset($_POST["timeline"]) and isset($_POST["name"]))
    {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];
        $classroom_name =  $_POST["classroom_name"];
        $description =  $_POST["description"];
        $timeline =  $_POST["timeline"];
        $name =  $_POST["name"];
        
        $sql = "INSERT INTO classroom(classroom_id, name, description, staring_date, user_id, user_name) VALUES ('$classroom_id', '$classroom_name', '$description', '$timeline', $user_id, '$name')";
        $conn->query($sql);

        $sql = "INSERT INTO people(classroom_id, user_id, passed) VALUES ('$classroom_id', $user_id, 1)";
        $conn->query($sql);

        get_dashboard($user_id);
    }
?>