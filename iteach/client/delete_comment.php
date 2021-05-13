<?php
    require_once "database.php";

    $conn = connection();

    if (isset($_POST["comment_id"]) and isset($_POST["user_id"]) and isset($_POST["component_id"]) and isset($_POST["classroom_id"]) and isset($_POST["role"])) {
        $comment_id = $_POST["comment_id"];
        $user_id = $_POST["user_id"];
        $component_id = $_POST["component_id"];
        $classroom_id = $_POST["classroom_id"];
        $role = $_POST["role"];

        $sql = "DELETE FROM comment WHERE comment_id=$comment_id AND user_id=$user_id AND classroom_id='$classroom_id'";
        $conn->query($sql);

        $conn->query($sql);$sql = "SELECT * FROM comment WHERE component_id = $component_id AND classroom_id = '$classroom_id'";
        $comments = $conn->query($sql);  

        foreach ($comments as $comment){ 
            $name = $conn->query("SELECT name FROM account WHERE user_id =".$comment["user_id"]);
            $name_user =  $name->fetch_assoc(); 
            ?>
            <div class="items">
                <img src="../img/photo.png" alt="">
                <div class="details pl-3">
                    <h3 id="h3"><?= $name_user["name"] ?></h3>
                    <p id="p"><?= $comment["content"] ?></p>
                </div>
                <?php  
                if ($role == 1) {
                ?>
                    <i class="fal fa-times" onclick="return remove(<?=$comment['comment_id']?>, '<?=$comment['classroom_id']?>', <?=$comment['component_id']?>, <?=$comment['user_id']?>, <?=$role?>);"></i>
                <?php 
                }
                ?>
            </div>
            <?php
        }
    }
?>