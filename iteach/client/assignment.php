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
                            <li class="nav-item">
                                <a class="nav-link" href="classroom.php?course=<?=$classroom_id?>">Stream</a>
                            </li>

                            <li class="nav-item active">
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

            <div id="assignment">
                <div id="left">
                    <div id="flex">
                        <h4>Assignment</h4>
                        <span id="flx"></span>
                        <button class="btn rounded-circle ml-2 mt-1" data-toggle="modal" data-target="#create" <?php if($role == 2) { ?> hidden <?php } ?> data-user_id="<?=$user_id?>" data-classroom_id="<?=$classroom_id?>">
                            <i class="fal fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="right">
                    <div id="flex">
                        <div class="form-group has-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Search" id="search_assignment">
                        </div>
                        
                        <div id="relative">
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
                                    <li class="list-group-item">Missing</li>
                                    <li class="list-group-item">Deadline</li>
                                    <li class="list-group-item">Success</li>
                                    <li class="list-group-item">To-do</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Status</th>
                                <th scope="col">Submission</th>
                                <th scope="col" <?php if($role == 2) { ?> hidden <?php } ?>>Action</th>
                            </tr>
                        </thead>
    
                        <tbody id="tbody">
                            <?php
                                get_component($classroom_id, $role, 2, $user_id);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>

    <!-- Modal -->
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Assignment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="frame">
                        <form>
                            <div class="form-group">
                                <label for="course-name">Title <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" id="course-name" placeholder="Enter assignment title" onchange="getComponentAssignmentTitle(this.value)">
                            </div>
                            <div class="form-group">
                                <label for="course-detail">Assignment details</label>
                                <textarea name="" id="course-detail" cols="" rows="6" onchange="getComponentAssignmentDetail(this.value)"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="staring-date">Due date </label>
                                <input type="datetime-local" class="form-control" id="staring-date" onchange="getComponentAssignmentDueDate(this.value)">
                            </div>
                            <div class="form-group mb-auto">
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
                <button type="button" class="btn btn-primary" id="btn_assignment_create" data-dismiss="modal">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Assignment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="frame">
                        <form>
                            <div class="form-group">
                                <label for="course-name">Title <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" id="assignment-title" placeholder="Enter assignment title" onchange="getComponentAssignmentTitle(this.value)">
                            </div>
                            <div class="form-group">
                                <label for="course-detail">Assignment details</label>
                                <textarea name="" id="assignment-details" cols="" rows="6" onchange="getComponentAssignmentDetail(this.value)"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Due date </label>
                                <input type="datetime-local" class="form-control" id="date" onchange="getComponentAssignmentDueDate(this.value)">
                            </div>
                            <div class="form-group mb-auto">
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
                <button type="button" class="btn btn-success" data-dismiss="modal" id="btn_assignment_edit">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignment_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Assignment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="frame">
                        Are you sure want to delete <b></b>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_assignment_delete">Delete</button>
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

    <script type="text/javascript" src="../main.js">
    </script>
</body>

</html>