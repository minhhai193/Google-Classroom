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
        $classroom_id = $_POST['classroom_id'];
        $user_id = $_POST['user_id'];
        $content = $_POST['content'];
        $type = $_POST['type'];
        $material = $_POST['material'];
        $timeline = $_POST['timeline'];
        $deadline = $_POST['deadline'];
        $title = $_POST['title'];
        $id= (int)$user_id;

        if($classroom_id !="" && $user_id !="" && $content !="" && $timeline !="" && $deadline !=""){
            $get_user= $conn->query("SELECT user_id from account");
            foreach($get_user as $value){
                if($user_id == $value['user_id']){
                    $insertClass = $conn->query("INSERT INTO component(classroom_id,user_id,content,type,material,timeline,deadline,title) VALUES ('$classroom_id','$user_id','$content','$type','$material','$timeline','$deadline','$title')");
                }
            }
            if(isset($insertClass)){
                header("Location: component_list.php");
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
    <link rel="SHORTCUT ICON" href="../images/logo2.png">
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
                            <a href="class_list.php" class="ic_list ">Danh sách lớp học</a>
                        </li>
                        <li>
                            <a href="component_list.php" class="ic_list current">Danh sách bài đăng</a>
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
        <form action="component_add.php" method="post" enctype="multipart/form-data">
            <table class="form"> 
            <?php
                if(isset($msg_error)){
                    echo "<div class='error'>$msg_error</div>";
                }
            ?>                   
            <tr>
                <td class="w-25"><label>Classroom ID:</label></td>
                <td>
                    <input  value="" type="text" name="classroom_id" >
                </td>
            </tr>
            <tr>
                <td><label>User id:</label></td>
                <td>
                    <input  value="" type="text" name="user_id" >
                </td>
            </tr>
            <tr>
                <td><label>Content:</label></td>
                <td>
                    <input  value="" type="text"  name="content" >
            </tr>
            <tr>
                <td><label>Type:</label></td>
                <td>
                    <input  value="" type="text" name="type" />
                </td>
            </tr>
            <tr>
                <td><label>Material:</label></td>
                <td>
                    <input  value="" type="text"  name="material" >
                </td>
            </tr>
            <tr>
                <td><label>Timeline:</label></td>
                <td>
                    <input  value="" type="datetime-local" name="timeline" >
                </td>
            </tr>
            <tr>
                <td><label>Deadline:</label></td>
                <td>
                    <input  value="" type="datetime-local" name="deadline" >
                </td>
            </tr>
            <tr>
                <td><label>Title:</label></td>
                <td>
                    <input  value="" type="text" name="title" >
                </td>
            </tr>
            <tr> 
                <td id="td_end"></td>
                <td id="td_end">
                    <input type="submit" name="submit" Value="Save" >
                </td>
            </tr>
            </table>
        </form>
    </div>
</body>
<script src="../main.js" type="text/javascript"></script>
</html>
