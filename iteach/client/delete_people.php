<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["classroom_id"]) and isset($_POST["email"])) {
        $user_id = $_POST["user_id"];
        $classroom_id = $_POST["classroom_id"];
        $email = $_POST["email"];

        $sql = "SELECT name FROM account WHERE user_id=$user_id";
        $rows = $conn->query($sql);
        foreach($rows as $row) {
            $name = $row["name"];
        }
        
        $sql = "DELETE FROM people WHERE user_id=$user_id AND classroom_id='$classroom_id'";
        $conn->query($sql);

        $sql = "DELETE FROM submission WHERE user_id=$user_id AND classroom_id='$classroom_id'";
        $conn->query($sql);

        get_people($classroom_id, $email, $name, 1);
    }
?>