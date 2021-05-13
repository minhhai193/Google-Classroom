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

        if (isset($_GET["course"])) {
            $classroom_id = $_GET["course"];

            $conn = connection();

            $sql = "SELECT * FROM account WHERE token = '$token'";
            $rows = $conn->query($sql);

            foreach($rows as $row) {
                $user_id = $row['user_id'];
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
</head>

<body>
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
                            <li class="nav-item active">
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
                    
                                    <button type="button" class="btn btn-outline-secondary btn-rounded" id="btn-logout" name="logout">Logout</button>
                                </div>
                            </div>
                        </form>
                    </div> -->
                </div>
            </nav>

            <div id="classroom">
                <h4>Classroom</h4>

                <div class="row">
                    <div class="col-lg-3 col-12" id="classInfo">
                        <div class="class-overview">
                            <?php
                                get_classroom_description($classroom_id);
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-lg-9 col-12">
                        <div class="class-view">
                            <div>
                                <div id="left">
                                    <div>
                                        <a data-toggle="collapse" href="#sublist" role="button" aria-expanded="false" aria-controls="sublist">
                                            <div class="filter">
                                                <span>All</span>
                                                <span></span>
                                                <span> <i class="fal fa-angle-down"></i> </span>
                                            </div>
                                        </a>
                                        <div class="collapse filter-sublist" id="sublist">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">All</li>
                                                <li class="list-group-item">Announcements</li>
                                                <li class="list-group-item">Assignments</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="right">
                                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#share" <?php if($role == 2) { ?> hidden  <?php } ?> data-classroom_id="<?=$classroom_id?>" data-user_id="<?=$user_id?>">Share</a>
                                </div>
                            </div>

                            <div id="view" class="row">
                                <?php 
                                    get_component($classroom_id, $role, 0, $user_id);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>

    <!-- Modal -->
    <div class="modal fade" id="share" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="frame">
                    <form method="POST" enctype="multipart/form-data" id="share_form">
                        <div class="form-group">
                            <label for="component-detail">Share something with your class <span class="text-danger">*</span> </label>
                            <textarea name="" id="component-detail" cols="" rows="6" onchange="getComponentDetail(this.value)"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" id="customFile" name="filename">
                                <label class="custom-file-label text-truncate" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_share" data-dismiss="modal">Post</button>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="edit_component" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="frame">
                    <form method="POST" enctype="multipart/form-data" id="share_form">
                        <div class="form-group">
                            <label for="component-detail">Share something with your class <span class="text-danger">*</span> </label>
                            <textarea name="" id="component-detail" cols="" rows="6" onchange="getComponentDetail(this.value)"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" id="customFile" name="filename">
                                <label class="custom-file-label text-truncate" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn_edit_component" data-dismiss="modal">Save</button>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="delete_component" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="frame">
                        Are you sure want to delete this?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_component_delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Class comments</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="custom-comment">
                    <div id="show_comment">       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form class="w-100" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-10">
                            <div>
                                <input type="text" class="form-control" name="comment_content" id="comment_content" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-2">
                            <input type="submit" class="btn btn-primary w-100" name="post_comment" id="post_comment" onclick="return false;" value="Send">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="material" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Materials</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div id="show_material">       
                </div>
            </div>
        </div>
        </div>
    </div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <!-- jQuery CDN - Slim version (=without AJAX) -->
   <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript" src="../main.js"></script>
</body>

</html>