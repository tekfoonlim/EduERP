<?php
	session_start();
	if(isset($_POST['submit'])){
		require "connect.php";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, "SELECT * FROM staff WHERE email = ?")){
			echo "Error in preparing statement<br>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "s", $_POST['email']);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_assoc($res);
		if(!$row){
			echo '<script>alert("Email not found!");</script>';
		}else if($row&&!password_verify($_POST['password'], $row['password'])){
			echo '<script>alert("Wrong email or password entered!");</script>';
		}else{
			$_SESSION['id'] = $row['id'];
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
?>
<html>
	<head>
		<title><?php echo $cname;?></title>
		<link rel="icon" href=<?php echo '"'.$logo.'"'?> type="image/gif" sizes="16x16">
		<link rel="stylesheet" href="homepage.css"></link>
		<link rel="stylesheet" href="staff.css"></link>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
		<script>
			function checkstudent(){
				if(document.getElementById("sid").value=="NULL"){
					alert("Please select a student!");
					return false;
				}
				return true;
			}
		</script>
	</head>
	<body>
		<?php include "menu.php"; ?>
		<?php
			if(!isset($_SESSION['id'])){
				echo '<form method="POST" class="login">
					<table>
						<tr>
							<td colspan="2"><label>E-mail ID : </label></td>
							<td colspan="2"><input type="email" name="email" placeholder="E-Mail ID..." required /></td>
						</tr>
						<tr>
							<td colspan="2"><label>Password : </label></td>
							<td colspan="2"><input type="password" name="password" placeholder="Password..." required /></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2"><input type="submit" name="submit" value="Submit" /></td>
						</tr>
					</table>
				</form>';
			}else{
				require "connect.php";
				$sql = "SELECT * FROM staff WHERE id = ".$_SESSION['id'];
				$res = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($res);
				if($row['mname']==""){
					$name = $row['fname'].' '.$row['lname'];
				}else{
					$name = $row['fname'].' '.$row['mname'].' '.$row['lname'];
				}
				$email = $row['email'];
				$contact = $row['contact'];
				$dob = date("d M, Y", strtotime($row['dob']));
				$salary = $row['salary'];
				$did = $row['did'];
				$res = mysqli_query($conn, "SELECT dname FROM department WHERE cid = ".$cid." AND did = ".$did);
				$row = mysqli_fetch_array($res);
				$loc = "'logout.php'";
				echo '<div class="info">
					<h1>Your information</h1>
					<table>
						<tr><td><label>Name : '.$name.'</label></td></tr>
						<tr><td><label>E-mail : '.$email.'</label</td></tr>
						<tr><td><label>Contact Number : '.$contact.'</label></td></tr>
						<tr><td><label>Date of birth : '.$dob.'</label></td></tr>
						<tr><td><label>Department : '.$row[0].'</label></td></tr>
						<tr><td><label>Salary(INR) : '.$salary.'</label></td></tr>
						<tr><td><input type="button" name="button" value="Log out" onclick="window.location.href='.$loc.'" /></td></tr>
					</table>
				</div>';
				echo '<div class="marks">
					<h1>Set marks</h1>';
					if(isset($_POST['sid'])){
						$res = mysqli_query($conn, "SELECT name FROM student WHERE id = ".$_POST['sid']);
						$row = mysqli_fetch_array($res);
						echo '<form method="POST" action="marksheet.php" style="padding:20px;"><table style="border-collapse:collapse;">
						<input type="hidden" name="id" value="'.$_POST['sid'].'" />
						<input type="hidden" name="cid" value="'.$cid.'" />
						<tr class="name"><td colspan="6">Student Name : '.$row[0].'</td></tr>
						<tr><td>Subject Code</td><td>Theory Total Marks</td><td>Theory Full Marks</td><td>Practical Total Marks</td><td>Practical Full Marks</td><td>Grade</td></tr>';
						$res = mysqli_query($conn, "SELECT DISTINCT subjects.id, subjects.code FROM subjects, subtopool, student WHERE student.id = ".$_POST['sid']." AND (subjects.course = student.course OR ((student.elective1 = subtopool.pool OR student.elective2 = subtopool.pool) AND subtopool.subject = subjects.id)) ORDER BY subjects.code");
						while($row = mysqli_fetch_array($res)){
							$res1 = mysqli_query($conn, "SELECT ttmarks, tfmarks, ptmarks, pfmarks, grade FROM marks WHERE subject = ".$row[0]." AND student = ".$_POST['sid']);
							if(mysqli_num_rows($res1)>0){
								$row1 = mysqli_fetch_array($res1);
								$ttmarks = $row1[0];
								$tfmarks = $row1[1];
								$ptmarks = $row1[2];
								$pfmarks = $row1[3];
								$grade = $row1[4];
							}else{
								$ttmarks = "";
								$tfmarks = "";
								$ptmarks = "";
								$pfmarks = "";
								$grade = "";
							}
							echo '<tr><td><label>'.$row[1].'</label></td><td><input type="number" name="ttmarks[]" value = "'.$ttmarks.'" placeholder="Total theory marks..." required /></td><td><input type="number" name="tfmarks[]" value="'.$tfmarks.'" placeholder="Full theory marks..." required /></td><td><input type="number" name="ptmarks[]" value="'.$ptmarks.'" placeholder="Total practical marks..." required /></td><td><input type="number" name="pfmarks[]" value="'.$pfmarks.'" placeholder="Full practical marks..." required /></td><td><input type="text" name="grade[]" value="'.$grade.'" placeholder="Grade..." required /></td></tr>';
						}
						echo '<tr><td colspan="2"></td><td colspan="2"><input type="submit" name="submit" value="Submit"></td></tr></table></form>';
					}else{
						echo '<table><form onsubmit="return checkstudent()" method="POST">
								<tr><td><label>Select a student : </label></td>
								<td><select id="sid" name="sid">
									<option value="NULL" style="display:none;">Select a student</option>';
							$res = mysqli_query($conn, "SELECT student.id, student.name FROM student, courses WHERE student.cid = ".$cid." AND courses.id = student.course AND courses.did = ".$did);
							while($row = mysqli_fetch_array($res)){
								echo '<option value="'.$row[0].'">'.$row[1].'</option>';
							}
							echo '</select></td></tr>
							<tr><td colspan="2"><input type="submit" name="sub" value="Go" /></td></tr>
						</form></table>';
					}
				echo '</div>';
			}
		?>
	</body>
</html>