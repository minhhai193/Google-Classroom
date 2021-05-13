<?php 
    require_once "database.php";

    $conn = connection();

    if (isset($_GET["course"]) and isset($_GET["user_id"])) {
        $sql = "UPDATE people SET passed = 1 WHERE user_id = '".$_GET['user_id']."' and classroom_id = '".$_GET['course']."'";
        $conn->query($sql);

        header("location: https://iteaching.000webhostapp.com/client/classroom.php?course=".$_GET["course"]);
    }
?>