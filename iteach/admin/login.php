<?php 
	require_once "../client/database.php";

	$code = 0;
	$username = '';
	$password = '';
	$error = '';

	if (isset($_COOKIE["PHPSID"])) {
		$token = $_COOKIE["PHPSID"];

		$conn = connection();

		$sql = "SELECT username FROM account WHERE token='$token'";
		$rows = $conn->query($sql);

		if ($rows->num_rows > 0) {
			while ($row = $rows->fetch_assoc()) {
				$username = $row["username"];
			}
		}
	}

	if (isset($_POST["signin"])) {
		if (isset($_POST["username"]) and isset($_POST["password"])) {
			$username = $_POST["username"];
			$password = $_POST["password"];

			if (empty($username)) {
				$error = "Please enter your username";
			}
			else if (empty($password)) {
				$error = "Please enter your password";
			}
			else {
				if (login($username, $password) == 1) {
					$error = "Invalid username/ password";
				}
				else {
					$conn = connection();
					
					$sql = "SELECT role FROM account WHERE username='$username'";
					$result = $conn->query($sql);
					$result = mysqli_fetch_assoc($result);
					if ($result["role"] == 0) {
						session_start();

						$sql = "SELECT token FROM account WHERE username='$username'";
						$rows = $conn->query($sql);

						if ($rows->num_rows > 0) {
							while ($row = $rows->fetch_assoc()) {
								$token = $row["token"];
							}
						}

						$_SESSION["SESSID"] = $token;

						if (isset($_POST["remember-me"])) {
							setcookie("PHPSID", $token, time() + 86400);
						}

						header("location: index.php");
					}
					else {
						$error = "Invalid username/ password";
					}
				}
			}
		}
	}      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="/../style.css" media="screen" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body id="bodyMain">
<div class="main container" id="admin">		
	<div class="w3layouts-main">
		<h2 class="py-4"><span>LOGIN ADMIN</span></h2>
		<form action="login.php" method="post">
			<input type="username" placeholder="Username" name="username" autocomplete="off">
			<input type="password" placeholder="Password"  name="password"/>
			<input type="submit" value="LOGIN" name="signin"/>
		</form>
		<p class="error"><?= $error ?></p>
	</div>
		
</div>
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</html>
