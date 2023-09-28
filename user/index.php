<?php
	session_start();
	if(isset($_SESSION['email'])&&!isset($_SESSION['cid'])){
		require "../connect.php";
		$sql = "SELECT cid FROM user WHERE email = ?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$_SESSION['cid'] = $row['cid'];
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
	$cur = "settings";
	if(isset($_GET['menu'])){
		$cur = $_GET['menu'];
	}
?>
<html>
	<head>
		<title>EduERP</title>
		<link rel="stylesheet" href="/www.eduerp.com/CSS/user.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script>
			function toggleoptions(x){
				if(x==0){
					document.getElementById("optionbox").style.display = "none";
				}else{
					document.getElementById("optionbox").style.display = "block";
				}
			}
			function check_course_form(){
				if(document.getElementById("dept").value == "0"){
					alert("Please select a department!");
					return false;
				}
				return true;
			}
			function checkdel(x, y){
				switch(x){
					case 1: if(confirm("Are you sure you want to delete this all information related to this department?"))
								break;
							else
								return;
					case 2: if(confirm("Are you sure you want to delete this photo?"))
								break;
							else
								return;
					case 3: if(confirm("Are you sure you want to delete this notice?"))
								break;
							else
								return;
					case 4: if(confirm("Are you sure you want to delete this staff member's details?"))
								break;
							else
								return;
					case 5: if(confirm("Are you sure you want to delete all information related to this course?"))
								break;
							else
								return;
					case 6: if(confirm("Are you sure you want to delete all information related to this subject?"))
								break;
							else
								return;
					case 7: if(confirm("Are you sure you want to delete this pool?"))
								break;
							else
								return;
					case 8: if(confirm("Are you sure you want to delete this student's details?"))
								break;
							else
								return;
					default : return;
				}
				window.location.href="deleteitems.php?id="+y+"&x="+x;
			}
			function reducebrightness(i){
				var el = document.getElementsByClassName("img");
				el[i].style.filter = "brightness(50%)";
			}
			function increasebrightness(i){
				var el = document.getElementsByClassName("img");
				el[i].style.removeProperty("filter");
			}
			function verifyimage(){
				var photo = document.getElementById("photo");
				var ext = photo.files[0].name.substring(photo.files[0].name.lastIndexOf("."));
				if(photo.files[0].size > 2097152){
					alert("Size of image is too big (>2MB)");
					return false;
				}else if(ext != ".jpg" && ext != ".png" && ext != ".jpeg"){
					alert("Invalid file extension uploaded!");
					return false;
				}
				return true;
			}
			function checkcourse(x){
				if((x==1&&document.getElementById("course").value == "0")||(x==2&&document.getElementById("course1").value=="0")){
					alert("Please select a course!");
					return false;
				}
				return true;
			}
			function closeedit(){
				var lnk = window.location.href;
				lnk = lnk.substring(0, lnk.search("&"));
				window.location.href = lnk;
			}
			function openform(x){
				if(x==0){
					document.getElementById("depform").style.display = "flex";
				}else if(x==1){
					document.getElementById("courseform").style.display = "flex";
				}else if(x==2){
					document.getElementById("notform").style.display = "flex";
				}else if(x==3){
					document.getElementById("galform").style.display = "flex";
				}else if(x==4){
					document.getElementById("facultyform").style.display = "flex";
				}else if(x==5){
					document.getElementById("subform").style.display = "flex";
				}else if(x==6){
					document.getElementById("poolform").style.display = "flex";
				}else if(x==7){
					document.getElementById("studentform").style.display = "flex";
				}
			}
			function closeform(x){
				if(x==0){
					document.getElementById("depform").style.display = "none";
				}else if(x==1){
					document.getElementById("courseform").style.display = "none";
				}else if(x==2){
					document.getElementById("notform").style.display = "none";
				}else if(x==3){
					document.getElementById("galform").style.display = "none";
				}else if(x==4){
					document.getElementById("facultyform").style.display = "none";
				}else if(x==5){
					document.getElementById("subform").style.display = "none";
				}else if(x==6){
					document.getElementById("poolform").style.display = "none";
				}else if(x==7){
					document.getElementById("studentform").style.display = "none";
				}
			}
			function checkroll(){
				if(document.getElementById("admitroll").value == ""){
					alert("Please enter roll number!");
					return false;
				}
				return true;
			}
			function getPools(str){
				var x = document.getElementsByClassName("pools");
				for(var i=x.length-1; i>=0; i--)
					x[i].remove();
				var xhttp;
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						var x = document.getElementsByClassName("dummy");
						x[x.length-1].outerHTML += this.responseText;
					}
				};
				xhttp.open("GET", "getpools.php?id="+str, true);
				xhttp.send();
			}
			function myfunction(str){
				getPool1(str);
				getPool2(str);
			}
			function getPool1(str){
				var x = document.getElementById("elec1");
				x.innerHTML = "";
				var xhttp;
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						x.innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "getpool1.php?id="+str, true);
				xhttp.send();
			}
			function getPool2(str){
				var x = document.getElementById("elec2");
				x.innerHTML = "";
				var xhttp;
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						x.innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "getpool2.php?id="+str, true);
				xhttp.send();
			}
		</script>
	</head>
	<body>
		<img src="/www.eduerp.com/bg.jfif" id="bg"></img>
		<div id="header"><span style="color:rgb(50,205,50)">Edu</span><span style="color:#FF7F50">ERP</span>
			<div id="menu">
				<ul>
					<li><a href="/www.eduerp.com">Home</a></li>
					<li><a href="/www.eduerp.com/logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
		<div class="content">
			<div id="side_menu">
				<ul>
					<?php
						if($_SESSION['cid']==-1){
							echo '
								<li id="cur"><a href="#">Set up</a></li>
							';
						}else{
							require "../connect.php";
							$sql = "SELECT link FROM college WHERE cid = ".$_SESSION['cid'];
							$res = mysqli_query($conn, $sql);
							$row = mysqli_fetch_array($res);
							mysqli_close($conn);
							echo '<li';
							if($cur=="settings"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=settings">User Settings</a></li><li';
							if($cur=="departments"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=departments">Departments</a></li><li';
							if($cur=="courses"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=courses">Courses</a></li><li';
							if($cur=="subject"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=subject">Subject</a></li><li';
							if($cur=="notices"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=notices">Notices</a></li><li';
							if($cur=="admission"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=admission">Admission</a></li><li';
							if($cur=="faculty"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=faculty">Faculty</a></li><li';
							if($cur=="students"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=students">Students</a></li><li';
							if($cur=="gallery"){
								echo ' id="cur"';
							}
							echo '><a href="/www.eduerp.com/user?menu=gallery">Gallery</a></li>
								<li><a href="/'.$row[0].'" target="_blank">Go to site</a></li>
								<li><a href="#" onclick="toggleoptions(1)">Delete site</a></li>
							';
						}
					?>
				</ul>
			</div>
			<?php
				if($_SESSION['cid']==-1){
					echo '
					<form style="margin-left:30%;margin-top:10px;" method="post" action="submitdata.php" enctype="multipart/form-data">
						<table>
							<h1>Enter college details</h1>
							<tr>
								<td colspan="6"><label for="cname">Enter college name</label></td>
							</tr>
							<tr>
								<td colspan="6"><input type="text" id="cname" name="cname" placeholder="College name..." required /></td>
							</tr>
							<tr>
								<td colspan="6"><label for="clink">Enter college URL</label></td>
							</tr>
							<tr>
								<td colspan="1">www.</td>
								<td colspan="4"><input type="text" id="clink" name="clink" placeholder="URL..." required /></td>
								<td colspan="1">
									<select name="dom">
										<option value=".com">.com</option>
										<option value=".college">.college</option>
										<option value=".edu">.edu</option>
										<option value=".uni">.uni</option>
										<option value=".university">.university</option>
										<option value=".academy">.academy</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="3"><label for="logo">Upload logo:</label></td>
								<td colspan="3"><input type="file" accept="image/png, image/jpeg" name="logo" id="logo" required/></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4"><input type="submit" name="createcollege" value="Submit"/></td>
							</tr>
						</table>
					</form>
					';
				}else if(!isset($_GET['menu'])||$_GET['menu']=="settings"){
					require "../connect.php";
					$res = mysqli_query($conn, "SELECT * FROM college WHERE cid = ".$_SESSION['cid']);
					$row = mysqli_fetch_assoc($res);
					$link = substr($row['link'], 4);
					$lname = substr($link, 0, strpos($link, "."));
					$rname = substr($link, strpos($link, ".")+1);
					$yoa = "";
					if($row["batch"]!="")
						$yoa = 'value="'.$row['batch'].'"';
					$adm = "";
					if($row['admission']==1)
						$adm = "checked";
					echo '<table style="table-layout:fixed;" id="tbl" cellspacing="0"><form method="post" action="submitdata.php" enctype="multipart/form-data">
							<tr><td colspan="8" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">College Details</td></tr>
							<tr>
								<td colspan="2"><label for="cname">College name : </label></td>
								<td colspan="6"><input type="text" id="cname" name="cname" placeholder="College name..." value="'.$row['cname'].'" required /></td>
							</tr>
							<tr>
								<td colspan="2"><label for="clink">URL : </label></td>
								<td colspan="1" style="text-align:right;">www.</td>
								<td colspan="4"><input type="text" id="clink" name="clink" placeholder="URL..." value="'.$lname.'" required /></td>
								<td colspan="1">
									<select name="dom">
										<option value=".com" ';
										if($rname=="com"){
											echo ' selected ';
										}
										echo '>.com</option>
										<option value=".college"';
										if($rname=="college"){
											echo ' selected ';
										}
										echo '>.college</option>
										<option value=".edu"';
										if($rname=="edu"){
											echo ' selected ';
										}
										echo '>.edu</option>
										<option value=".uni"';
										if($rname=="uni"){
											echo " selected ";
										}
										echo '>.uni</option>
										<option value=".university"';
										if($rname=="university"){
											echo ' selected ';
										}
										echo '>.university</option>
										<option value=".academy"';
										if($rname=="academy"){
											echo ' selected ';
										}
										echo '>.academy</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2"><label for="logo">Logo : </label></td>
								<td colspan="3"><input type="file" accept="image/png, image/jpeg" name="logo" id="logo" required/></td>
								<td><label for="curlogo">Current Logo : </label></td>
								<td colspan="2"><img id="curlogo" style="border:2px solid black;padding:10px;height:100px;" src="../../'.$row['link'].'/'.$row['logo'].'"></img></td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="4"><input type="submit" name="editcollege" value="Update"/></td>
							</tr>
						</form></table>						
						<table style="table-layout:fixed;" id="tbl" cellspacing="0"><form method="post" action="submitdata.php">
							<tr><td colspan="4" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Admission control panel</td></tr>
							<tr>
								<td colspan="2"><label for="admissionswitch">Enable/disable admission : </label></td>
								<td colspan="2"><label style="width:60px" class="switch">
								  <input name="adm" id="admissionswitch" type="checkbox" '.$adm.'>
								  <span class="slider round"></span>
								</label></td>
							</tr>
							<tr>
								<td colspan="2"><label for="yearofadmission">Year of admission : </label></td>
								<td colspan="2"><input style="text-align:center;" type="number" name="yoa" id="yoa" placeholder="Year of admission..." '.$yoa.' required /></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><input type="submit" name="admissiondata" value="Update" /></td>
							</tr>
						</form></table>';
					mysqli_close($conn);
				}else if($_GET['menu']=="departments"){
					require '../connect.php';
					$sql = "SELECT * FROM department WHERE cid = ".$_SESSION['cid']." ORDER BY dname";
					$res = mysqli_query($conn, $sql);
					echo '
						<div class="cont" id="depform">
							<form method="POST" action="submitdata.php">
								<button type="button" class="close" onclick="closeform(0)">X</button>
								<table>
									<h1>Enter department details</h1>
									<tr>
										<td colspan="2"><label for="dname">Department name : </label></td>
										<td colspan="2"><input type="text" name="dname" id="dname" placeholder="Department name..." required /></td>
									</tr>
									<tr>
										<td colspan="2"><label for="desc">Department description : </label></td>
										<td colspan="2"><textarea placeholder="Description..." rows="3" id="desc" name="desc" required></textarea></td>
									</tr>
									<tr>
										<td colspan="2"><label for="acad">Academic department : </label></td>
										<td colspan="2"><input type="checkbox" id="acad" name="acad" checked /></td>
									</tr>
									<tr>
										<td>
										<td colspan="2"><input type="submit" name="createdept" value="Submit"/></td>
									</tr>
								</table>
							</form>
						</div>
						<table border="2" id="tbl" cellspacing="0">
							<tr><td colspan="5" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Departments<button type="button" class="but" onclick="openform(0)"><b style="margin-right:3px;">+</b>Add Department</button></td></tr>
							<tr class="bold">
								<td>Department Name</td>
								<td>Department Description</td>
								<td>Academic</td>
								<td colspan="2">Action</td>
							</tr>';
					while($row = mysqli_fetch_assoc($res)){
						$oc = "window.location.href='/www.eduerp.com/user/?menu=departments&id=".$row['did']."'";
						echo '<tr><td>'.$row['dname'].'</td><td style="text-align:justify;">'.$row['description'].'</td><td>';
						if($row['academic']==0){
							echo "No";
						}else{
							echo "Yes";
						}
						echo '</td><td><button type="button" style="padding:8px;cursor:pointer;background-color:rgb(220,220,20);color:white;border:none;border-radius:5px;" onclick="'.$oc.'">Edit</button></td><td><button type="button" style="padding:8px;cursor:pointer;background-color:rgb(250,20,20);color:white;border:none;border-radius:5px;" onclick="checkdel(1, '.$row['did'].')">Delete</button></tr>';
					}
					echo '</table>';
					mysqli_close($conn);
				}else if($_GET['menu']=="courses"){
					require "../connect.php";
					$sql = "SELECT * FROM department WHERE cid = ".$_SESSION['cid']." ORDER BY dname";
					$res = mysqli_query($conn, $sql);
					if(mysqli_num_rows($res)==0){
						echo '<table id="err"><tr><td>No departments found!</td></tr></table>';
					}else{
						echo "
						<div class='cont' id='courseform'>
						<form onsubmit='return check_course_form()' method='POST' action='submitdata.php'>
							<button class='close' type='button' onclick='closeform(1)'>X</button>
							<h1>Enter course details</h1>
							<table>
								<tr>
									<td colspan='2'><label for='dept'>Department : </label></td>
									<td colspan='2'><select id='dept' name='dept'>
										<option style='display:none;' value='0'>Select a department...</option>";
						while($row = mysqli_fetch_assoc($res)){
							echo '<option value='.$row['did'].'>'.$row['dname'].'</option>';
						}
						echo "</td></tr>
								<tr>
									<td colspan='2'><label for='crname'>Course name : </label></label></td>
									<td colspan='2'><input type='text' name='crname' id='crname' placeholder='Course name...' required /></td>
								</tr>
								<tr>
									<td colspan='2'><label for='crdesc'>Course description : </label></label></td>
									<td colspan='2'><textarea rows='5' name='crdesc' id='crdesc' placeholder='Course description...' required></textarea></td>
								</tr>
								<tr>
									<td><label for='crterms'>Terms per year : </label></label></td>
									<td><input style='text-align:center' type='number' name='crterms' id='crterms' min='1' max='12' value='1' required /></td>
									<td><label for='cryrs'>Duration (years) : </label></label></td>
									<td><input style='text-align:center' type='number' name='cryrs' id='cryrs' min='1' value='1' required /></td>
								</tr>
								<tr>
									<td colspan='2'><label for='ug'>UG : </label><input style='width:auto;' id='ug' type='radio' name='grad' value='ug' checked /></td>
									<td colspan='2'><label for='pg'>PG : </label><input style='width:auto;' id='pg' type='radio' name='grad' value='pg' /></td>
								</tr>
								<tr>
									<td></td>
									<td colspan='2'><input type='submit' name='createcourse' value='Submit' /></td>
								</tr>
							</table>
						</form></div>
						<table id='tbl' border='2' cellspacing='0'>
							<tr>
								<td colspan='5' style='font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;'>Existing courses<button type='button' class='but' onclick='openform(1)'><b style='margin-right:3px;'>+</b>Add Course</button></td>
							</tr>
							<tr class='bold'>
								<td>Course Name</td>
								<td>Department</td>
								<td>Description</td>
								<td colspan='2'>Action</td>
							</tr>";
						require "../connect.php";
						$res = mysqli_query($conn, "SELECT * FROM courses WHERE cid = ".$_SESSION['cid']);
						while($row = mysqli_fetch_assoc($res)){
							$res1 = mysqli_query($conn, "SELECT dname FROM department WHERE did = ".$row['did']);
							$oc = "window.location.href='/www.eduerp.com/user/?menu=courses&id=".$row['id']."'";
							$row1 = mysqli_fetch_array($res1);
							echo '<tr><td>'.$row['name'].'</td><td>'.$row1[0].'</td><td>'.$row['description'].'</td><td><button type="button" style="padding:8px;cursor:pointer;background-color:rgb(220,220,20);color:white;border:none;border-radius:5px;" onclick="'.$oc.'">Edit</button></td><td><button type="button" style="padding:8px;cursor:pointer;background-color:rgb(250,20,20);color:white;border:none;border-radius:5px;" onclick="checkdel(5, '.$row['id'].')">Delete</button></tr>';
						}
						echo "</table>";
					}
					mysqli_close($conn);
				}else if($_GET['menu']=='notices'){
					echo '<div class="cont" id="notform"><form method="POST" action="submitdata.php">
						<button class="close" type="button" onclick="closeform(2)">X</button>
						<table>
							<h1>Enter notice details</h1>
							<tr>
								<td><label for="title">Title : </label></td>
								<td colspan="3"><input type="text" name="title" placeholder="Title..." id="title" required /></td>
							</tr>
							<tr>
								<td colspan="4"><label for="desc">Description : </label></td>
							</tr>
							<tr>
								<td colspan="4"><textarea rows="5" name="desc" placeholder="Description..." id="desc" required></textarea></td>
							</tr>
							<tr>
								<td><label for="date">Date : </label></td>
								<td colspan="3"><input type="date" id="date" name="date" required/></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><input type="submit" name="createnotice" value="Submit" /></td>
							</tr>
						</table>
					</form>
					</div>
					<table id="tbl" border="2" cellspacing="0">
						<tr><td colspan="5" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Uploaded Notices<button type="button" class="but" onclick="openform(2)"><b style="margin-right:3px;">+</b>Add Notice</button></td></tr>
						<tr class="bold">
							<td>Title</td>
							<td>Description</td>
							<td>Date</td>
							<td colspan="2">Action</td>
						</tr>';
					require "../connect.php";
					$sql = "SELECT * FROM notice WHERE cid = ".$_SESSION['cid'];
					$res = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_assoc($res)){
						$oc = "window.location.href='/www.eduerp.com/user/?menu=notices&id=".$row['id']."'";
						echo '<tr>
							<td>'.$row['title'].'</td>
							<td style="text-align:justify">'.$row['description'].'</td>
							<td>'.date("d/m/Y", strtotime($row['date'])).'</td>
							<td><button type="button" onclick='.$oc.' style="padding:8px;cursor:pointer;background-color:rgb(220,220,20);color:white;border:none;border-radius:5px;">Edit</button></td>
							<td><button type="button" onclick="checkdel(3, '.$row['id'].')" style="padding:8px;cursor:pointer;background-color:rgb(250,20,20);color:white;border:none;border-radius:5px;">Delete</button></td>
						</tr>';
					}
					mysqli_close($conn);
					echo '</table>';
				}else if($_GET['menu']=='gallery'){
					echo '<div class="cont" id="galform"><form action="submitdata.php" onsubmit="return verifyimage()" method="post" enctype="multipart/form-data">
						<button type="button" class="close" onclick="closeform(3)">X</button>
						<h1>Upload photos</h1>
						<table>
							<tr>
								<td colspan="2"><label for="photo">Select Photo : </label></td>
								<td colspan="2"><input type="file" id="photo" name="photo" accept=".png, .jpg, .jpeg" required /></td>
							</tr>';
					if(isset($_GET['error'])){
						echo '<tr>
							<td colspan="4"><p class="error" style="color:red">Another photo with the same name is already present in the database!</p></td>
						</tr>';
					}
					echo '<tr>
								<td colspan="2"><label for="cover">Cover : </label></td>
								<td colspan="2"><input type="checkbox" id="cover" name="cover" /></td>
							</tr>
							<tr>
								<td>
								<td colspan="2"><input type="submit" name="uploadphoto" value="Submit" /></td>
							</tr>
						</table>
					</form></div>
					<table id="tbl" class="photo" border="2" style="table-layout:fixed;border-collapse:collapse;">
						<tr><td colspan="2" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Gallery<button type="button" class="but" onclick="openform(3)"><b style="margin-right:3px;">+</b>Add Photo</button></td></tr></table>';
					require "../connect.php";
					$sql = "SELECT link FROM college WHERE cid = ".$_SESSION['cid'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_array($res);
					$link = $row[0];
					$sql = "SELECT * FROM gallery WHERE cid = ".$_SESSION['cid'];
					$res = mysqli_query($conn, $sql);
					$cnt = 0;
					echo '<div class="container">';
					while($row = mysqli_fetch_assoc($res)){
						echo '<div></img><img class="img" src="../../'.$link.'/'.$row['photo'].'"><img onclick="checkdel(2, '.$row['id'].')" src="trash.png" onmouseover="reducebrightness('.$cnt.')" onmouseout="increasebrightness('.$cnt.')" class="trash"></img></div>';
						$cnt = $cnt + 1;
					}
					echo '</div>';
					mysqli_close($conn);
				}else if($_GET['menu']=='faculty'){
					require "../connect.php";
					$res = mysqli_query($conn, "SELECT did, dname FROM department WHERE cid = ".$_SESSION['cid']." ORDER BY dname");
					if(mysqli_num_rows($res)==0){
						echo '<table id="err"><tr><td>No departments found!</td></tr></table>';
					}else{
						echo '<div class="cont" id="facultyform"><form method="post" action="submitdata.php">
							<button type="button" class="close" onclick="closeform(4)">X</button>
							<h1>Enter faculty details</h1>
							<table>
								<tr>
									<td colspan="2"><label for="fname">First name* : </label></td>
									<td colspan="2"><label for="mname">Middle name : </label></td>
									<td colspan="2"><label for="lname">Last name* : </label></td>
								</tr>
								<tr>
									<td colspan="2"><input type="text" name="fname" id="fname" placeholder="First name..." required /></td>
									<td colspan="2"><input type="text" name="mname" id="mname" placeholder="Middle name..." /></td>
									<td colspan="2"><input type="text" name="lname" id="lname" placeholder="Last name..." required /></td>
								</tr>
								<tr>
									<td colspan="2"><label for="mail">E-mail* : </label</td>
									<td colspan="2"><label for="pass">Password* : </label></td>
									<td colspan="2"><label for="phno">Contact Number* : </label></td>
								</tr>
								<tr>
									<td colspan="2"><input type="email" name="mail" id="mail" placeholder="E-mail..." required /></td>
									<td colspan="2"><input type="password" name="pass" id="pass" placeholder="Password..." required /></td>
									<td colspan="2"><input type="tel" pattern="[0-9]{10}" name="phno" id="phno" placeholder="Contact Number..." required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="dob">Enter date of birth* : </label></td>
									<td colspan="3"><input type="date" name="dob" id="dob" required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="dept">Department* : </label></td>
									<td colspan="3"><select id="dept" name="dept">
										<option value="0" style="display:none">Select a department</option>';
									while($row = mysqli_fetch_array($res)){
										echo '<option value='.$row[0].'>'.$row[1].'</option>';
									}
									mysqli_close($conn);
									echo '</select></td>
								</tr>
								<tr>
									<td colspan="3"><label for="salary">Salary* : </label></td>
									<td colspan="3"><input type="number" name="salary" id="salary" placeholder="Salary..." required />
								</tr>
								<tr>
									<td></td>
									<td colspan="4"><input type="submit" name="staff" value="Submit" /></td>
								</tr>
							</table>
						</form></div>
						<table id="tbl" border="2" cellspacing="0">
							<tr>
								<td colspan="8" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Faculty members<button type="button" class="but" onclick="openform(4)"><b style="margin-right:3px;">+</b>Add Faculty</button></td>
							</tr>
							<tr class="bold">
								<td>Name</td>
								<td>E-mail</td>
								<td>Contact Number</td>
								<td>Date of birth</td>
								<td>Department</td>
								<td>Salary (INR)</td>
								<td colspan="2">Action</td>
							</tr>';
						require "../connect.php";
						$res = mysqli_query($conn, "SELECT * FROM staff WHERE cid = ".$_SESSION['cid']);
						while($row = mysqli_fetch_assoc($res)){
							$res1 = mysqli_query($conn, "SELECT dname FROM department WHERE did = ".$row['did']);
							$row1 = mysqli_fetch_array($res1);
							if($row['mname']==""){
								$name = $row['fname'].' '.$row['lname'];
							}else{
								$name = $row['fname'].' '.$row['mname'].' '.$row['lname'];
							}
							$oc = "window.location.href='/www.eduerp.com/user/?menu=faculty&id=".$row['id']."'";
							echo '<tr><td>'.$name.'</td><td>'.$row['email'].'</td><td>'.$row['contact'].'</td><td>'.date_format(date_create($row['dob']),"d/m/Y").'</td><td>'.$row1[0].'</td><td>'.$row["salary"].'</td><td><button type="button" onclick='.$oc.' style="padding:8px;cursor:pointer;background-color:rgb(220,220,20);color:white;border:none;border-radius:5px;">Edit</button></td>
							<td><button type="button" onclick="checkdel(4,'.$row['id'].')" style="padding:8px;cursor:pointer;background-color:rgb(250,20,20);color:white;border:none;border-radius:5px;">Delete</button></td></tr>';
						}
						mysqli_close($conn);
						echo '</table>';
					}
				}else if($_GET['menu']=="subject"){
					echo '<div class="cont" id="subform"><form method="POST" action="submitdata.php">
						<button class="close" type="button" onclick="closeform(5)">X</button>
						<table>
							<h1>Enter subject details</h1>
							<tr>
								<td><label for="subcode">Subject Code : </label></td>
								<td><input type="text" name="subcode" placeholder="Subject code..." id="subcode" required /></td>
							</tr>
							<tr>
								<td><label for="subname">Subject Name : </label></td>
								<td><input type="text" name="subname" placeholder="Subject name..." id="subname" required /></td>
							</tr>
							<tr>
								<td><label for="subcourse">Course<br>(Select only if it is a core paper for the course) : </label></td>
								<td><select name="subcourse" id="subcourse">
									<option value="0">None</option>';
						require "../connect.php";
						$sql = "SELECT name, id FROM courses WHERE cid = ".$_SESSION['cid']." ORDER BY name";
						$res = mysqli_query($conn, $sql);
						while($row = mysqli_fetch_array($res)){
							echo '<option value="'.$row[1].'">'.$row[0].'</option>';
						}
						mysqli_close($conn);
						echo '</select></td>
							</tr>
							<tr>
								<td colspan="2"><input style="width:50%;" type="submit" name="createsubject" value="Submit" /></td>
							</tr>
						</table>
					</form>
					</div>
					<div class="cont" id="poolform"><form method="POST" action="submitdata.php">
						<button class="close" type="button" onclick="closeform(6)">X</button>
						<table>
							<h1>Enter pool details</h1>
							<tr>
								<td><label for="poolname">Pool Name : </label></td>
								<td><input type="text" name="poolname" placeholder="Pool name..." id="poolname" required /></td>
							</tr>
							<tr>
								<td><label>Elective number : </label>
								<td><input style="width:auto" type="radio" name="elective" id="el1" value="1" checked /><label style="margin-right:50px" for="el1">1</label><input style="width:auto" type="radio" name="elective" id="el2" value="2"/><label for="el2">2</label></td>
							</tr>
							<tr>
								<td><label for="poolsub">Subjects(hold ctrl to select multiple) : </label></td>
								<td><select id="poolsub" name="poolsub[]" multiple>';
							require "../connect.php";
							$sql = "SELECT id, name FROM subjects WHERE cid = ".$_SESSION['cid']." ORDER BY name";
							$res = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_array($res)){
								echo '<option value="'.$row[0].'">'.$row[1].'</option>';
							}
							echo '</select></td>
							</tr>
							<tr>
								<td><label for="poolcourse">Courses(hold ctrl to select multiple) : </label></td>
								<td><select id="poolcourse" name="poolcourse[]" multiple>';
							$sql = "SELECT id, name FROM courses WHERE cid = ".$_SESSION['cid']." AND pg = 0 ORDER BY name";
							$res = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_array($res)){
								echo '<option value="'.$row[0].'">'.$row[1].'</option>';
							}
							mysqli_close($conn);
						echo '</select></td>
							</tr>
							<tr>
								<td><input type="submit" name="createpool" value="Submit" /></td>
								<td><input type="reset" name="reset" value="Reset" /></td>
							</tr>
						</table>
					</form>
					</div>
					<table id="tbl" border="2" cellspacing="0">
						<tr><td colspan="6" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Subjects<button type="button" class="but" onclick="openform(5)"><b style="margin-right:3px;">+</b>Add Subject</button></td></tr>
						<tr class="bold">
							<td>Code</td>
							<td>Name</td>
							<td>Course</td>
							<td colspan="2">Action</td>
						</tr>';
					require "../connect.php";
					$sql = "SELECT * FROM subjects WHERE cid = ".$_SESSION['cid']." ORDER BY code";
					$res = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_assoc($res)){
						$oc = "window.location.href='/www.eduerp.com/user/?menu=subject&option=subject&id=".$row['id']."'";
						if($row['course']=="0"){
							$row1[0] = "None";
						}else{
							$sql1 = "SELECT name FROM courses WHERE id = ".$row['course'];
							$res1 = mysqli_query($conn, $sql1);
							$row1 = mysqli_fetch_array($res1);
						}
						echo '<tr>
							<td>'.$row['code'].'</td>
							<td>'.$row['name'].'</td>
							<td>'.$row1[0].'</td>
							<td><button type="button" onclick='.$oc.' style="padding:8px;cursor:pointer;background-color:rgb(220,220,20);color:white;border:none;border-radius:5px;">Edit</button></td>
							<td><button type="button" onclick="checkdel(6, '.$row['id'].')" style="padding:8px;cursor:pointer;background-color:rgb(250,20,20);color:white;border:none;border-radius:5px;">Delete</button></td>
						</tr>
						';
					}
					mysqli_close($conn);
					echo '</table>
					<table id="tbl" border="2" cellspacing="0">
						<tr><td colspan="5" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Pools<button type="button" class="but" onclick="openform(6)"><b style="margin-right:3px;">+</b>Create Pool</button></td></tr>
						<tr class="bold">
							<td>Name</td>
							<td>Subjects</td>
							<td>Course(s)</td>
							<td colspan="2">Action</td>
						</tr>';
					require "../connect.php";
					$sql = "SELECT id, name FROM pools WHERE cid = ".$_SESSION['cid']." ORDER BY name";
					$res = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_array($res)){
						echo '<tr>
							<td>'.$row[1].'</td>
							<td><ol style="padding-left:5px">';
						$sql1 = "SELECT subject FROM subtopool WHERE pool = ".$row[0];
						$res1 = mysqli_query($conn, $sql1);
						while($row1 = mysqli_fetch_array($res1)){
							$sql2 = "SELECT code FROM subjects WHERE id = ".$row1[0]." ORDER BY code";
							$res2 = mysqli_query($conn, $sql2);
							$row2 = mysqli_fetch_array($res2);
							echo '<li>'.$row2[0].'</li>';
						}
						echo '</ol></td><td><ol style="padding-left:5px;">';
						$sql1 = "SELECT course FROM coursetopool WHERE pool = ".$row[0];
						$res1 = mysqli_query($conn, $sql1);
						while($res1&&$row1 = mysqli_fetch_array($res1)){
							$sql2 = "SELECT name FROM courses WHERE id = ".$row1[0]." ORDER BY name";
							$res2 = mysqli_query($conn, $sql2);
							while($row2 = mysqli_fetch_array($res2)){
								echo '<li>'.$row2[0].'</li>';
							}
						}
						echo '</ol></td>';
						echo '<td><button type="button" onclick="checkdel(7, '.$row[0].')" style="padding:8px;cursor:pointer;background-color:rgb(250,20,20);color:white;border:none;border-radius:5px;">Delete</button></td>
						</tr>
						';
					}
					echo '</table>';
					mysqli_close($conn);
				}else if($_GET['menu']=='admission'){
					require "../connect.php";
					$res = mysqli_query($conn, "SELECT * FROM admission WHERE status = 0 AND cid = ".$_SESSION['cid']);
					if(mysqli_num_rows($res)==0){
						echo '<table id="err"><tr><td>No new admissions!</td></tr></table>';
					}else{
						echo '<table id="tbl" border="2" cellspacing="0">
							<tr>
								<td colspan="6" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
							color:white;">Admissions</td>
							</tr>
							<tr class="bold">
								<td>Name</td>
								<td>Course</td>
								<td>Class 10 Marks</td>
								<td>Class 12 Marks</td>
								<td>Graduation Marks</td>
								<td>More</td>
							</tr>';
						while($row = mysqli_fetch_assoc($res)){
							if($row['mname']=="")
								$name = $row['fname']." ".$row['lname'];
							else
								$name = $row['fname']." ".$row['mname']." ".$row['lname'];
							$res1 = mysqli_query($conn, "SELECT name FROM courses WHERE id = ".$row['course']);
							$row1 = mysqli_fetch_array($res1);
							$loc = "'/www.eduerp.com/user/?menu=admission&id=".$row['id']."'";
							echo '<tr><td>'.$name.'</td><td>'.$row1[0].'</td><td>'.$row['marks10'].'</td><td>'.$row['marks12'].'</td><td>'.$row['gmarks'].'</td><td><button type="button" style="padding:8px;cursor:pointer;background-color:rgb(120,120,120);color:white;border:none;border-radius:5px;" onclick="window.location.href='.$loc.'">Check Details</button></td></tr>';
						}
						mysqli_close($conn);
						echo '</table>';
					}
				}else if($_GET['menu']=="students"){
					if(isset($_GET['error'])&&$_GET['error']=="riu"){
					}
					echo '<div class="cont" id="studentform"><form method="post" onsubmit="return checkcourse(1)" action="submitdata.php">
						<button type="button" class="close" onclick="closeform(7)">X</button>
						<h1>Enter student details</h1>
						<table>
							<tr>
								<td colspan="2"><label for="fname">First name* : </label></td>
								<td colspan="2"><label for="mname">Middle name : </label></td>
								<td colspan="2"><label for="lname">Last name* : </label></td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" name="fname" id="fname" placeholder="First name..." required /></td>
								<td colspan="2"><input type="text" name="mname" id="mname" placeholder="Middle name..." /></td>
								<td colspan="2"><input type="text" name="lname" id="lname" placeholder="Last name..." required /></td>
							</tr>
							<tr>
								<td colspan="2"><label>Gender* : </label></td><td colspan="2"><label for="male">Male</label><input type="radio" style="width:auto;margin-left:10px;" name="gender" id="male" value="male" checked/></td><td colspan="2"><label for="female">Female</label><input style="width:auto;margin-left:10px;" type="radio" name="gender" id="female" value="f" /></td>
							</tr>
							<tr>
								<td colspan="3"><label for="roll">Roll* : </label></td>
								<td colspan="3"><input type="text" name="roll" id="roll" placeholder="Roll number..." required /></td>
							</tr>
							<tr>
								<td colspan="3"><label for="mail">E-mail* : </label></td>
								<td colspan="3"><input type="email" name="mail" id="mail" placeholder="E-mail..." required /></td>
							</tr>
							<tr>
								<td colspan="3"><label for="contact">Contact number* : </label></td>
								<td colspan="3"><input type="text" name="contact" id="contact" placeholder="Contact number..." required /></td>
							</tr>
							<tr>
								<td colspan="3"><label for="dob">Date of birth* : </label></td>
								<td colspan="3"><input type="date" name="dob" id="dob" required /></td>
							</tr>
							<tr>
								<td colspan="3"><label for="address">Address* : </label></td>
								<td colspan="3"><textarea rows="3" name="address" id="address" required></textarea></td>
							</tr>
							<tr>
								<td colspan="2"><label for="city">City* : </label></td>
								<td colspan="2"><label for="state">State* : </label></td>
								<td colspan="2"><label for="country">Country* : </label></td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" name="city" id="city" placeholder="City..." required /></td>
								<td colspan="2"><input type="text" name="state" id="state" placeholder="State..." required /></td>
								<td colspan="2"><input type="text" name="country" id="country" placeholder="Country..." required /></td>
							</tr>
							<tr>
								<td colspan="3"><label for="course">Course* : </label></td>
								<td colspan="3"><select onchange="getPools(this.value)" id="course" name="course">
									<option value="0" style="display:none">Select a course</option>';
								require "../connect.php";
								$sql = "SELECT id, name FROM courses WHERE cid = ".$_SESSION['cid']." ORDER BY name";
								$res = mysqli_query($conn, $sql);
								while($row = mysqli_fetch_array($res)){
									echo '<option value="'.$row[0].'">'.$row[1].'</option>';
								}
								mysqli_close($conn);
								echo '</select></td>
							</tr>
							<tr class="dummy"></tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="2"><input type="submit" name="student" value="Submit" /></td>
							</tr>
						</table>
					</form></div>
					<table id="tbl" border="2" cellspacing="0">
						<tr>
							<td colspan="5" style="font-size:24px;font-style:italic;padding:16px;background-color:black;
						color:white;">Students<button type="button" class="but" onclick="openform(7)"><b style="margin-right:3px;">+</b>Add Student</button></td>
						</tr>
						<tr class="bold">
							<td>Name</td>
							<td>Roll Number</td>
							<td>Course</td>
							<td colspan="2">Action</td>
						</tr>';
					require "../connect.php";
					$res = mysqli_query($conn, "SELECT * FROM student WHERE cid = ".$_SESSION['cid']." ORDER BY roll");
					while($row = mysqli_fetch_assoc($res)){
						$res1 = mysqli_query($conn, "SELECT name FROM courses WHERE id = ".$row['course']);
						$row1 = mysqli_fetch_array($res1);
						$oc = "window.location.href='/www.eduerp.com/user/?menu=students&id=".$row['id']."'";
						echo '<tr><td>'.$row['name'].'</td><td>'.$row['roll'].'</td><td>'.$row1[0].'</td><td><button type="button" onclick='.$oc.' style="padding:8px;cursor:pointer;background-color:rgb(220,220,20);color:white;border:none;border-radius:5px;">Edit</button></td>
						<td><button type="button" onclick="checkdel(8,'.$row['id'].')" style="padding:8px;cursor:pointer;background-color:rgb(250,20,20);color:white;border:none;border-radius:5px;">Delete</button></td></tr>';
					}
					mysqli_close($conn);
					echo '</table>';
				}
			?>
		</div>
		<div id="edit" <?php if(isset($_GET['id'])){echo 'style="display:flex;"';} ?>>
		<?php
			if(isset($_GET['id'])){
				if($_GET['menu']=="departments"){
					require "../connect.php";
					$sql = "SELECT * FROM department WHERE did = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($res);
					$dname = $row['dname'];
					$desc = $row['description'];
					$ac = $row['academic']==1?"checked":"";
					mysqli_close($conn);
					echo '<form method="POST" action="edittables.php">
							<input type="hidden" name="id" value="'.$_GET['id'].'"/>
						<table>
							<button class="close" type="button" onclick="closeedit()">X</button>
							<h1>Enter new department details</h1>
							<tr>
								<td colspan="2"><label for="dname">New department name : </label></td>
								<td colspan="2"><input type="text" name="dname" id="dname" placeholder="Department name..." value="'.$dname.'" required /></td>
							</tr>
							<tr>
								<td colspan="2"><label for="desc">Department description : </label></td>
								<td colspan="2"><textarea rows="3" id="desc" name="desc" placeholder="Description..." required>'.$desc.'</textarea></td>
							</tr>
							<tr>
								<td colspan="2"><label for="desc">Academic : </label></td>
								<td colspan="2"><input type="checkbox" name="acad" id="acad" '.$ac.'/></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><input type="submit" name="editdept" value="Submit"/></td>
							</tr>
						</table>
					</form>';
				}else if($_GET['menu']=="notices"){
					require "../connect.php";
					$sql = "SELECT * FROM notice WHERE id = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($res);
					$title = $row['title'];
					$desc = $row['description'];
					$date = $row['date'];
					mysqli_close($conn);
					echo '<form method="POST" action="/www.eduerp.com/user/editnot.php">
							<input type="hidden" name="id" value="'.$_GET['id'].'"/>
							<table>
								<button class="close" type="button" onclick="closeedit()">X</button>
								<h1>Enter new notice details</h1>
								<tr>
									<td colspan="2"><label for="title">New Title name : </label></td>
									<td colspan="2"><input type="text" name="title" value="'.$title.'" id="title" placeholder="Notice name..." required /></td>
								</tr>
								<tr>
									<td colspan="2"><label for="desc">Notice description : </label></td>
									<td colspan="2"><textarea rows="5" id="desc" name="desc" required>'.$desc.'</textarea></td>
								</tr>
								<tr>
									<td colspan="2"><label for="date">Date</label></td>
									<td colspan="2"><input type="date" id="date" name="date" value="'.$date.'" required /></td>
								</tr>
								<tr>
									<td></td>
									<td colspan="2"><input type="submit" name="submit" value="Submit"/></td>
								</tr>
							</table>
						</form>';
				}else if($_GET['menu']=="faculty"){
					require "../connect.php";
					$sql = "SELECT * FROM staff WHERE id = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($res);
					$fname = $row['fname'];
					$mname = $row['mname'];
					$lname = $row['lname'];
					$email = $row['email'];
					$contact = $row['contact'];
					$dob = $row['dob'];
					$salary = $row['salary'];
					$did = $row['did'];
					$res = mysqli_query($conn, "SELECT did, dname FROM department WHERE cid = ".$_SESSION['cid']." ORDER BY dname");
					echo '<form method="POST" action="/www.eduerp.com/user/editfac.php">
							<input type="hidden" name="id" value="'.$_GET['id'].'"/>
							<button class="close" type="button" onclick="closeedit()">X</button>
							<h1>Enter new faculty details</h1>
							<table>
								<tr>
									<td colspan="2"><label for="fname">First name* : </label></td>
									<td colspan="2"><label for="mname">Middle name : </label></td>
									<td colspan="2"><label for="lname">Last name* : </label></td>
								</tr>
								<tr>
									<td colspan="2"><input type="text" value="'.$fname.'" name="fname" id="fname" placeholder="First name..." required /></td>
									<td colspan="2"><input type="text" value="'.$mname.'" name="mname" id="mname" placeholder="Middle name..." /></td>
									<td colspan="2"><input type="text" value="'.$lname.'" name="lname" id="lname" placeholder="Last name..." required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="mail">E-mail* : </label</td>
									<td colspan="3"><label for="phno">Contact Number* : </label></td>
								</tr>
								<tr>
									<td colspan="3"><input type="email" value="'.$email.'" name="mail" id="mail" placeholder="E-mail..." required /></td>
									<td colspan="3"><input type="tel" value="'.$contact.'" pattern="[0-9]{10}" name="phno" id="phno" placeholder="Contact Number..." required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="dob">Enter date of birth* : </label></td>
									<td colspan="3"><input value="'.$dob.'" type="date" name="dob" id="dob" required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="dept">Department* : </label></td>
									<td colspan="3"><select id="dept" name="dept">';
									while($row = mysqli_fetch_array($res)){
										if($row[0]==$did){
											$select = "selected";
										}else{
											$select = "";
										}
										echo '<option value='.$row[0].' '.$select.'>'.$row[1].'</option>';
									}
									mysqli_close($conn);
									echo '</select></td>
								</tr>
								<tr>
									<td colspan="3"><label for="salary">Salary(INR)* : </label></td>
									<td colspan="3"><input type="number" value="'.$salary.'" name="salary" id="salary" placeholder="Salary..." required /></td>
								</tr>
								<tr>
									<td></td><td colspan="2"><input type="submit" name="submit" value="Submit" /></td>
								</tr>
							</table>
						</form>';
				}else if($_GET['menu']=="courses"){
					require "../connect.php";
					$res = mysqli_query($conn, "SELECT * FROM courses WHERE id = ".$_GET['id']);
					$row = mysqli_fetch_assoc($res);
					echo '<form method="POST" action="/www.eduerp.com/user/editcourse.php">
							<input type="hidden" name="id" value="'.$_GET['id'].'"/>
							<table>
								<button class="close" type="button" onclick="closeedit()">X</button>
								<h1>Enter new course details</h1>
								<tr>
									<td colspan="2"><label for="dept2">Select department : </label></td>
									<td colspan="2"><select name="dept">';
						$res1 = mysqli_query($conn, "SELECT did, dname FROM department WHERE cid = ".$_SESSION['cid']);
						while($row1 = mysqli_fetch_array($res1)){
							$checked = "";
							if($row['did']==$row1[0]){
								$checked = "selected";
							}
							echo '<option value="'.$row1[0].'" '.$checked.'>'.$row1[1].'</option>';
						}
								echo '</select></td>
								</tr>
								<tr>
									<td colspan="2"><label for="cname">Course name : </label></td>
									<td colspan="2"><input type="text" name="cname" id="cname" placeholder="Course name..." value="'.$row['name'].'" required /></td>
								</tr>
								<tr>
									<td colspan="2"><label for="desc">Description</label></td>
									<td colspan="2"><textarea rows="5" name="description" id="desc" placeholder="Course description..." required>'.$row['description'].'</textarea></td>
								</tr>
								<tr>
									<td><label for="terms">Terms : </label></td>
									<td><input type="number" name="terms" id="terms" value="'.$row['terms'].'" placeholder="Terms" required /></td>
									<td><label for="duration">Duration : </label></td>
									<td><input type="number" name="dur" id="duration" value="'.$row['duration'].'" placeholder="Duration..." /></td>
								</tr>';
							$ug = $row['pg']==0?"checked":"";
							$pg = $row['pg']==1?"checked":"";
							echo '<tr>
									<td><label for="ug1">UG  : </label></td>
									<td><input type="radio" name="grad" id="ug1" value="ug" '.$ug.'/></td>
									<td><label for="pg1">PG  : </label></td>
									<td><input type="radio" name="grad" id="pg1" value="pg" '.$pg.' /></td>
								</tr>
								<tr>
									<td></td>
									<td colspan="2"><input type="submit" name="submit" value="Submit"/></td>
								</tr>
							</table>
						</form>';
					mysqli_close($conn);
				}else if($_GET['menu']=='subject'&&$_GET['option']=='subject'){
					require "../connect.php";
					$sql = "SELECT * FROM subjects WHERE id = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($res);
					echo '<form method="POST" action="/www.eduerp.com/user/editsubject.php">
							<input type="hidden" name="id" value="'.$_GET['id'].'"/>
							<table>
								<button class="close" type="button" onclick="closeedit()">X</button>
								<h1>Enter new subject details</h1>
								<tr>
									<td colspan="2"><label for="subcode1">Subject code : </label></td>
									<td colspan="2"><input type="text" name="subcode1" id="subcode1" placeholder="Enter code..." value="'.$row['code'].'" required /></td>
								</tr>
								<tr>
									<td colspan="2"><label for="subname1">Subject name : </label></td>
									<td colspan="2"><input type="text" name="subname1" id="subname1" placeholder="Subject name..." value="'.$row['name'].'" required /></td>
								</tr>
								<tr>
									<td colspan="2"><label for="subcourse1">Select course : </label></td>
									<td colspan="2"><select id="subcourse1" name="subcourse1">
										<option value="0">None</option>';
								$sql1 = "SELECT * FROM courses WHERE cid = ".$_SESSION['cid']." ORDER BY name";
								$res1 = mysqli_query($conn, $sql1);
								while($row1 = mysqli_fetch_assoc($res1)){
									$selected = "";
									if($row1['id']==$row['course'])
										$selected = "selected";
									echo '<option value="'.$row1['id'].'" '.$selected.'>'.$row1['name'].'</option>';
								}
								echo '</select></td>
								</tr>
								<tr>
									<td></td>
									<td colspan="2"><input type="submit" name="submit" value="Submit"/></td>
								</tr>
							</table>
						</form>';
					mysqli_close($conn);
				}else if($_GET['menu']=="admission"){
					require "../connect.php";
					$sql = "SELECT * FROM admission WHERE status = 0 AND id = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($res);
					if($row['mname']=="")
						$name = $row['fname']." ".$row['lname'];
					else
						$name = $row['fname']." ".$row['mname']." ".$row['lname'];
					$gender = $row['gender']==0?"Male":"Female";
					$sql = "SELECT name FROM courses WHERE id = ".$row['course'];
					$res = mysqli_query($conn, $sql);
					$course = mysqli_fetch_array($res);
					$sql = "SELECT name FROM pools WHERE id = ".$row['elective1'];
					$res = mysqli_query($conn, $sql);
					if($res&&mysqli_num_rows($res)>0)
						$elec1 = mysqli_fetch_array($res);
					else
						$elec1[0] = "NULL";
					$sql = "SELECT name FROM pools WHERE id = ".$row['elective2'];
					$res = mysqli_query($conn, $sql);
					if($res&&mysqli_num_rows($res)>0)
						$elec2 = mysqli_fetch_array($res);
					else
						$elec2[0] = "NULL";
					
					echo '<form id="admissionform" style="width:90%;" method="POST" action="/www.eduerp.com/user/admission.php">
							<input type="hidden" name="id" value="'.$_GET['id'].'"/>
							<table id="admission" style="border-collapse:collapse;text-align:left;">
								<button class="close" type="button" onclick="closeedit()">X</button>
								<h1>Admission details</h1>
								<tr><td><label>Name : '.$name.'</label></td></tr>
								<tr><td><label>Gender : '.$gender.'</label></td><td><label>Date of Birth : '.date("d/m/Y", strtotime($row['dob'])).'</label></td></tr>
								<tr><td><label>Contact Number : '.$row['contact'].'</label></td><td colspan="2"><label>E-mail : '.$row['mail'].'</label></td></tr>
								<tr><td colspan="4"><label>Address : '.$row['address'].'</label></td></tr>
								<tr>
									<td><label>City : '.$row['city'].'</label></td>
									<td><label>State : '.$row['state'].'</label></td>
									<td><label>Country : '.$row['country'].'</label></td>
								</tr>
								<tr>
									<td><label>Course : '.$course[0].'</label></td>
									<td><label>Elective-1 : '.$elec1[0].'</label></td>
									<td><label>Elective-2 : '.$elec2[0].'</label></td>
								</tr>
								<tr>
									<td><label>School/Marks(Class 10) : </label></td><td><label>'.$row['school10'].'</label></td><td><label>'.$row['marks10'].'%</label></td></tr>
								<tr><td><label>School/Marks(Class 12) : </label></td><td><label>'.$row['school12'].'</label></td><td><label>'.$row['marks12'].'%</label></td></tr>
								<tr><td><label>Graduation College : '.$row['gcol'].'</label></td><td><label>Marks : '.$row['gmarks'].'%</label></td>
								</tr>
								<tr>
									<td><label for="admitroll">Roll Number : </label></td><td><input id="admitroll" type="text" name="roll" placeholder="Roll number..." /></td>
									<td><input type="submit" onclick="return checkroll()" name="submit" value="Accept"/></td>
									<td><input type="submit" name="submit" style="background-color:rgb(200,0,0)" value="Reject"/></td>
								</tr>
							</table>
						</form>';
				}else if($_GET['menu']=="students"){
					require "../connect.php";
					$sql = "SELECT * FROM student WHERE id = ".$_GET['id'];
					$res = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($res);
					$male = $row['gender']==0?"checked":"";
					$female = $row['gender']==0?"":"checked";
					
					echo '<form id="studentform" method="POST" onsubmit="return checkcourse(2)" action="/www.eduerp.com/user/editstudent.php">
							<input type="hidden" name="id" value="'.$_GET['id'].'"/>
							<table>
								<button class="close" type="button" onclick="closeedit()">X</button>
								<h1>Enter student details</h1>
								<tr>
									<td colspan="3"><label for="name">Name* : </label></td>
									<td colspan="3"><input type="text" value="'.$row['name'].'" name="name" id="name" placeholder="Name..." required /></td>
								</tr>
								<tr>
									<td colspan="2"><label>Gender* : </label></td><td colspan="2"><label for="male">Male</label><input type="radio" style="width:auto;margin-left:10px;" name="gender" id="male" value="male" '.$male.'/></td><td colspan="2"><label for="female">Female</label><input style="width:auto;margin-left:10px;" type="radio" name="gender" id="female" '.$female.' value="f" /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="roll">Roll* : </label></td>
									<td colspan="3"><input type="text" value="'.$row['roll'].'" name="roll" id="roll" placeholder="Roll number..." required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="mail">E-mail* : </label></td>
									<td colspan="3"><input type="email" name="mail" id="mail" placeholder="E-mail..." value="'.$row['email'].'" required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="contact">Contact number* : </label></td>
									<td colspan="3"><input type="text" value="'.$row['contact'].'" name="contact" id="contact" placeholder="Contact number..." required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="dob">Date of birth* : </label></td>
									<td colspan="3"><input type="date" value="'.$row['dob'].'" name="dob" id="dob" required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="address">Address* : </label></td>
									<td colspan="3"><textarea rows="3" name="address" id="address" required>'.$row['address'].'</textarea></td>
								</tr>
								<tr>
									<td colspan="2"><label for="city">City* : </label></td>
									<td colspan="2"><label for="state">State* : </label></td>
									<td colspan="2"><label for="country">Country* : </label></td>
								</tr>
								<tr>
									<td colspan="2"><input type="text" value="'.$row['city'].'" name="city" id="city" placeholder="City..." required /></td>
									<td colspan="2"><input type="text" value="'.$row['state'].'" name="state" id="state" placeholder="State..." required /></td>
									<td colspan="2"><input type="text" value="'.$row['country'].'" name="country" id="country" placeholder="Country..." required /></td>
								</tr>
								<tr>
									<td colspan="3"><label for="course1">Course* : </label></td>
									<td colspan="3"><select onchange="myfunction(this.value)" id="course1" name="course">
										<option value="0" style="display:none">Select a course</option>';
									require "../connect.php";
									$sql = "SELECT id, name FROM courses WHERE cid = ".$_SESSION['cid']." ORDER BY name";
									$res1 = mysqli_query($conn, $sql);
									while($row1 = mysqli_fetch_array($res1)){
										$checked = "";
										if($row['course']==$row1[0])
											$checked = "selected";
										echo '<option value="'.$row1[0].'" '.$checked.'>'.$row1[1].'</option>';
									}
									mysqli_close($conn);
									echo '</select></td>
								</tr>
								<tr>
									<td colspan="2"><label>Elective Subjects : </label></td>
									<td colspan="2"><select id="elec1" name="elec1">';
									require "../connect.php";
									$sql = "SELECT pool FROM coursetopool WHERE course = ".$row['course'];
									$res1 = mysqli_query($conn, $sql);
									while($row1 = mysqli_fetch_array($res1)){
										$sql = "SELECT name FROM pools WHERE elective = 1 AND id = ".$row1[0];
										$res2 = mysqli_query($conn, $sql);
										if(mysqli_num_rows($res2)>0){
											$selected = "";
											if($row['elective1']==$row1[0])
												$selected = "selected";
											$row2 = mysqli_fetch_array($res2);
											echo '<option value="'.$row1[0].'" '.$selected.'>'.$row2[0].'</option>';
										}
									}
								echo '</select></td>
									<td colspan="2"><select id="elec2" name="elec2">';
									$sql = "SELECT pool FROM coursetopool WHERE course = ".$row['course'];
									$res1 = mysqli_query($conn, $sql);
									while($row1 = mysqli_fetch_array($res1)){
										$sql = "SELECT name FROM pools WHERE elective = 2 AND id = ".$row1[0];
										$res2 = mysqli_query($conn, $sql);
										if(mysqli_num_rows($res2)>0){
											$selected = "";
											if($row['elective2']==$row1[0])
												$selected = "selected";
											$row2 = mysqli_fetch_array($res2);
											echo '<option value="'.$row1[0].'" '.$selected.'>'.$row2[0].'</option>';
										}
									}
								mysqli_close($conn); 
								echo '</select></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<td colspan="2"><input type="submit" name="submit" value="Submit" /></td>
								</tr>
							</table>
						</form>';
				}
			}
		?>
		</div>
		<div id="optionbox">
			<table>
				<tr>
					<td colspan="2"><p>Are you sure you want to delete this website?</p></td>
				</tr>
				<tr>
					<td><button type="button" style="background-color:rgb(50,205,50);color:white;" onclick="window.location.href='/www.eduerp.com/user/deletesite.php'">Yes</button></td>
					<td><button type="button" style="background-color:#FF7F50;color:white;" onclick="toggleoptions(0);">Cancel</button></td>
				</tr>
			</table>
		</div>
	</body>
</html>