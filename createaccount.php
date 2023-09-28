<?php
	session_start();
	if(isset($_SESSION['cid'])){
		header("location:/www.eduerp.com/user");
		exit();
	}
?>
<html>
	<head>
		<title>EduERP</title>
		<link rel="stylesheet" href="CSS/createacc.css">
		<script>
			function validateForm(){
				var p1 = document.getElementById("password").value;
				var p2 = document.getElementById("repassword").value;
				if(p1==p2)
					return true;
				document.getElementById("password_error").innerHTML = "Passwords do not match!";
				return false;
			}
		</script>
	</head>
	<body>
		<img src="bg.jfif" id="bg"></img>
		<div id="header"><span style="color:rgb(50,205,50)">Edu</span><span style="color:#FF7F50">ERP</span>
		<div id="menu">
			<ul>
				<li><a href="../www.eduerp.com">Home</a></li>
			</ul>
		</div>
		</div>
		<form id="create-account" method="post" action="register.php" onsubmit="return validateForm()">
			<h1>Create Your Account</h1>
			<table>
				<tr>
					<td><label for="f_name">First Name</label></td>
					<td><label for="l_name">Last Name</label></td>
				</tr>
				<tr>
					<td><input type="text" name="fname" id="f_name" placeholder="First Name..." required></td>
					<td><input type="text" name="lname" id="l_name" placeholder="Last Name..." required></td>
				</tr>
				<tr>
					<td colspan="2"><label for="email">E-mail ID</label></td>
				</tr>
				<tr>
					<td colspan="2"><input type="email" name="email" id="email" placeholder="E-mail..." required></td>
				</tr>
				<tr>
					<td colspan="2"><p><?php 
						if(isset($_GET['error'])&&$_GET['error']=="emailinuse"){
							echo 'E-mail already in use!';
						}
					?></p></td>
				</tr>
				<tr>
					<td colspan="2"><label for="password">Password</label></td>
				</tr>
				<tr>
					<td colspan="2"><input type="password" name="password" id="password" placeholder="Password..." required></td>
				</tr>
				<tr>
					<td colspan="2"><label for="repassword">Re-enter Password</label></td>
				</tr>
				<tr>
					<td colspan="2"><input type="password" name="repassword" id="repassword" placeholder="Re-enter Password..." required></td>
				</tr>
				<tr>
					<td colspan="2"><p id="password_error"></p></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" value="Register"/></td>
					<td><input type="button" onclick="window.location.href='/www.eduerp.com'" value="Log in"/></td>
				</tr>
			</table>
		</form>
	</body>
</html>