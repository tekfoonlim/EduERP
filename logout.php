<?php
	session_start();
	if(!isset($_SESSION['fname'])){
		header("location:/www.eduerp.com/user/");
		exit();
	}
	unset($_SESSION['fname']);
	unset($_SESSION['lname']);
	unset($_SESSION['email']);
	unset($_SESSION['cid']);
	header("location:/www.eduerp.com");
?>