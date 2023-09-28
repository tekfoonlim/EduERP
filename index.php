<?php
	session_start();
	if(isset($_SESSION['fname'])){
		header("location:/www.eduerp.com/user");
		exit();
	}
?>
<html>
	<head>
		<title>EduERP</title>
		<link rel="stylesheet" href="CSS/homepage.css">
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
		<form id="login" method="post" action="signin.php">
			<label for="email">E-mail ID</label>
			<input type="email" name="email" id="email" placeholder="E-mail..." required />
			<?php
				if(isset($_GET["error"]) and $_GET["error"]=="usernamenotfound"){
					echo "<center class='error'>E-mail not registered with us!</center>";
				}
			?>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" placeholder="Password..." required />
			<?php
				if(isset($_GET["error"]) and $_GET["error"]=="wrongpassword"){
					echo "<center class='error'>Password entered is wrong!</center>";
				}
			?>
			<input type="submit" name="submit" value="Submit" placeholder="Login"/>
			<input type="button" name="create" id="create" value="Create an account" onclick="location.href='createaccount.php'"/>
		</form>
	</body>
</html>