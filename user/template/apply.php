<?php
	if(isset($_POST['submit'])){
		require "connect.php";
		$gender = $_POST['gender']=='m'?0:1;
		$gcol = "";
		if(isset($_POST['gcol']))
			$gcol = $_POST['gcol'];
		$gmarks = 0;
		if(isset($_POST['gmarks']))
			$gmarks = $_POST['gmarks'];
		$elective1 = 0;
		$elective2 = 0;
		if(isset($_POST['pool1']))
			$elective1 = $_POST['pool1'];
		if(isset($_POST['pool2']))
			$elective2 = $_POST['pool2'];
		$sql = "INSERT INTO admission(cid, fname, mname, lname, gender, dob, contact, mail, address, city, state, country, course, elective1, elective2, school10, marks10, school12, marks12, gcol, gmarks, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0)";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "isssisssssssiiisisisi", $cid, $_POST['fname'], $_POST['mname'], $_POST['lname'], $gender, $_POST['dob'], $_POST['phno'], $_POST['mail'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['country'], $_POST['course'], $elective1, $elective2, $_POST['school10'], $_POST['c10'], $_POST['school12'], $_POST['c12'], $gcol, $gmarks);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:apply.php?status=success");
	}
?>
<html>
	<head>
		<title><?php echo $cname;?></title>
		<link rel="icon" href=<?php echo '"'.$logo.'"'?> type="image/gif" sizes="16x16">
		<link rel="stylesheet" href="homepage.css"></link>
		<link rel="stylesheet" href="admission.css"></link>
		<link rel="stylesheet" href="application.css"></link>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
	</head>
	<script>
		function myfunction(str){
			getPools(str);
			checkPG(str);
		}
		function getPools(str){
			var x = document.getElementsByClassName("pools");
			for(var i=x.length-1; i>=0; i--)
				x[i].remove();
			var xhttp;
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					document.getElementById("dummy").outerHTML += this.responseText;
				}
			};
			xhttp.open("GET", "getpools.php?id="+str, true);
			xhttp.send();
		}
		function checkPG(str){
			var x = document.getElementsByClassName("del");
			for(var i=x.length-1; i>=0; i--)
				x[i].remove();
			
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					document.getElementById("grad").outerHTML += this.responseText;
				}
			};
			xhttp.open("GET", "checkpg.php?id="+str, true);
			xhttp.send();
		}
		function checkCourse(){
			if(document.getElementById("course").value == 0){
				alert("Please select a course!");
				return false;
			}
			return true;
		}
	</script>
	<body>
		<?php include "menu.php"; ?>
		<div id="heading">Application Form</div>
		<form method="POST" action="apply.php" onsubmit="return checkCourse()">
			<h1>Enter your details</h1>
			<table>
				<tr>
					<td><label for="fname">First Name*</label></td>
					<td><label for="mname">Middle Name</label></td>
					<td><label for="lname">Last Name*</label></td>
				</tr>
				<tr>
					<td><input type="text" id="fname" name="fname" placeholder="First name..." required /></td>
					<td><input type="text" id="mname" name="mname" placeholder="Middle name..." /></td>
					<td><input type="text" id="lname" name="lname" placeholder="Last name..." required /></td>
				</tr>
				<tr>
					<td><label>Gender* </td>
					<td><label for="male">Male : </label><input type="radio" id="male" name="gender" value="m" checked /></td>
					<td><label for="female">Female : </label><input type="radio" id="female" name="gender" value="f" /></td>
				</tr>
				<tr>
					<td><label for="dob">Date of birth* : </label></td>
					<td><input type="date" name="dob" id="dob" required /></td>
				</tr>
				<tr>
					<td><label for="phno">Contact number* : </label></td>
					<td><input type="tel" name="phno" id="phno" placeholder="Contact number..." required /></td>
				</tr>
				<tr>
					<td><label for="mail">E-Mail* : </label></td>
					<td><input type="email" name="mail" id="mail" placeholder="E-Mail..." required /></td>
				</tr>
				<tr>
					<td><label for="address">Address* : </label></td>
					<td colspan="2"><textarea rows="3" id="address" name="address" placeholder="Address..." required></textarea></td>
				</tr>
				<tr>
					<td><label for="city">City*</label></td>
					<td><label for="state">State*</label></td>
					<td><label for="country">Country*</label></td>
				</tr>
				<tr>
					<td><input type="text" name="city" id="city" placeholder="City..." required /></td>
					<td><input type="text" name="state" id="state" placeholder="State..." required /></td>
					<td><input type="text" name="country" id="country" placeholder="Country..." required /></td>
				</tr>
				<tr>
					<td><label for="course">Select Course* : </label></td>
					<td colspan="2"><select onchange="myfunction(this.value)" id="course" name="course">
						<option value="0" style="display:none">Select course</option>
						<?php
							require "connect.php";
							$sql = "SELECT id, name FROM courses WHERE cid = ".$cid;
							$res = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_array($res)){
								echo '<option value="'.$row[0].'">'.$row[1].'</option>';
							}
						?>
					</select></td>
				</tr>
				<tr id="dummy" style="display:none"></tr>
				<tr><td><label for="school10">School and Percentage(Class 10th) : </label></td>
				<td><input type="text" name="school10" id="school10" placeholder="School name..." required /></td>
				<td><input type="number" name="c10" id="c10" placeholder="Class 10th percentage..." required /></td></tr>
				<tr><td><label for="school10">School and Percentage(Class 12th) : </label></td>
				<td><input type="text" name="school12" id="school12" placeholder="School name..." required /></td>
				<td><input type="number" name="c12" id="c12" placeholder="Class 12th percentage..." required /></td></tr>
				<tr id="grad"></tr>
				<tr>
					<td>
					<td><input type="submit" name="submit" value="Submit" /></td>
					<td>
				</tr>
			</table>
		</form>
	</body>
</html>