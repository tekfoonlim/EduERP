<?php
	session_start();
	if(!isset($_SESSION['cid'])||$_SESSION['cid']==-1||!isset($_GET['x'])||!isset($_GET['id'])){
		header("location:/www.eduerp.com/");
		exit();
	}
	switch($_GET['x']){
		case '1' :	$sql = "DELETE FROM department WHERE did = ".$_GET['id'];
					require "../connect.php";
					mysqli_query($conn, $sql);
					$sql = "SELECT id FROM courses WHERE did = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_array($res)){
						mysqli_query($conn, "DELETE FROM coursetopool WHERE course = ".$row[0]);
						$res1 = mysqli_query($conn, "SELECT id FROM subject WHERE course = ".$row[0]);
						while($row1 = mysqli_fetch_array($res1)){
							mysqli_query($conn, "DELETE FROM subtopool WHERE subject = ".$row1[0]);
							mysqli_query($conn, "DELETE FROM marks WHERE subject = ".$row1[0]);
						}
						mysqli_query($conn, "DELETE FROM subject WHERE course = ".$row[0]);
					}
					$sql = "DELETE FROM courses WHERE did = ".$_GET['id'];
					mysqli_query($conn, $sql);
					$sql = "DELETE FROM staff WHERE did = ".$_GET['id'];
					mysqli_query($conn, $sql);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user/?menu=departments");
					break;
		case '2' :	$sql = "SELECT link FROM college WHERE cid = ".$_SESSION['cid'];
					require "../connect.php";
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_array($res);
					$link = $row[0];
					$sql = "SELECT photo FROM gallery WHERE id = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_array($res);
					$photo = $row[0];
					unlink("../../".$link."/".$photo);
					$sql = "DELETE FROM gallery WHERE id = ".$_GET['id'];
					mysqli_query($conn, $sql);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user?menu=gallery");
					break;
		case '3' :	$sql = "DELETE FROM notice WHERE id = ".$_GET['id'];
					require "../connect.php";
					mysqli_query($conn, $sql);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user?menu=notices");
					break;
		case '4' :	$sql = "DELETE FROM staff WHERE id = ".$_GET['id'];
					require "../connect.php";
					mysqli_query($conn, $sql);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user?menu=faculty");
					break;
		case '5' :	require "../connect.php";
					mysqli_query($conn, "DELETE FROM courses WHERE id = ".$_GET['id']);
					mysqli_query($conn, "DELETE FROM coursetopool WHERE course = ".$_GET['id']);
					$res = mysqli_query($conn, "SELECT id FROM subjects WHERE course = ".$_GET['id']);
					while($row = mysqli_fetch_array($res)){
						mysqli_query($conn, "DELETE FROM subtopool WHERE subject = ".$row[0]);
						mysqli_query($conn, "DELETE FROM marks WHERE subject = ".$row[0]);
					}
					mysqli_query($conn, "DELETE FROM subjects WHERE course = ".$_GET['id']);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user?menu=courses");
					break;
		case '6' :	require "../connect.php";
					mysqli_query($conn, "DELETE FROM subjects WHERE id = ".$_GET['id']);
					mysqli_query($conn, "DELETE FROM subtopool WHERE subject = ".$_GET['id']);
					mysqli_query($conn, "DELETE FROM marks WHERE subject = ".$_GET['id']);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user/?menu=subject");
					break;
		case '7' :	require "../connect.php";
					$sql = "DELETE FROM pools WHERE id = ".$_GET['id'];
					mysqli_query($conn, $sql);
					$sql = "DELETE FROM subtopool WHERE pool = ".$_GET['id'];
					mysqli_query($conn, $sql);
					$sql = "DELETE FROM coursetopool WHERE pool = ".$_GET['id'];
					mysqli_query($conn, $sql);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user/?menu=subject");
					break;
		case '8' :	require "../connect.php";
					mysqli_query($conn, "DELETE FROM marks WHERE student = ".$_GET['id']);
					mysqli_query($conn, "DELETE FROM student WHERE id = ".$_GET['id']);
					mysqli_close($conn);
					header("location:/www.eduerp.com/user/?menu=students");
					break;
		default : header("location:/www.eduerp.com/");
	}
	exit();
?>