<?php
	session_start();
	if(!isset($_POST['submit'])){
		header("location:/www.eduerp.com/user");
		exit();
	}
	require "../connect.php";
	if($_POST['submit']=="Reject"){
		$sql = "UPDATE admission SET status = -1 WHERE id = ".$_POST['id'];
		mysqli_query($conn, $sql);
	}
	if($_POST['submit']=="Accept"){
		$res = mysqli_query($conn, "SELECT id FROM student WHERE roll = '".$_POST['roll']."' AND cid = ".$_SESSION['cid']);
		if(mysqli_num_rows($res)>0){
			header("location:/www.eduerp.com/user/?menu=admission&error=rollalreadyused");
			exit();
		}
		$sql = "SELECT * FROM admission WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($res);
		$sql = "INSERT INTO student(cid, name, roll, gender, dob, yoa, contact, email, address, city, state, country, course, elective1, elective2) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		if($row['mname']=="")
			$name = $row['fname']." ".$row['lname'];
		else
			$name = $row['fname']." ".$row['mname']." ".$row['lname'];
		$gender = 0;
		if($_POST['gender']=="f")
			$gender = 1;
		$yoa = date("Y");
		mysqli_stmt_bind_param($stmt, "issisissssssiii", $_SESSION['cid'], $name, $_POST['roll'], $gender, $row['dob'], $yoa, $row['contact'], $row['mail'], $row['address'], $row['city'], $row['state'], $row['country'], $row['course'], $row['elective1'], $row['elective2']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		$sql = "UPDATE admission SET status = 1 WHERE id = ".$_POST['id'];
		mysqli_query($conn, $sql);
	}
	mysqli_close($conn);
	header("location:/www.eduerp.com/user/?menu=admission");
?>