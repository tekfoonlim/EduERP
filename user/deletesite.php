<?php
	session_start();
	if(!isset($_SESSION['cid'])||$_SESSION['cid']==-1){
		header("location:/www.eduerp.com");
		exit();
	}
	require '../connect.php';
	$res = mysqli_query($conn, "SELECT link, logo FROM college WHERE cid = ".$_SESSION['cid']);
	$row = mysqli_fetch_row($res);
	$link = $row[0];
	unlink("../../".$link."/admission.css");
	unlink("../../".$link."/admission.php");
	unlink("../../".$link."/application.css");
	unlink("../../".$link."/apply.php");
	unlink("../../".$link."/checkpg.php");
	unlink("../../".$link."/connect.php");
	unlink("../../".$link."/department.php");
	unlink("../../".$link."/gallery.css");
	unlink("../../".$link."/gallery.php");
	unlink("../../".$link."/getpools.php");
	unlink("../../".$link."/homepage.css");
	unlink("../../".$link."/index.php");
	unlink("../../".$link."/menu.php");
	unlink("../../".$link."/staff.php");
	unlink("../../".$link."/staff.css");
	unlink("../../".$link."/logout.php");
	unlink("../../".$link."/marksheet.php");
	unlink("../../".$link."/student.php");
	unlink("../../".$link."/student.css");
	unlink("../../".$link."/".$row[1]);
	$res = mysqli_query($conn, "SELECT * FROM gallery WHERE cid = ".$_SESSION['cid']);
	while($row = mysqli_fetch_assoc($res)){
		unlink("../../".$link."/".$row["photo"]);
	}
	mysqli_query($conn, "DELETE FROM admission WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM college WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM courses WHERE cid = ".$_SESSION['cid']);
	$res = mysqli_query($conn, "SELECT id FROM pools WHERE cid = ".$_SESSION['cid']);
	while($row = mysqli_fetch_array($res)){
		echo $row[0]."<br>";
		mysqli_query($conn, "DELETE FROM coursetopool WHERE pool = ".$row[0]);
		mysqli_query($conn, "DELETE FROM subtopool WHERE pool = ".$row[0]);
	}
	mysqli_query($conn, "DELETE FROM department WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM gallery WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM marks WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM notice WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM pools WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM staff WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM student WHERE cid = ".$_SESSION['cid']);
	mysqli_query($conn, "DELETE FROM subjects WHERE cid = ".$_SESSION['cid']);
	if(!rmdir("../../".$link)){
		echo 'Error in deleting '.$link.'<br>';
		exit();
	}
	$sql = "UPDATE user SET cid = '-1' WHERE email = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'Error in preparing statement'.$sql.'<br/>';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	unlink("../../".$link."/connect.php");
	$_SESSION['cid'] = -1;
	header("location:/www.eduerp.com/user/");
?>