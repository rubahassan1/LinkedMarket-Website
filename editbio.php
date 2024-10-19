<?php
    session_start();
    include "config.php";

    $newbio=$_REQUEST['q'];
    $userid;
    $updatedbio;
    if(isset($_SESSION['id'])){
        $userid=$_SESSION['id'];
    }
    if(isset($_SESSION['role'])){
        if($_SESSION['role']=="Factory"){
            $dbU=mysqli_query($con,"UPDATE Factory SET Bio='$newbio' WHERE UID='$userid'");
            $dbS=mysqli_query($con,"SELECT Bio from Factory where UID='$userid'");
            $updatedbio=mysqli_fetch_assoc($dbS);
            echo $updatedbio['Bio'];
        }
        else if($_SESSION['role']=="Supplier"){
            $dbU=mysqli_query($con,"UPDATE Supplier SET Bio='$newbio' WHERE UID='$userid'");
            $dbS=mysqli_query($con,"SELECT Bio from Supplier where UID='$userid'");
            $updatedbio=mysqli_fetch_assoc($dbS);
            echo $updatedbio['Bio'];
        }
        
    }
?>