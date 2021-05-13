<?php
        require_once "database.php";
?>

<?php
    session_start();
    if (!isset($_SESSION["SESSID"])) {
        header("location: login.php");
    }
    else {
        $token = $_SESSION["SESSID"];

        if (isset($_GET["course"]) and isset($_GET["component_id"])) {
            $classroom_id = $_GET["course"];
            $component_id = $_GET["component_id"];

            $conn = connection();

            $sql = "SELECT * FROM account WHERE token = '$token'";
            $rows = $conn->query($sql);

            foreach($rows as $row) {
                $user_id = $row["user_id"];
                $role = $row["role"];
            }
        }
        else {
            header("location: dashboard.php");
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>iTech</title>

    <link rel="shortcut icon" type="image/x-icon" href="../img/logo-img.png" sizes="16x16"/>

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    <!-- Icons CDN -->
    <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    
    <!-- Dropzone CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
</head>

<body>
    <?php
        // if save button on the form is clicked
        if (isset($_POST['upload'])) {
            // name of the uploaded file
            $filename = $_FILES['filename']['name'];
            // destination of the file on the server
            $destination = 'uploads/' . $filename;
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // the physical file on a temporary uploads directory on the server
            $file = $_FILES['filename']['tmp_name'];
            $size = $_FILES['filename']['size'];

            if (move_uploaded_file($file, $destination)) {
                $sql = "INSERT INTO submission(classroom_id, component_id, user_id, file) VALUES('$classroom_id', $component_id, $user_id, '$filename')";
                $conn->query($sql);
            }

            // if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
            //     echo "You file extension must be .zip, .pdf or .docx";
            // } elseif ($_FILES['filename']['size'] > 50000000) { // file shouldn't be larger than 1Megabyte
            //     echo "File too large!";
            // } else {
            //     // move the uploaded (temporary) file to the specified destination
            //     if (move_uploaded_file($file, $destination)) {
            //         $sql = "INSERT INTO submission(classroom_id, component_id, user_id, file) VALUES('$classroom_id', $component_id, $user_id, '$filename')";
            //         $conn->query($sql);
            //     }
            // }
        }

        if (isset($_POST['unsubmit'])) {
            $sql = "DELETE FROM submission WHERE classroom_id='$classroom_id' AND component_id=$component_id AND user_id=$user_id";
            $conn->query($sql);
        }
    ?>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <span class="logo-icon"><img src="../img/logo.png" alt=""></span>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="dashboard.php">
                        <i class="fas fa-home ml-3 mr-4"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fas fa-calendar ml-3 mr-4"></i>
                        Calendar
                    </a>
                </li>
            </ul>

            <hr>

            <ul class="list-unstyled components components-2">
                <div>Enrolled</div>

                <?php
                    $sql="SELECT * FROM classroom WHERE classroom_id IN (SELECT classroom_id FROM people WHERE user_id = $user_id)";
                    $rows = $conn->query($sql);
                    foreach($rows as $row)
                    {
                        $first_character = $row["name"]; $first_character = $first_character[0];
                    ?>
                        <li>
                            <a class="p-0 pl-2 pr-2" href="classroom.php?course=<?=$row["classroom_id"]?>">
                                <div class="p-0 pl-3 pr-3" id="flex">
                                    <div id="circle" href=""><?= $first_character; ?></div>

                                    <div class="enrolled text-truncate ml-3">
                                        <h6 class="text-truncate" style="color: black"><?= $row["name"]; ?></h6>
                                        <p class="text-truncate" style="color: black"><?=$row["user_name"] ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php
                    }
                ?>
            </ul>

            <hr>

            <ul>
                <li>
                    <a href="">Account Management</a>
                </li>
                <li>
                    <button type="button" class="btn btn-outline-secondary" id="logout">Logout</button>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-align-left"></i>
                    </button>

                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                                <a class="nav-link" href="classroom.php?course=<?=$classroom_id?>">Stream</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="assignment.php?course=<?=$classroom_id?>">Classwork</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="people.php?course=<?=$classroom_id?>">People</a>
                            </li>
                        </ul>
                    </div>

                    <!-- <div class="nav-link ml-2" id="circle" rel="popover" data-placement="bottom">H</div>

                    <div id="pop">
                        <form method="POST" action="">
                            <div class="profile-popovers">
                                <div class="profile-header">
                                    <div class="nav-link" id="circle" href="#">
                                        <p id="profile-img">
                                            H
                                        </p>
                                    </div>
                                    <div class="name">Hong Co Nghiep</div>
                                    <div class="email">hongnghiep@email.com</div>
                                </div>
                                <div class="profile-body">
                                <a id="btn-account">Account Management</a>
                    
                                    <hr>
                    
                                    <button type="button" class="btn btn-outline-secondary btn-rounded" id="btn-logout">Logout</button>
                                </div>
                            </div>
                        </form>
                    </div> -->
                </div>
            </nav>

            <div id="assigment_submit">
                <h4>Assignment</h4>
                <div class="row">
                    <?php
                        $rows = get_AssignmentSubmit($component_id, $classroom_id);
                        
                        foreach($rows as $row) {
                            ?>
                            <div class="col-lg-9 col-md-12">
                                <div class="assigment-view">
                                    <div>
                                        <div id="flex">
                                            <img src="../img/icon.jpg" alt="No image found">
                                            <div id="flx">
                                                <h5><?= $row["title"]; ?></h5>
                                                <p><?php $conn = connection(); $sql = "SELECT name FROM account WHERE user_id=".$row['user_id']; $name = $conn->query($sql); foreach($name as $n) { echo $n["name"]; } ?> • <?= date('M d, Y h:i A', strtotime($row['timeline']))?>
                                                </p>
                                            </div>
                                            <div id="assigment_submit-none">
                                                <p>Due <?= date('M d, Y h:i A', strtotime($row['deadline']))?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="float-right">
                                        <p>Due <?= date('M d, Y h:i A', strtotime($row['deadline']))?></p>
                                    </div>

                                    <hr>

                                    <p><?= $row["content"]; ?></p>
                                    
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    
                    <div class="col-lg-3 col-md-12">
                        <?php if ($role == 1) { ?>
                            <div id="scroll">
                                <div id="flex">
                                    <h5 class="px-3 mb-4">Student Files</h5>
                                    <span id="flx"></span>
                                    <i class="far fa-cloud-download mb-4 mr-3"></i>
                                </div>
                                <?php
                                    $sql = "SELECT * FROM submission WHERE component_id=$component_id AND classroom_id='$classroom_id'";
                                    $rows = $conn->query($sql);
                                    
                                    if ($rows->num_rows > 0) {
                                        foreach($rows as $row) {
                                        ?>
                                            <div class="col-12 mb-4">
                                                <div class="card" id="submit">
                                                    <div id="flex">
                                                        <img src="../img/photo.png" alt="">
                                                        <div>
                                                            <h6><?=get_name($row['user_id'])?></h6>
                                                            <small><?=date('Y-m-d h:i A', strtotime($row['timeline']))?></small>
                                                        </div>
                                                    </div>
                                                    
                                                    <a href="https://docs.google.com/gview?url=https://iteaching.000webhostapp.com/client/uploads/<?= $row['file']; ?>&embedded=true" target="_blank">
                                                        <div class="items mx-4 mb-3">
                                                            <i class="fas fa-cloud-upload-alt"></i>
                                                            <div class="details ml-2 px-2 text-truncate">
                                                                <p class="mb-0" id="p"><?= $row['file']; ?></p>
                                                                <p class="mb-0" id="p1">File Upload</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                ?>
                            </div>
                        <?php } ?>

                        <?php if ($role == 2) { ?>
                            <?php
                                $sql = "SELECT * FROM submission WHERE component_id=$component_id AND classroom_id='$classroom_id' AND user_id=$user_id ORDER BY UNIX_TIMESTAMP(timeline) DESC";
                                $rows = $conn->query($sql);
                                if ($rows->num_rows > 0) {
                                    foreach($rows as $row) {
                                    ?>
                                        <div class="card" id="submit">
                                            <div id="flex">
                                                <h6>Your work</h6>
                                                <p id="flx"></p>
                                                <p class="text-success">Submited</p>
                                            </div>

                                            <a href="uploads/<?=$row['file']?>">
                                                <div class="items mx-4 mb-3">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <div class="details ml-2 px-2 text-truncate">
                                                        <p class="mb-0" id="p"><?= $row['file']; ?></p>
                                                        <p class="mb-0" id="p1">File Upload</p>
                                                    </div>
                                                </div>
                                            </a>

                                            <div class="custom-file mb-3">
                                                <form action="submit.php?course=<?=$classroom_id?>&component_id=<?= $row['component_id']; ?>" method="post" enctype="multipart/form-data">
                                                    <button class="btn mb-3" type="submit" name="unsubmit">Unsubmit</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                                
                                else {
                                    $deadline = "SELECT deadline FROM component WHERE component_id=$component_id AND classroom_id='$classroom_id'";
                                    $deadline = $conn->query($deadline);
                                    $deadline =  mysqli_fetch_assoc($deadline);
                                    $today = date("Y-m-d"); 
                                    
                                    $today_time = strtotime($today); 
                                    $deadline_time = strtotime($deadline["deadline"]); 

                                    $datedis = floor(abs($today_time - $deadline_time) / (60*60*24));
                                ?>
                                    <div class="card" id="submit">
                                            <div id="flex">
                                                <h6>Your work</h6>
                                                <p id="flx"></p>
                                                <?php                                           
                                                    if ($today_time > $deadline_time) {
                                                        $flag = 1;
                                                        ?> <p class="text-danger">Missing</p> <?php
                                                    } elseif ($datedis <= 7) {
                                                        $flag = 0;
                                                        ?> <p class="text-warning">Deadline</p> <?php
                                                    }else {
                                                        $flag = 0;
                                                        ?> <p>To-do</p> <?php
                                                    }
                                                ?>
                                            </div>
                                            
                                            <?php if ($flag != 1) { ?>
                                                <div class="custom-file mb-3">
                                                    <form action="submit.php?course=<?=$classroom_id?>&component_id=<?= $row['component_id']; ?>" method="post" enctype="multipart/form-data" >
                                                        <input type="file" class="custom-file-input" id="customFile" name="filename">
                                                        <label class="custom-file-label text-truncate" for="customFile">Choose file</label>
                                                        <button class="btn mt-3" type="submit" name="upload">Submit</button>
                                                    </form>
                                                </div>
                                            <?php }?>
                                    </div>
                                <?php
                                }
                            ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>
    
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript" src="../main.js">
    </script>
</body>

</html>