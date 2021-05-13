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
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Admin</title>
	<link rel="SHORTCUT ICON" href="images/logo-img.png">
	<link rel="stylesheet" type="text/css" href="/../style.css" media="screen" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<!-- BEGIN: load jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<!-- END: load jquery -->
	<script src="https://kit.fontawesome.com/0b176a5748.js"></script>
</head>
<body>
	<div class="row mx-0">
		<div class="col-md-2 menu_left px-1">
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
							<a href="index.php" class="ic_home current">Trang chủ</a>
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
							<a href="component_list.php" class="ic_list ">Danh sách bài đăng</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-10 px-0 menu_right">
			<div class="menu_head py-2 px-4">
				<ul class="ul">
					<li><a href="https://iteaching.000webhostapp.com/Source/login.php" target="_blank"><i class="far fa-hand-point-right mr-2"></i></i>Vào website</a></li>
					<li><a href="logout.php"><i class="fas fa-arrow-left mr-2"></i>Đăng xuất</a></li>
					<li><span><img src="../images/icon/userPic.png" alt=""><p class="pl-2">Xin chào,  <?= $name ?> !</p></span></li>
				</ul>
			</div>
			<div class="boxGrid">
				<div class="title-style"><h3><i class="fas fa-home mr-3"></i>Chào mừng bạn đến với Administrator - HỆ THỐNG QUẢN TRỊ NỘI DUNG WEBSITE !</h3></div>
			</div>
			<div class="px-5 pb-5">
				<img src="../images/1.png" alt="">
				<img src="../images/2.png" alt="">
			</div>
		</div>
	</div>
</body>
<script src="../main.js" type="text/javascript"></script>
</html>

