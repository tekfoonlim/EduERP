<table id="header">
			<tr>
				<td><img src="<?php echo $logo;?>" alt="LOGO"></img></td>
				<td class="cname"><p><?php echo $cname;?></p></td>
				<td>
					<ul>
						<li><a <?php echo 'href="/'.$link.'"';?>>Home</a></li>
						<li><a href="department.php">Departments</a>
							<ul class="submenu">
							<?php
								require "connect.php";
								$sql = "SELECT did, dname FROM department WHERE cid = ".$cid." AND academic = 1 ORDER BY dname";
								$res = mysqli_query($conn, $sql);
								while($row = mysqli_fetch_array($res)){
									echo '<li><a href="department.php?dept='.$row[0].'">'.$row[1].'</a></li>';
								}
								mysqli_close($conn);
							?>
							</ul>
						</li>
						<li><a href="admission.php">Admission</a></li>
						<li><a href="gallery.php">Gallery</a></li>
						<li><a href="student.php">Student Section</a></li>
						<li><a href="staff.php">Staff Section</a></li>
					</ul>
				</td>
			</tr>
		</table>