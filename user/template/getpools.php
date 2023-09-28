<?php
    if(!isset($_GET['id'])){
        exit();
    }
    require "connect.php";
    $sql = "SELECT pool FROM coursetopool WHERE course = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error in preparing statement ".$sql."<br>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt)>0){
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        echo '<tr class="pools"><td><label>Elective Subjects : </label></td>
    <td><select name="pool1">';
        while($row = mysqli_fetch_array($res)){
            $sql = "SELECT name FROM pools WHERE elective = 1 AND id = ".$row[0];
            $res1 = mysqli_query($conn, $sql);
            while($row1 = mysqli_fetch_array($res1)){
                echo '<option value="'.$row[0].'">'.$row1[0].'</option>';
            }
        }
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        echo '</select></td>';
        echo '<td><select name="pool2">';
        while($row = mysqli_fetch_array($res)){
            $sql = "SELECT name FROM pools WHERE elective = 2 AND id = ".$row[0];
            $res1 = mysqli_query($conn, $sql);
            while($row1 = mysqli_fetch_array($res1)){
                echo '<option value="'.$row[0].'">'.$row1[0].'</option>';
            }
        }
        echo '</select></td></tr>';   
    }
?>