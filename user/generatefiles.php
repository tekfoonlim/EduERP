<?php
	if(!isset($_POST['createcollege'])){
		header("location:/www.eduerp.com/");
		exit();
	}
	if(isset($_FILES['logo'])){
		$errors= array();
		$file_name = $_FILES['logo']['name'];
		$file_size =$_FILES['logo']['size'];
		$file_tmp =$_FILES['logo']['tmp_name'];
		$file_type=$_FILES['logo']['type'];
		$file_ext=strtolower(end(explode('.',$_FILES['logo']['name'])));
		$extensions= array("jpeg","jpg","png");
		if(in_array($file_ext,$extensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
		}
		if($file_size > 2097152){
			$errors[]='File size must be exactly 2 MB';
		}
		if(empty($errors)==true){
			move_uploaded_file($file_tmp,"../../".$clink."/".$file_name);
			echo "Success";
		}else{
			print_r($errors);
			exit();
		}
	}else{
		echo "Could not upload logo<br>";
		exit();
	}
	$txt = '<?php
	require "connect.php";
	$cid = '.$_SESSION['cid'].';
	$sql = "SELECT * FROM college WHERE cid = ".$cid;
	if($res = mysqli_query($conn, $sql)){
		$row = mysqli_fetch_assoc($res);
		$cname = $row["cname"];
		$link = $row["link"];
		$logo = $row["logo"];
	}else{
		echo "Error in running sql code ".$sql."<br/>";
		mysqli_close($conn);
		exit();
	}
	mysqli_close($conn);
	require "../www.eduerp.com/user/template/index.php";
?>';
	$f1 = fopen("../../".$clink."/index.php", "w");
	fwrite($f1, $txt);
	fclose($f1);
	$f1 = fopen("../../".$clink."/homepage.css", "w");
	$txt = fopen("template/homepage.css", "r");
	fwrite($f1, fread($txt, filesize("template/homepage.css")));
	fclose($f1);
	fclose($txt);
	$f1 = fopen("../../".$clink."/connect.php", "w");
	$txt = fopen("../connect.php", "r");
	fwrite($f1, fread($txt, filesize("../connect.php")));
	fclose($f1);
	fclose($txt);
	$txt = '<?php
	require "connect.php";
	$cid = '.$_SESSION['cid'].';
	$sql = "SELECT * FROM college WHERE cid = ".$cid;
	if($res = mysqli_query($conn, $sql)){
		$row = mysqli_fetch_assoc($res);
		$cname = $row["cname"];
		$link = $row["link"];
		$logo = $row["logo"];
	}else{
		echo "Error in running sql code ".$sql."<br/>";
		mysqli_close($conn);
		exit();
	}
	mysqli_close($conn);
	require "../www.eduerp.com/user/template/admission.php";
?>';
	$f1 = fopen("../../".$clink."/admission.php", "w");
	fwrite($f1, $txt);
	fclose($f1);
	$f1 = fopen("../../".$clink."/admission.css", "w");
	$txt = fopen("template/admission.css", "r");
	fwrite($f1, fread($txt, filesize("template/admission.css")));
	fclose($f1);
	fclose($txt);
	$f1 = fopen("../../".$clink."/menu.php", "w");
	$txt = fopen("template/menu.php", "r");
	fwrite($f1, fread($txt, filesize("template/menu.php")));
	fclose($f1);
	fclose($txt);
	$txt = '<?php
	require "connect.php";
	$cid = '.$_SESSION['cid'].';
	$sql = "SELECT * FROM college WHERE cid = ".$cid;
	if($res = mysqli_query($conn, $sql)){
		$row = mysqli_fetch_assoc($res);
		$cname = $row["cname"];
		$link = $row["link"];
		$logo = $row["logo"];
	}else{
		echo "Error in running sql code ".$sql."<br/>";
		mysqli_close($conn);
		exit();
	}
	mysqli_close($conn);
	require "../www.eduerp.com/user/template/department.php";
?>';
	$f1 = fopen("../../".$clink."/department.php", "w");
	fwrite($f1, $txt);
	fclose($f1);
	$txt = '<?php
	require "connect.php";
	$cid = '.$_SESSION['cid'].';
	$sql = "SELECT * FROM college WHERE cid = ".$cid;
	if($res = mysqli_query($conn, $sql)){
		$row = mysqli_fetch_assoc($res);
		$cname = $row["cname"];
		$link = $row["link"];
		$logo = $row["logo"];
	}else{
		echo "Error in running sql code ".$sql."<br/>";
		mysqli_close($conn);
		exit();
	}
	mysqli_close($conn);
	require "../www.eduerp.com/user/template/apply.php";
?>';
	$f1 = fopen("../../".$clink."/apply.php", "w");
	fwrite($f1, $txt);
	fclose($f1);
	$f1 = fopen("../../".$clink."/application.css", "w");
	$txt = fopen("template/application.css", "r");
	fwrite($f1, fread($txt, filesize("template/application.css")));
	fclose($f1);
	fclose($txt);
	$f1 = fopen("../../".$clink."/checkpg.php", "w");
	$txt = fopen("template/checkpg.php", "r");
	fwrite($f1, fread($txt, filesize("template/checkpg.php")));
	fclose($f1);
	fclose($txt);
	$f1 = fopen("../../".$clink."/getpools.php", "w");
	$txt = fopen("template/getpools.php", "r");
	fwrite($f1, fread($txt, filesize("template/getpools.php")));
	fclose($f1);
	fclose($txt);
	$txt = '<?php
	require "connect.php";
	$cid = '.$_SESSION['cid'].';
	$sql = "SELECT * FROM college WHERE cid = ".$cid;
	if($res = mysqli_query($conn, $sql)){
		$row = mysqli_fetch_assoc($res);
		$cname = $row["cname"];
		$link = $row["link"];
		$logo = $row["logo"];
	}else{
		echo "Error in running sql code ".$sql."<br/>";
		mysqli_close($conn);
		exit();
	}
	mysqli_close($conn);
	require "../www.eduerp.com/user/template/gallery.php";
?>';
	$f1 = fopen("../../".$clink."/gallery.php", "w");
	fwrite($f1, $txt);
	fclose($f1);
	$f1 = fopen("../../".$clink."/gallery.css", "w");
	$txt = fopen("template/gallery.css", "r");
	fwrite($f1, fread($txt, filesize("template/gallery.css")));
	fclose($f1);
	fclose($txt);
	$txt = '<?php
	require "connect.php";
	$cid = '.$_SESSION['cid'].';
	$sql = "SELECT * FROM college WHERE cid = ".$cid;
	if($res = mysqli_query($conn, $sql)){
		$row = mysqli_fetch_assoc($res);
		$cname = $row["cname"];
		$link = $row["link"];
		$logo = $row["logo"];
	}else{
		echo "Error in running sql code ".$sql."<br/>";
		mysqli_close($conn);
		exit();
	}
	mysqli_close($conn);
	require "../www.eduerp.com/user/template/staff.php";
?>';
	$f1 = fopen("../../".$clink."/staff.php", "w");
	fwrite($f1, $txt);
	fclose($f1);
	$f1 = fopen("../../".$clink."/staff.css", "w");
	$txt = fopen("template/staff.css", "r");
	fwrite($f1, fread($txt, filesize("template/staff.css")));
	fclose($f1);
	fclose($txt);
	$txt = '<?php
	require "connect.php";
	$cid = '.$_SESSION['cid'].';
	$sql = "SELECT * FROM college WHERE cid = ".$cid;
	if($res = mysqli_query($conn, $sql)){
		$row = mysqli_fetch_assoc($res);
		$cname = $row["cname"];
		$link = $row["link"];
		$logo = $row["logo"];
	}else{
		echo "Error in running sql code ".$sql."<br/>";
		mysqli_close($conn);
		exit();
	}
	mysqli_close($conn);
	require "../www.eduerp.com/user/template/student.php";
?>';
	$f1 = fopen("../../".$clink."/student.php", "w");
	fwrite($f1, $txt);
	fclose($f1);
	$f1 = fopen("../../".$clink."/student.css", "w");
	$txt = fopen("template/student.css", "r");
	fwrite($f1, fread($txt, filesize("template/student.css")));
	fclose($f1);
	fclose($txt);
	$f1 = fopen("../../".$clink."/marksheet.php", "w");
	$txt = fopen("template/marksheet.php", "r");
	fwrite($f1, fread($txt, filesize("template/marksheet.php")));
	fclose($f1);
	fclose($txt);
	$f1 = fopen("../../".$clink."/logout.php", "w");
	$txt = fopen("template/logout.php", "r");
	fwrite($f1, fread($txt, filesize("template/logout.php")));
	fclose($f1);
	fclose($txt);
	header("location:/www.eduerp.com/");
	exit();
?>