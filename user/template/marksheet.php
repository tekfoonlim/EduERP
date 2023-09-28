<?php
    session_start();
    if(isset($_POST['submit'])){
        require "connect.php";
        $res = mysqli_query($conn, "SELECT DISTINCT subjects.id, subjects.code FROM subjects, subtopool, student WHERE student.id = ".$_POST['id']." AND (subjects.course = student.course OR ((student.elective1 = subtopool.pool OR student.elective2 = subtopool.pool) AND subtopool.subject = subjects.id)) ORDER BY subjects.code");
        $i = 0;
        while($row = mysqli_fetch_array($res)){
            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM marks WHERE subject = ".$row[0]." AND student = ".$_POST['id']." AND cid = ".$_POST['cid']))){
                $sql = "UPDATE marks SET ttmarks = ?, tfmarks = ?, ptmarks = ?, pfmarks = ?, grade = ? WHERE student = ".$_POST['id']." AND subject = ".$row[0]." AND cid = ".$_POST['cid'];
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "iiiis", $_POST['ttmarks'][$i], $_POST['tfmarks'][$i], $_POST['ptmarks'][$i], $_POST['pfmarks'][$i], $_POST['grade'][$i]);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }else{
                $sql = "INSERT INTO marks(cid, student, subject, ttmarks, tfmarks, ptmarks, pfmarks, grade) VALUES(?,?,?,?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "iiiiiiis", $_POST['cid'], $_POST['id'], $row[0], $_POST['ttmarks'][$i], $_POST['tfmarks'][$i], $_POST['ptmarks'][$i], $_POST['pfmarks'][$i], $_POST['grade'][$i]);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            $i = $i+1;
        }
        mysqli_close($conn);
        header("location:staff.php");
        exit();
    }
    header("location:index.php");
?>