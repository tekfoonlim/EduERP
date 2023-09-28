<?php
	session_start();
	if(isset($_POST['submit'])){
		$sql = "UPDATE staff SET fname = ?, mname = ?, lname = ?, email = ?, contact = ?, dob = ?, salary = ?, did = ? WHERE id = ".$_POST['id'];
		require "../connect.php";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "sssssssi", $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['mail'], $_POST['phno'], $_POST['dob'], $_POST['salary'], $_POST['dept']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=faculty");
		exit();
	}
	header("location:/www.eduerp.com/");
?>