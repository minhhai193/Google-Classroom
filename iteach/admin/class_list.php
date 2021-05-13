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
			<div class="title-style mt-5"><h4><i class="fas fa-home mr-3"></i>Danh mục lớp học</h4></div>
			<div class="menu_extension  mt-3 mb-4">
				<a href="class_add.php" class="btn_add">Thêm</a>
			</div>
			<div class="boxInsert">
				<table class="data display datatable" id="example">
					<thead>
						<tr class="boxTitle_pd">
							<th id="thutu">No.</th>
							<th >Classroom ID</th>
							<th>Name</th>					
							<th>Description</th>
							<th>Timeline</th>
							<th>Lecture</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody  class="boxPro" id="show_class">
						<?php 
						$get_class = $conn->query("SELECT * FROM classroom");
						$i = 0;
						if($get_class){
							foreach ($get_class as $classroom){
								$i++;	
								if($i%2==0){
									$class="even";
								}
								else{
									$class="odd";
								}
								?>
								<tr class="<?= $class ?>">
									<td id="thutu"><?= $i; ?></td>
									<td id="thutu"><?=$classroom['classroom_id']; ?></td>
									<td id="thutu"><?= $classroom['name'] ?></td>
									<td id="thutu"><?= $classroom['description'] ?></td>
									<td id="thutu"><?= date('d/m/Y ', strtotime($classroom['staring_date'])) ?></td>
									<td id="thutu"><?= $classroom['user_name'] ?></td>
									<td><a id="btn" href="class_edit.php?classroom_id=<?php echo $classroom['classroom_id']; ?>" title="Sửa"><img src="../images/icon/pencil.png" alt="Sửa"></a> <button id="btn_xoa" title="Xoá" onclick="deleteClass(<?= "'".$classroom['classroom_id']."'" ?>);"><img src="../images/icon/close.png" alt="Xoá"></button></td>
								</tr> 
								<?php 
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</body>
<script src="../main.js" type="text/javascript"></script>
</html>
