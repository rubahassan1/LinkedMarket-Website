<?php
    session_start();
    include "config.php";

    $userid;
    if(isset($_SESSION['id'])){
        $userid=$_SESSION['id'];
    }
    if(isset($_SESSION['role'])){
        if($_SESSION['role']=="Factory"){
            $dbs=mysqli_query($con,"SELECT Bio from Factory where UID='$userid'");
            $bio=mysqli_fetch_assoc($dbs)['Bio'];
            if($bio!=NULL){
                echo $bio;
            }
        }
        else if($_SESSION['role']=="Supplier"){
            $dbs=mysqli_query($con,"SELECT Bio from Supplier where UID='$userid'");
            $bio=mysqli_fetch_assoc($dbs)['Bio'];
            if($bio!=NULL){
                echo $bio;
            }
        }
        
    }
?>