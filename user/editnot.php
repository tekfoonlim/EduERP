<?php
	session_start();
	if(isset($_POST['submit'])){
		require "../connect.php";
		$sql = "UPDATE notice SET title = ?, description=?, date = ? WHERE id = ".$_POST['id'];
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br/>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "sss", $_POST['title'], $_POST['desc'], $_POST['date']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=notices");
		exit();
	}
	header("location:/www.eduerp.com/");
?>