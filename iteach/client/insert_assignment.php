<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"]) and isset($_POST["title"]) and isset($_POST["due_date"]) and isset($_POST["content"]) and isset($_POST["file"])) {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];
        $title = $_POST["title"];
        $user_id = $_POST["user_id"];
        $due_date = $_POST["due_date"];
        $content = htmlspecialchars($_POST["content"], ENT_QUOTES);
        $file = $_POST["file"];
        
        $sql = "INSERT INTO component(classroom_id, user_id, content, type, deadline, title, material) VALUES ('$classroom_id', '$user_id', '$content', 2, '$due_date', '$title', '$file')";
        $conn->query($sql);

        get_component($classroom_id, 1, 2, $user_id);
    }
?>