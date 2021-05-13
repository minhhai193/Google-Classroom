<?php 
    require_once "database.php";

    $conn = connection();

    //Load comment data
    if (isset($_POST["user_id"]) and isset($_POST["component_id"]) and isset($_POST["classroom_id"]) and isset($_POST["role"])) {
        $user_id = $_POST["user_id"];
        $component_id = $_POST["component_id"];
        $classroom_id = $_POST["classroom_id"];
        $role = $_POST["role"];

        $sql = "SELECT * FROM comment WHERE component_id = $component_id AND classroom_id = '$classroom_id'";
        $comments = $conn->query($sql);  
        foreach ($comments as $comment){ 
            $name = $conn->query("SELECT name, role FROM account WHERE user_id =".$comment["user_id"]);
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