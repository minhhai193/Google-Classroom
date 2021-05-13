<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"])) {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];

        $sql = "DELETE FROM classroom WHERE user_id=$user_id AND classroom_id='$classroom_id'";
        $conn->query($sql);

        $sql = "DELETE FROM people WHERE classroom_id='$classroom_id'";
        $conn->query($sql);

        $sql = "DELETE FROM submission WHERE classroom_id='$classroom_id'";
        $conn->query($sql);

        $sql = "DELETE FROM component WHERE classroom_id='$classroom_id'";
        $conn->query($sql);

        $sql = "DELETE FROM comment WHERE classroom_id='$classroom_id'";
        $conn->query($sql);

        get_dashboard($user_id);
    }
?>