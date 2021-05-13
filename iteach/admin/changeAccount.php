<?php 
	require_once "../client/database.php";

	$conn = connection();

	function catchuoi($chuoi,$gioihan){
	// nếu độ dài chuỗi nhỏ hơn hay bằng vị trí cắt
	// thì không thay đổi chuỗi ban đầu
		if(strlen($chuoi)<=$gioihan)
		{	
			return $chuoi;
		}
		else{
		/*
		so sánh vị trí cắt
		với kí tự khoảng trắng đầu tiên trong chuỗi ban đầu tính từ vị trí cắt
		nếu vị trí khoảng trắng lớn hơn
		thì cắt chuỗi tại vị trí khoảng trắng đó
		*/
		if(strpos($chuoi," ",$gioihan) > $gioihan){
			$new_gioihan=strpos($chuoi," ",$gioihan);
			$new_chuoi = substr($chuoi,0,$new_gioihan)."...";
			return $new_chuoi;
		}
			// trường hợp còn lại không ảnh hưởng tới kết quả
			$new_chuoi = substr($chuoi,0,$gioihan)."...";
			return $new_chuoi;
		}
	}

	if(isset($_POST['userid']) && isset($_POST['action']) && isset($_POST['classroomid'])){
		$user_id = $_POST['userid'];
		$action = $_POST['action'];
		$classroom_id = $_POST['classroomid'];
		if($action=="ON"){
			$change = $conn->query("UPDATE people SET passed = 1 WHERE user_id = $user_id AND classroom_id = '$classroom_id' AND passed = 0 ");
		}else{
			$change = $conn->query("UPDATE people SET passed = 0 WHERE user_id = $user_id AND classroom_id =  '$classroom_id' AND passed = 1 ");
		}
		
	}

	if(isset($_POST['user_id'])){
		$user_id = $_POST['user_id'];
		$classroom_id = $conn->query("SELECT * FROM classroom WHERE user_id = $user_id");
		$classroom_id = mysqli_fetch_assoc($classroom_id);
		$classroom_id = $classroom_id["classroom_id"];
		echo $classroom_id;
		$del = $conn->query("DELETE FROM submission WHERE classroom_id = '$classroom_id'");
		$del = $conn->query("DELETE FROM people WHERE classroom_id = '$classroom_id'");
		$del = $conn->query("DELETE FROM component WHERE classroom_id = '$classroom_id'");
		$del = $conn->query("DELETE FROM classroom WHERE classroom_id = '$classroom_id'");
		$del = $conn->query("DELETE FROM account WHERE user_id = $user_id");
		$get_user = $conn->query("SELECT * FROM account");
		$i = 0;
		if($get_user){
			foreach ($get_user as $user){
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
					<td id="tensp"><?= $user['username'] ?></td>
					<td id="tensp"><?= $user['email'] ?></td>
					<td id="tensp"><?= $user['name'] ?></td>
					<td id="role"><?= $user['role'] ?></td>
					<td id="tk<?=$user['user_id'] ?>">
						<?php
						if($user['active']==1){
							?>
							<button id="btn_on" onclick="changeType(this.id,<?= $user['user_id'] ?>);">ON</button> 
							<?php
						}else{
							?>	
							<button id="btn_off" onclick="changeType(this.id,<?= $user['user_id'] ?>);">OFF</button> 
							<?php
						}
						?>
					</td>
					<td id="xuly"><button title="Xoá" onclick="deleteUser(<?= $user['user_id'] ?>);"><img src="../images/icon/close.png" alt="Xoá"></button></td>
				</tr>
				<?php 
			}
		}
	}

	if(isset($_POST['classroom_id'])){
		$classroom_id = $_POST['classroom_id']; 
		$del = $conn->query("DELETE FROM classroom WHERE classroom_id = '$classroom_id'");
        $sql = "DELETE FROM people WHERE classroom_id='$classroom_id'";
        $conn->query($sql);
        $sql = "DELETE FROM submission WHERE classroom_id='$classroom_id'";
        $conn->query($sql);
        $sql = "DELETE FROM component WHERE classroom_id='$classroom_id'";
        $conn->query($sql);
        $sql = "DELETE FROM comment WHERE classroom_id='$classroom_id'";
        $conn->query($sql);
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
	}

	if(isset($_POST['component_id'])){
		$component_id = $_POST['component_id']; 
		$del = $conn->query("DELETE FROM component WHERE component_id = '$component_id'");
		$sql = "DELETE FROM comment WHERE component_id=$component_id AND classroom_id='$classroom_id'";
        $conn->query($sql);
		$get_component = $conn->query("SELECT * FROM component");
		$i = 0;
		if($get_component){
			foreach ($get_component as $component){
				$get_user = $conn->query("SELECT * FROM account WHERE user_id = ".$component['user_id']."");
				$get_user = $get_user -> fetch_assoc();
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
					<td id="thutu"><?= $component['classroom_id'] ?></td>
					<td id="thutu"><?= catchuoi($get_user['name'],15) ?></td>
					<td id="thutu"><?= catchuoi($component['content'],10) ?></td>
					<td id="thutu"><?= $component['type'] ?></td>
					<td id="thutu"><?= date('d/m/Y ', strtotime($component['timeline'])) ?></td>
					<td id="thutu"><?= date('d/m/Y ', strtotime($component['deadline'])) ?></td>
					<td id="thutu"><?= catchuoi($component['title'],12) ?></td>
					<td id="thutu"><?= catchuoi($component['submission'],10) ?></td>
					<td><a id="btn" href="component_edit.php?component_id=<?php echo $component['component_id']; ?>" title="Sửa"><img src="../images/icon/pencil.png" alt="Sửa"></a> <button id="btn_xoa" title="Xoá" onclick="deleteComponent(<?= "'".$component['component_id']."'" ?>);"><img src="../images/icon/close.png" alt="Xoá"></button></td>
				</tr> 
				<?php 
			}
		}
	}
?>