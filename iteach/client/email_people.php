<?php 
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["classroom_id"]) and isset($_POST["name"]) and isset($_POST["classroom_name"]) and isset($_POST["email_lecture"]) and (isset($_POST["email"]))) {
        $classroom_id = $_POST["classroom_id"];
        $name = $_POST["name"];
        $classroom_name = $_POST["classroom_name"];
        $email_lecture = $_POST["email_lecture"];
        $email = $_POST["email"];

        $sql = "SELECT user_id, name FROM account WHERE email='$email'";
        $rows = $conn->query($sql);
        foreach($rows as $row) {
            $receiver = $row["name"];
            $user_id = $row["user_id"];

            $sql_check_people = "SELECT * FROM people WHERE classroom_id = '$classroom_id' AND user_id=$user_id";
            $count = $conn->query($sql_check_people);
            if(mysqli_num_rows($count) == 0) {
                $sql = "INSERT INTO people(classroom_id, user_id, passed) VALUES('$classroom_id', $user_id, 2)";
                $conn->query($sql);

                get_people($classroom_id, $email_lecture, $receiver, 1);

                email_add_people($user_id, $receiver, $name, $email_lecture, $classroom_id, $email, $classroom_name);
            }
            else {
                echo "1";
            }
        } 
    }
?>