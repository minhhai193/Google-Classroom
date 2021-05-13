<?php 
    require_once "../client/database.php";
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
            $role = $row["role"];
            $name = $row['name'];
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        // LẤY DỮ LIỆU TỪ PHƯƠNG THỨC Ở FORM POST
        $classroom_id = $_POST['classroomid'];
        $name = $_POST['name'];
        $des = $_POST['description'];
        $timeline = $_POST['timeline'];
        $userid = $_POST['userid'];
        $username = $_POST['username'];
        if($classroom_id !="" && $classroom_id !="" && $name !="" && $timeline !="" && $userid !="" && $username !=""){
            $get_user= $conn->query("SELECT user_id,name from account");
            foreach($get_user as $value){
                if($userid == $value['user_id'] && $username = $value['name']){
                    $insertClass = $conn->query("INSERT INTO classroom(classroom_id,name,description,staring_date,user_id,user_name) VALUES ('$classroom_id','$name','$des','$timeline','$userid','$username')");
                }
            }
            if(isset($insertClass)){
                header("Location: class_list.php");
            }else{
                $msg_error = "Giảng viên không tồn tại!";
            }
        }else{
            $msg_error = "Vui lòng điền thông tin đầy đủ!";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Admin</title>
    <link rel="SHORTCUT ICON" href="images/logo2.png">
    <link rel="stylesheet" type="text/css" href="/../style.css" media="screen" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- BEGIN: load jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
    <!-- END: load jquery -->
    <script src="https://kit.fontawesome.com/0b176a5748.js"></script>
</head>
<body>
    <div class="row mx-0">
        <div class="col-2 menu_left px-1">
           <div class="logo">
                <div class="text-center pt-4 pb-2 logo_sidemenu">
                    <img src="../images/logo.png" alt="">
                </div>
                <img src="../images/sidebarSep.png" alt="">
            </div>
            <div class="box sidemenu mt-2">
                <div class="block" id="section-menu">
                    <ul class="section menu">
                        <li>
                            <a href="index.php" class="ic_home">Trang chủ</a>
                        </li>
                        <li>
                            <a href="account_list.php" class="ic_user ">Quản lý tài khoản</a>
                        </li>
                        <li>
                            <a href="pass_list.php" class="ic_list ">Danh sách phê duyệt</a>
                        </li>
                        <li>
                            <a href="class_list.php" class="ic_list current">Danh sách lớp học</a>
                        </li>
                        <li>
                            <a href="component_list.php" class="ic_list ">Danh sách bài đăng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-10 px-0 menu_right">
            <div class="menu_head py-2 px-4">
                <ul class="ul">
                    <li><a href="https://iteaching.000webhostapp.com/Source/login.php" target="_blank"><i class="far fa-hand-point-right mr-2"></i></i>Vào website</a></li>
                    <li><a href="logout.php"><i class="fas fa-arrow-left mr-2"></i>Đăng xuất</a></li>
                    <li><span><img src="../images/icon/userPic.png" alt=""><p class="pl-2">Xin chào,  <?= $name ?> !</p></span></li>
                </ul>
            </div>
    <div class="title-style mt-5"><h4><i class="fas fa-home mr-3"></i>Thêm lớp học</h4></div>
    <div class="boxInsert">
        <form action="class_add.php" method="post" enctype="multipart/form-data">
            <table class="form"> 
            <?php
                if(isset($msg_error)){
                    echo "<div class='error'>$msg_error</div>";
                }
            ?>                   
                <tr>
                    <td class="w-25"><label>Classroom ID:</label></td>
                    <td >
                        <input name="classroomid" type="text" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td><label>Name:</label></td>
                    <td >
                        <input name="name" type="text" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td><label>Description:</label></td>
                    <td >
                        <input name="description" type="text" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td><label>Timeline:</label></td>
                    <td >
                        <input name="timeline" type="date" />
                    </td>
                </tr>
                <tr>
                    <td><label>Lecture ID:</label></td>
                    <td >
                        <input name="userid" type="text" />
                    </td>
                </tr>
                <tr>
                    <td><label>Lecture:</label></td>
                    <td >
                        <input name="username" type="text" />
                    </td>
                </tr>
                <tr>
                    <td id="td_end"></td>
                    <td id="td_end">
                        <input type="submit" name="submit" Value="Save" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
<script src="../main.js" type="text/javascript"></script>
</html>
