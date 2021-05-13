<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["user_id"]) and isset($_POST["course_code"]))
    {
        $user_id = $_POST["user_id"];
        $course_code = $_POST["course_code"];
        $sql_check_course = "SELECT classroom_id,name,description FROM classroom WHERE classroom_id = '".$course_code."'";
        $count = $conn->query($sql_check_course);

        if (mysqli_num_rows($count) > 0) {
            $sql_check_course = "SELECT * FROM people WHERE classroom_id = '".$course_code."' AND user_id=$user_id";
            $count = $conn->query($sql_check_course);
            if (mysqli_num_rows($count) == 0) {
                $sql_insert_classroom = "INSERT INTO people(classroom_id, user_id, passed) VALUES ('$course_code', '$user_id',0)";
                $conn->query($sql_insert_classroom);
                
                get_dashboard($user_id);
            }
            else {
                echo "2";
            }
        }
        else
        { 
            echo "1";
        }
        
    }
?>