<?php
    $fileName = $_FILES["filename"]["name"];
    $file = $_FILES["filename"]["tmp_name"];
    $destination = 'uploads/'.$fileName;
    move_uploaded_file($file, $destination);
?>