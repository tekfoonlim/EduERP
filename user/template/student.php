<html>
	<head>
		<title><?php echo $cname;?></title>
		<link rel="icon" href=<?php echo '"'.$logo.'"'?> type="image/gif" sizes="16x16">
		<link rel="stylesheet" href="homepage.css"></link>
		<link rel="stylesheet" href="student.css"></link>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
	</head>
	<body>
		<?php include "menu.php"; ?>
		<?php
			if(!isset($_POST['roll'])){
				echo '<form method="POST">
					<input type="text" name="roll" placeholder="Enter roll number..." required/>
					<input type="submit" name="submit" value="Submit" />
				</form>';
			}else{
				require "connect.php";
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "SELECT id, name FROM student WHERE cid = ".$cid." AND roll = ?");
				mysqli_stmt_bind_param($stmt, "s", $_POST['roll']);
				mysqli_stmt_execute($stmt);
				$res = mysqli_stmt_get_result($stmt);
				$row = mysqli_fetch_array($res);
				mysqli_stmt_close($stmt);
				if($row){
					$res = mysqli_query($conn, "SELECT code, ttmarks, tfmarks, ptmarks, pfmarks, grade FROM subjects, marks WHERE student = ".$row[0]." AND subjects.id = marks.subject ORDER BY code");
					echo '<table class="marks" border="1">
						<tr class="head"><td colspan="9">'.$row[1].'</td></tr>
						<tr><td>Subject Code</td><td>Theory Total Marks</td><td>Theory Full Marks</td><td>Practical Total Marks</td><td>Practical Full Marks</td><td>Total Marks</td><td>Full Marks</td><td>Percentage</td><td>Grade</td></tr>';
					while($row1 = mysqli_fetch_array($res)){
						echo '<tr><td>'.$row1[0].'</td><td>'.$row1[1].'</td><td>'.$row1[2].'</td><td>'.$row1[3].'</td><td>'.$row1[4].'</td><td>'.$row1[1]+$row1[3].'</td><td>'.$row1[2]+$row1[4].'</td><td>'.number_format((float)(($row1[1]+$row1[3])/($row1[2]+$row1[4]))*100.0, 2, '.', '').'%</td><td>'.$row1[5].'</td></tr>';
					}
					$loc = "'student.php'";
					echo '<tr><td colspan="9"><input type="button" value="Go Back" onclick="window.location.href='.$loc.'"></td></tr>
					</table>';
				}else{
					echo '<p class="error">Roll number not found! Click <a href="student.php">here</a> to go back.</p>';
				}
			}
		?>
	</body>
</html>