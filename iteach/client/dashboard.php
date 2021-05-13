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

        $conn = connection();

        $sql = "SELECT * FROM account WHERE token = '$token'";
        $rows = $conn->query($sql);

        foreach($rows as $row) {
            $name = $row["name"];
            $user_id = $row["user_id"];
            $role = $row["role"];
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
                        if (get_passed($row["classroom_id"], $user_id) == 1) {
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
                    }
                ?>
            </ul>

            <hr>

            <ul>
                <li>
                    <a href="">Account Management</a>
                </li>
                <li>
                    <button type="button" class="btn btn-outline-secondary" id="logout" name="logout">Logout</button>
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

            <div id="dashboard">
            <div id="flex">
                    <h4>Overview</h4>
                </div>

                <div class="page-bar">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="info-box bg-deadline">
                                <span class="info-box-icon push-bottom"><i class="fas fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Deadline</span>
                                    <span class="info-box-number">3</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 40%"></div>
                                    </div>
                                    <span class="progress-description">
                                        40% Increase in 28 Days
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="info-box bg-todo">
                                <span class="info-box-icon push-bottom"><i class="fas fa-list"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">To do</span>
                                    <span class="info-box-number">52</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 85%"></div>
                                    </div>
                                    <span class="progress-description">
                                        85% Increase in 28 Days
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="info-box bg-success">
                                <span class="info-box-icon push-bottom"><i class="fas fa-check-square"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Success</span>
                                    <span class="info-box-number">450</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 45%"></div>
                                    </div>
                                    <span class="progress-description">
                                        45% Increase in 28 Days
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="info-box bg-missing">
                                <span class="info-box-icon push-bottom"><i class="fas fa-times-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Missing</span>
                                    <span class="info-box-number">52</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 85%"></div>
                                    </div>
                                    <span class="progress-description">
                                        85% Increase in 28 Days
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="flex">
                    <h4>Dashboard</h4>
                    <span id="flx"></span>
                        <button class="btn rounded-circle" data-toggle="modal" data-target="<?php if($role == 2) { ?>#join_course<?php } else { ?>#add_course<?php } ?>" data-user_id="<?=$user_id?>" data-classroom_id="<?=random(6);?>" data-lecture="<?=$name?>">
                        <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fas fa-plus"></i> -->
                    </button>
                </div>

                <div class="page-view">
                    <div id="dashboard-ajax" class="row">
                        <?php
                            get_dashboard($user_id);
                        ?>
					</div>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>

    <!-- Modal -->
    <div class="modal fade" id="add_course" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="frame">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="course-name">Course Name <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="course-name" placeholder="Enter course name" onchange="getCourseName(this.value)">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="course-code">Course Code <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="course-code" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="course-detail">Course Details</label>
                                <textarea name="" id="course-detail" cols="" rows="6" onchange="getDetails(this.value)"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="staring-date">Staring Date <span class="text-danger">*</span> </label>
                                    <input type="date" class="form-control" id="staring-date" onchange="getCourseTimeline(this.value)">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lecture">Lecture</label>
                                    <input type="text" class="form-control" id="lecture" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_create" data-dismiss="modal">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="join_course" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="frame">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="course-code">Course Code <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="course-code" onchange="getCourseCode(this.value)">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_join">Join</button>
                </div>

                <div class="modal-error ml-3 mr-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="exist">
                        <strong>Error!</strong> Make sure your code is correct.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="duplicate">
                        <strong>Error!</strong> You are already joined this class.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_course" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="frame">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="course-name">Course Name <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="course-name" placeholder="Enter course name" onchange="getCourseName(this.value)">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="course-code">Course Code <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="course-code" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="course-detail">Course Details</label>
                                <textarea name="" id="course-detail" cols="" rows="6" onchange="getDetails(this.value)"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="staring-date">Staring Date <span class="text-danger">*</span> </label>
                                    <input type="date" class="form-control" id="staring-date" onchange="getCourseTimeline(this.value)">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lecture">Lecture</label>
                                    <input type="text" class="form-control" id="lecture" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn_edit_course" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_course" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Course</h5>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_delete_course">Delete</button>
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