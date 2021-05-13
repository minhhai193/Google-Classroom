<?php 
    require_once "database.php";

    $conn = connection();

    //Load comment data
    if (isset($_POST["component_id"]) and isset($_POST["classroom_id"])) {
        $component_id = $_POST["component_id"];
        $classroom_id = $_POST["classroom_id"];

        $sql = "SELECT * FROM component WHERE component_id = $component_id AND classroom_id = '$classroom_id'";
        $rows = $conn->query($sql);
        foreach ($rows as $row){
            if ($row['material'] != "") {
            ?>
               <a href="https://docs.google.com/gview?url=https://iteaching.000webhostapp.com/client/uploads/<?= $row["material"];?>&embedded=true" target="_blank">
                    <div class="items mx-2">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <div class="details ml-2 px-2 text-truncate">
                            <p class="mb-0" id="p"><?= $row['material']; ?></p>
                            <p class="mb-0" id="p1">File Upload</p>
                        </div>
                    </div>
                </a>
            <?php
            }
        }
    }
?>