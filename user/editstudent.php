<?php
	session_start();
	if(isset($_POST['submit'])){
		require "../connect.php";
		$sql = "SELECT * FROM student WHERE id <> ? AND roll = ? AND cid = ?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "isi", $_POST['id'], $_POST['roll'], $_SESSION['cid']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if(mysqli_stmt_num_rows($stmt)>0){
			header("location:/www.eduerp.com/user/?menu=students&error=rollalreadyused");
			exit();
		}
		$sql = "UPDATE student SET name = ?, gender = ?, roll = ?, email = ?, contact = ?, dob = ?, address = ?, course = ?, elective1 = ?, elective2 = ?, city = ?, state = ?, country = ? WHERE id = ?";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		$gender = $_POST['gender']=="male"?0:1;
		$elec1 = 0;
		if($_POST['elec1']!="")
			$elec1 = $_POST['elec1'];
		$elec2 = 0;
		if($_POST['elec2']!="")
			$elec2 = $_POST['elec2'];
		mysqli_stmt_bind_param($stmt, "sisssssiiisssi", $_POST['name'], $gender, $_POST['roll'], $_POST['mail'], $_POST['contact'], $_POST['dob'], $_POST['address'], $_POST['course'], $elec1, $elec2, $_POST['city'], $_POST['state'], $_POST['country'], $_POST['id']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user/?menu=students");
		exit();
	}
	header("location:/www.eduerp.com/");
?>