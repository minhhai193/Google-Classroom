<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"]) and isset($_POST["component_id"])) {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];
        $component_id = $_POST["component_id"];
        
        $sql = "DELETE FROM component WHERE component_id=$component_id AND classroom_id='$classroom_id' AND user_id=$user_id";
        $conn->query($sql);

        $sql = "DELETE FROM comment WHERE component_id=$component_id AND classroom_id='$classroom_id'";
        $conn->query($sql);
    }
?>