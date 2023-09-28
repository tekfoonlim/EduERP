<?php
	session_start();
?>
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
		<?php include "menu.php";?>
		<div id="heading">Admission</div>
		<div class="cont">
			<?php
				require "connect.php";
				$res = mysqli_query($conn, "SELECT admission, batch FROM college WHERE cid = ".$cid);
				$row = mysqli_fetch_array($res);
				$loc = "'apply.php'";
				echo '<p class="header2">Admission '.$row[1].'-'.((int)$row[1]+1).'</p>';
				if($row[0]==0)
					echo "<p class='disclaimer'>*NOTE* Admission procedure has ended/not begun yet.</p>";
				else
					echo '<button class="apply" type="button" onclick="window.location.href='.$loc.';">Click here to apply</button>';
			?>
			<p class="title">UG Courses Offered</p><ul>
			<?php
				$res1 = mysqli_query($conn, "SELECT name, description FROM courses WHERE cid = ".$cid." AND pg = 0");
				while($row1 = mysqli_fetch_array($res1)){
					echo '<li>'.$row1[0].'<br><span>'.$row1[1].'</span></li>';
				}
				echo '</ul></div>
					<div class="cont"><p class="title">PG Courses Offered</p><ul>';
				$res1 = mysqli_query($conn, "SELECT name, description FROM courses WHERE cid = ".$cid." AND pg = 1");
				while($row1 = mysqli_fetch_array($res1)){
					echo '<li>'.$row1[0].'<br><span>'.$row1[1].'</span></li>';
				}
				echo '</ul>';
				mysqli_close($conn);
			?>
		</div>
	</body>
</html>