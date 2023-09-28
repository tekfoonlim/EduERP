<html>
	<head>
		<title><?php echo $cname;?></title>
		<link rel="icon" href=<?php echo '"'.$logo.'"'?> type="image/gif" sizes="16x16">
		<link rel="stylesheet" href="homepage.css"></link>
		<link rel="stylesheet" href="gallery.css"></link>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
	</head>
	<script>
		function openPicture(nm){
			document.getElementById("img").src = nm;
			document.getElementById("disp").style.display = "flex";
		}
	</script>
	<body>
		<?php include "menu.php"; ?>
		<div id="heading">Gallery</div>
		<div class="container">
			<?php
				require "connect.php";
				$sql = "SELECT photo FROM gallery WHERE cid = ".$cid;
				$res = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_array($res)){
					$op = "'".$row[0]."'";
					echo '<img src="'.$row[0].'" onclick="openPicture('.$op.')"></img>';
				}
			?>		
		</div>
		<div id="disp">
			<button onclick="document.getElementById('disp').style.display='none'">X</button>
			<img id="img"></img>
		</div>
	</body>
</html>