<?php
	$ser = "localhost";
	$user = "root";
	$pass = "";
	$db = "erp";
	$conn = mysqli_connect($ser, $user, $pass, $db);
	if(!$conn){
		echo "Error in connecting to db<br>".$conn;
		exit();
	}
?>