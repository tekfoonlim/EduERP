<?php
	if(!isset($_POST['submit'])){
		header("location:/www.eduerp.com");
		exit();
	}
	require 'connect.php';
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	
	$sql = "SELECT * FROM user WHERE email = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "Error in preparing statement ".$sql;
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		exit();
	}else{
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if(mysqli_stmt_num_rows($stmt)>0){
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header("location:/www.eduerp.com/createaccount.php?error=emailinuse");
			exit();
		}
	}
	$pass = $_POST["password"];
	$password = password_hash($pass, PASSWORD_BCRYPT);
	$mt = -1;
	$sql = "INSERT INTO user (fname, lname, email, pass, cid) VALUES (?, ?, ?, ?, ?)";
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "Error in preparing statement ".$sql;
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		exit();
	}else{		
		mysqli_stmt_bind_param($stmt, "ssssi", $fname, $lname, $email, $password, $mt);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com");
		exit();
	}
?>