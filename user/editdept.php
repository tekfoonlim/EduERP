<?php
	session_start();
	if(isset($_POST['submit'])){
		require "../connect.php";
		$acad = 0;
		if(isset($_POST['acad'])){
			$acad = 1;
		}
		$sql = "UPDATE department SET dname = ?, description=? academic=".$acad." WHERE did = ".$_POST['id'];
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br/>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "ss", $_POST['dname'], $_POST['desc']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=departments");
		exit();
	}
	header("location:/www.eduerp.com/");
?>