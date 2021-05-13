<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["title"]) and isset($_POST["classroom_id"]) and isset($_POST["due_date"]) and isset($_POST["content"]) and isset($_POST["component_id"])) {
        $classroom_id = $_POST["classroom_id"];
        $title = $_POST["title"];
        $due_date = $_POST["due_date"];
        $content = htmlspecialchars($_POST["content"], ENT_QUOTES);
        $component_id = $_POST["component_id"];
        
        $sql = "SELECT user_id FROM component WHERE component_id=$component_id AND classroom_id='$classroom_id'";
        $rows = $conn->query($sql);
        foreach($rows as $row) {
            $user_id = $row["user_id"];
        }

        $sql = "UPDATE component SET title='$title', content='$content', deadline='$due_date' WHERE component_id=$component_id";
        $conn->query($sql);

        get_component($classroom_id, 1, 2, $user_id);
    }
?>