<?php
	if(!isset($_POST['email'])){
		header("location:/www.eduerp.com/");
		exit();
	}
	require 'connect.php';
	$email = $_POST["email"];
	$sql = "SELECT * FROM user WHERE email = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "Error in performing sql statement ".$sql;
		echo '<br>'.mysqli_stmt_error($stmt).'<br>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num = mysqli_stmt_num_rows($stmt);
	if($num==0){
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/?error=usernamenotfound");
		exit();
	}
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
	$pass = $_POST["password"];
	$hash = $row["pass"];
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	if(!password_verify($pass, $hash)){
		header("location:/www.eduerp.com/?error=wrongpassword");
		exit();
	}else{
		session_start();
		$_SESSION['fname'] = $row['fname'];
		$_SESSION['lname'] = $row['lname'];
		$_SESSION['email'] = $email;
		$_SESSION['cid'] = $row['cid'];
		header("location:/www.eduerp.com/user/");
		exit();
	}
?>