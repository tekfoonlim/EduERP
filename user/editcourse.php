<?php
	session_start();
	if(isset($_POST['submit'])){
		require "../connect.php";
		$sql = "UPDATE courses SET did = ?, name=?, description = ?, terms = ?, duration = ?, pg = ? WHERE id = ?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br/>";
			exit();
		}
		$pg = $_POST['grad']=='pg'?1:0;
		mysqli_stmt_bind_param($stmt, "issiiii", $_POST['dept'], $_POST['cname'], $_POST['description'], $_POST['terms'], $_POST['dur'], $pg, $_POST['id']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=courses");
		exit();
	}
	header("location:/www.eduerp.com/user");
?>