<html>
	<head>
		<title><?php echo $cname;?></title>
		<link rel="icon" href=<?php echo '"'.$logo.'"'?> type="image/gif" sizes="16x16">
		<link rel="stylesheet" href="homepage.css"></link>
		<link rel="stylesheet" href="admission.css"></link>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
	</head>
	<body>
		<?php include "menu.php"; ?>
		<div id="heading">Departments</div>
		<?php
			require "connect.php";
			$sql = "SELECT * FROM department WHERE cid = ".$cid." AND academic = 1";
			$res = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($res)){
				if(!isset($_GET['dept'])||$_GET['dept']==$row['did']){
					echo '<div style="border-bottom:2px solid rgb(200,0,0)" class="cont">
						<p class="title">Department of '.$row['dname'].'</p><br>
						<p class="desc">'.$row['description'].'</p><br>
						<p style="font-size:30px;" class="title">Courses offered</p><ul>';
				$sql = "SELECT name FROM courses WHERE did = ".$row['did'];
				$res1 = mysqli_query($conn, $sql);
				while($row1 = mysqli_fetch_array($res1)){
					echo '<li style="margin-bottom:2px;">'.$row1[0].'</li>';
				}
				echo '</ul></div>';
				}
			}
		?>
	</body>
</html>