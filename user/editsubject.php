<?php
	session_start();
	if(isset($_POST['submit'])){
		require "../connect.php";
		$stmt = mysqli_stmt_init($conn);
		$sql = "UPDATE subjects SET name = ?, code = ?, course = ? WHERE id = ".$_POST['id'];
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "ssi", $_POST['subname1'], $_POST['subcode1'], $_POST['subcourse1']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user/?menu=subject");
		exit();
	}
	header("location:/www.eduerp.com/");
?>