<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"]))
    {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];
        
        $sql_check_course = "UPDATE people SET passed = 1 WHERE user_id = '".$user_id."' and classroom_id = '".$classroom_id."'";
        $count = $conn->query($sql_check_course);
    }
?>