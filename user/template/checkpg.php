<?php
    if(!isset($_GET['id'])){
        exit();
    }
    require "connect.php";
    $sql = "SELECT pg FROM courses WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error in preparing statement ".$sql."<br>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($res);
    if($row[0]==1){
        echo '<tr class="del"><td><label for="gcol">Graduation College and Percentage: </label></td>
        <td><input type="text" name="gcol" id="gcol" placeholder="Graduation college..." required /></td>
        <td><input type="number" name="gmarks" id="gmarks" placeholder="Graduation marks percentage..." required /></td></tr>';
    }
?>