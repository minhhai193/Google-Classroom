<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["classroom_id"]) and isset($_POST["component_id"])) {
        $classroom_id = $_POST["classroom_id"];
        $component_id = $_POST["component_id"];

        $sql = "SELECT user_id FROM classroom WHERE classroom_id='$classroom_id'";
        $rows = $conn->query($sql);
        foreach($rows as $row) {
            $user_id = $row["user_id"];
        }
        
        $sql = "DELETE FROM component WHERE component_id=$component_id AND classroom_id='$classroom_id'";
        $conn->query($sql);

        $sql = "DELETE FROM comment WHERE component_id=$component_id AND classroom_id='$classroom_id'";
        $conn->query($sql);

        get_component($classroom_id, 1, 2, $user_id);
    }
?>