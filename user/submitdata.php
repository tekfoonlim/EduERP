<?php
	session_start();
	if(isset($_POST['createcollege'])){
		$cname = $_POST['cname'];
		$clink = "www.".$_POST['clink'].$_POST['dom'];
		$logo = $_FILES['logo']['name'];
		require '../connect.php';
		$sql = "SELECT cid FROM college WHERE link = ?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing sql statement ".$sql."<br/>";
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			exit();
		}
		mysqli_stmt_bind_param($stmt, "s", $clink);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if(mysqli_stmt_num_rows($stmt)>0){
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header("location:/www.eduerp.com/user?error=niu");
			exit();
		}
		$sql = "INSERT INTO college (cname, link, logo, admission, batch) VALUES (?, ?, ?, '0', '".date("Y")."')";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing sql statement ".$sql."<br/>";
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			exit();
		}
		mysqli_stmt_bind_param($stmt, "sss", $cname, $clink, $logo);
		mysqli_stmt_execute($stmt);
		$sql = "SELECT cid FROM college WHERE link = ?";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing sql statement ".$sql."<br/>";
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			exit();
		}
		mysqli_stmt_bind_param($stmt, "s", $clink);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_array($res, MYSQLI_NUM);
		$_SESSION['cid'] = $row[0];
		$sql = "UPDATE user SET cid = ? WHERE email = ?";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in running sql statement ".$sql."<br/>";
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			exit();
		}
		mysqli_stmt_bind_param($stmt, "is", $_SESSION['cid'], $_SESSION['email']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		if(!mkdir("../../".$clink)){
			echo "Unable to create directory";
			exit();
		}
		require 'generatefiles.php';
		exit();
	}else if(isset($_POST['createdept'])){
		$acad = 0;
		if(isset($_POST['acad'])){
			$acad = 1;
		}
		$sql = "INSERT INTO department(cid, dname, description, academic) VALUES(?, ?, ?, ".$acad.")";
		require '../connect.php';
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br/>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "iss", $_SESSION['cid'], $_POST['dname'], $_POST['desc']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=departments");
		exit();
	}else if(isset($_POST['admissiondata'])){
		require "../connect.php";
		$sql = "UPDATE college SET admission = ? AND batch = ? WHERE cid = ".$_SESSION['cid'];
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		$adm = 0;
		if(isset($_POST['adm']))
			$adm = 1;
		mysqli_stmt_bind_param($stmt, "ii", $adm, $_POST['yoa']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=settings");
		exit();
	}else if(isset($_POST['createnotice'])){
		$sql = "INSERT INTO notice(cid, title, description, date) VALUES(".$_SESSION['cid'].", ?, ?, ?)";
		echo $sql;
		require "../connect.php";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'Unable to prepare sql statement '.$sql.'<br/>';
			exit();
		}
		mysqli_stmt_bind_param($stmt, "sss", $_POST['title'], $_POST['desc'], $_POST['date']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=notices");
		exit();
	}else if(isset($_POST['uploadphoto'])){
		if(isset($_FILES['photo'])){
			require "../connect.php";
			$file_name = $_FILES['photo']['name'];
			$file_size =$_FILES['photo']['size'];
			$file_tmp =$_FILES['photo']['tmp_name'];
			$file_type=$_FILES['photo']['type'];
			$tmp = explode('.',$_FILES['photo']['name']);
			$file_ext=strtolower(end($tmp));
			$extensions= array("jpeg","jpg","png");
			
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, "SELECT * FROM gallery WHERE photo = ? AND cid = ".$_SESSION['cid'])){
				echo "Error in preparing statement SELECT * FROM gallery WHERE photo = ? AND cid = ".$_SESSION['cid']."<br>";
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
				exit();
			}
			mysqli_stmt_bind_param($stmt, "s", $_FILES['photo']['name']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt)>0){
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
				header("location:/www.eduerp.com/user?menu=gallery&error=niu");
				exit();
			}
			$cover = 0;
			if(isset($_POST['cover'])){
				$cover = 1;
				$sql = "UPDATE gallery SET cover = 0 WHERE cover = 1";
				mysqli_query($conn, $sql);
			}
			$sql = "SELECT link FROM college WHERE cid = ".$_SESSION['cid'];
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($res);
			$clink = $row[0];
			mysqli_close($conn);
			$errors= array();
			if(in_array($file_ext,$extensions)=== false){
				$errors[]="Extension not allowed, please choose a JPEG or PNG file.";
			}
			if($file_size > 2097152){
				$errors[]='File size must be less than or equal to 2 MB';
			}
			if(empty($errors)==true){
				move_uploaded_file($file_tmp,"../../".$clink."/".$file_name);
			}else{
				for($i = 0; $i < sizeof($errors); $i++)
					echo $errors[$i]."<br>";
				exit();
			}
			require "../connect.php";
			$sql = "INSERT INTO gallery(cid, photo, cover) VALUES(?, ?, ".$cover.")";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)){
				echo "Error in preparing statement ".$sql."<br/>";
				exit();
			}
			mysqli_stmt_bind_param($stmt, "is", $_SESSION['cid'], $file_name);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header("location:/www.eduerp.com/user?menu=gallery");
			exit();
		}else{
			echo "Could not upload logo<br>";
			exit();
		}
	}else if(isset($_POST['staff'])){
		require "../connect.php";
		$stmt = mysqli_stmt_init($conn);
		$sql = "INSERT INTO staff(cid, fname, mname, lname, email, contact, password, dob, salary, did) VALUES(".$_SESSION['cid'].", ?, ?, ?, ?, ?, ?, ?, ?, ".$_POST['dept'].")";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			exit();
		}
		$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
		mysqli_stmt_bind_param($stmt, "ssssissi", $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['mail'], $_POST['phno'], $pass, $_POST['dob'], $_POST['salary']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=faculty");
		exit();
	}else if(isset($_POST['editcollege'])){
		require "../connect.php";
		$res = mysqli_query($conn, "SELECT link, logo FROM college WHERE cid = ".$_SESSION['cid']);
		$row = mysqli_fetch_array($res);
		$oldlink = $row[0];
		$oldlogo = $row[1];
		$stmt = mysqli_stmt_init($conn);
		$cname = $_POST['cname'];
		$clink = "www.".$_POST['clink'].$_POST['dom'];
		$logo = $_FILES['logo']['name'];
		$sql = "UPDATE college SET cname = ?, link = ?, logo = ? WHERE cid = ".$_SESSION['cid'];
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'Error in preparing sql statement '.$sql.'<br>';
			exit();
		}
		mysqli_stmt_bind_param($stmt, "sss", $cname, $clink, $logo);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		unlink("../../".$oldlink."/".$oldlogo);
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
				move_uploaded_file($file_tmp,"../../".$oldlink."/".$file_name);
				echo "Success";
			}else{
				print_r($errors);
				exit();
			}
		}else{
			echo "Could not upload logo<br>";
			exit();
		}
		rename("../../".$oldlink, "../../".$clink);
		header("location:/www.eduerp.com/user/");
		exit();
	}else if(isset($_POST['createcourse'])){
		require "../connect.php";
		$stmt = mysqli_stmt_init($conn);
		$sql = "INSERT INTO courses(did, cid, name, description, terms, duration, pg) VALUES(?, ?, ?, ?, ?, ?, ?)";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in statement ".$sql."<br>";
			exit();
		}
		$pg = $_POST['grad']=="ug"?0:1;
		mysqli_stmt_bind_param($stmt, "iissiii", $_POST['dept'], $_SESSION['cid'], $_POST['crname'], $_POST['crdesc'], $_POST['crterms'], $_POST['cryrs'], $pg);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user?menu=courses");
	}else if(isset($_POST['createsubject'])){
		require "../connect.php";
		$stmt = mysqli_stmt_init($conn);
		$sql = "INSERT INTO subjects(cid, code, name, course) VALUES(?, ?, ?, ?)";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'Error in preparing statement '.$sql.'<br>';
			exit();
		}
		mysqli_stmt_bind_param($stmt, "issi", $_SESSION['cid'], $_POST['subcode'], $_POST['subname'], $_POST['subcourse']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user/?menu=subject");
		exit();
	}else if(isset($_POST['createpool'])){
		require "../connect.php";
		$stmt = mysqli_stmt_init($conn);
		$sql = "INSERT INTO pools(cid, name, elective) VALUES(?, ?, ?)";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'Error in preparing statement'.$sql.'<br>';
			exit();
		}
		mysqli_stmt_bind_param($stmt, "isi", $_SESSION['cid'], $_POST['poolname'], $_POST['elective']);
		mysqli_stmt_execute($stmt);
		$sql = "SELECT id FROM pools WHERE name = ? AND cid = ? AND elective = ?";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'Error in preparing statement '.$sql.'<br>';
			exit();
		}
		mysqli_stmt_bind_param($stmt, "sii", $_POST['poolname'], $_SESSION['cid'], $_POST['elective']);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_array($res);
		$sql = "INSERT INTO subtopool(pool, subject) VALUES (?, ?)";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'Error in preparing statement '.$sql.'<br>';
			exit();
		}
		mysqli_stmt_bind_param($stmt, "ii", $row[0], $sub);
		foreach($_POST['poolsub'] as $sub){
			mysqli_stmt_execute($stmt);
		}
		$sql = "INSERT INTO coursetopool(pool, course) VALUES(?, ?)";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'Error in preparing statement '.$sql.'<br>';
			exit();
		}
		mysqli_stmt_bind_param($stmt, "ii", $row[0], $course);
		foreach($_POST['poolcourse'] as $course){
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header("location:/www.eduerp.com/user/?menu=subject");
		exit();
	}else if(isset($_POST['student'])){
		require "../connect.php";
		$sql = "SELECt * FROM student WHERE cid = ? AND roll = ?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		mysqli_stmt_bind_param($stmt, "is", $_SESSION['cid'], $_POST['roll']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if(mysqli_stmt_num_rows($stmt)>0){
			header("location:/www.eduerp.com/user/?menu=students&error=rollalreadyused");
			exit();
		}
		$sql = "INSERT INTO student(cid, name, roll, gender, dob, yoa, contact, email, address, city, state, country, course, elective1, elective2) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "Error in preparing statement ".$sql."<br>";
			exit();
		}
		if($_POST['mname']=="")
			$name = $_POST['fname']." ".$_POST['lname'];
		else
			$name = $_POST['fname']." ".$_POST['mname']." ".$_POST['lname'];
		$gender = $_POST['gender']=="m"?0:1;
		$year = date("Y");
		$elec1 = 0;
		if(isset($_POST['pool1']))
			$elec1 = $_POST['pool1'];
		$elec2 = 0;
		if(isset($_POST['pool2']))
			$elec2 = $_POST['pool2'];
		mysqli_stmt_bind_param($stmt, "issisissssssiii", $_SESSION['cid'], $name, $_POST['roll'], $gender, $_POST['dob'], $year, $_POST['contact'], $_POST['mail'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['country'], $_POST['course'], $elec1, $elec2);
		mysqli_stmt_execute($stmt);
		header("location:/www.eduerp.com/user/?menu=students");
	}else{
		header("location:/www.eduerp.com");
		exit();
	}
?>