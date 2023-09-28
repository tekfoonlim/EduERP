<html>
	<head>
		<title><?php echo $cname;?></title>
		<link rel="icon" href=<?php echo '"'.$logo.'"'?> type="image/gif" sizes="16x16">
		<link rel="stylesheet" href="homepage.css"></link>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
	</head>
	<body>
		<?php include "menu.php"; ?>
		<?php
			require "connect.php";
			$sql = "SELECT photo FROM gallery WHERE cid = ".$cid." AND cover = 1";
			$res = mysqli_query($conn, $sql);
			if(mysqli_num_rows($res)>0){
				$row = mysqli_fetch_array($res);
				$img = "url('".$row[0]."')";
			}else{
				$img = "";
			}
			mysqli_close($conn);
		?>
		<div <?php echo 'style="background-image:'.$img.';background-size:cover;background-position:center;filter:blur(3px);"';?> id="bg-container">
		</div>
		<p id="text" style="z-index:5"><?php echo $cname;?></p>
		<div id="notices">
			<p>Notices</p>
			<?php
				require "connect.php";
				$sql = "SELECT * FROM notice WHERE cid = ".$cid." ORDER BY date DESC";
				$res = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_assoc($res)){
					echo '<table>
						<tr class="title">
							<td>'.$row["title"].'</td>
						</tr>
						<tr class="description">
							<td>'.$row["description"].'</td>
						</tr>
						<tr class="date">
							<td>'.date('jS M, Y', strtotime($row["date"])).'</td>
						</tr>
					</table>';
				}
				mysqli_close($conn);
			?>
		</div>
	</body>
</html>