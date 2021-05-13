<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"]) and isset($_POST["content"]) and isset($_POST["file"])) {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];
        $content = htmlspecialchars($_POST["content"], ENT_QUOTES);
        $component_id = $_POST["component_id"];

        $sql = "UPDATE component SET content='$content' WHERE component_id=$component_id AND classroom_id='$classroom_id' AND user_id=$user_id";
        $conn->query($sql);
    }
?>