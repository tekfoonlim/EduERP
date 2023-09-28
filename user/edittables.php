<?php
	session_start();
	if(isset($_POST['editdept'])){
		require "../connect.php";
		$acad = isset($_POST['acad'])?1:0;
		$sql = "UPDATE department SET dname = ?, description=?, academic=".$acad." WHERE did = ".$_POST['id'];
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
	}else{
		header("location:/www.eduerp.com/user");
	}
	header("location:/www.eduerp.com/");
?>