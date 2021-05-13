<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"]) and isset($_POST["content"]) and isset($_POST["file"])) {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];
        $content = htmlspecialchars($_POST["content"], ENT_QUOTES);
        $file = $_POST["file"];
        
        $sql = "INSERT INTO component(classroom_id, user_id, content, type, material) VALUES ('$classroom_id', $user_id, '$content', 1, '$file')";
        $conn->query($sql);

        $destination = 'uploads/' . $file;

        get_component($classroom_id, 1, 0, $user_id);
    }
?>