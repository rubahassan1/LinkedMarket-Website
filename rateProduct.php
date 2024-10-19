<?php
    session_start();
    include "config.php";

    $userid;
    if(isset($_SESSION['id'])){
        $userid=$_SESSION['id'];
    }

    $pid=$_GET['pid'];
    $rate=$_GET['rate'];
    $selectrating=mysqli_query($con,"SELECT * from user_rating where pID='$pid' AND uID='$userid'");

    if(mysqli_num_rows($selectrating)==0){
        $dbI=mysqli_query($con,"INSERT into user_rating(pID,uID,NbStars) VALUES ('$pid','$userid','$rate')");
    }
    else{
        $ratinginfo=mysqli_fetch_array($selectrating);
        $rID=$ratinginfo['rID'];
        $dbU=mysqli_query($con,"UPDATE user_rating SET NbStars='$rate' where rID='$rID'");
    }
    $selectallratings=mysqli_query($con,"SELECT * from user_rating where pID='$pid'");
    $numberofRatings=mysqli_num_rows($selectallratings);
    $sum=0;
    while($col=mysqli_fetch_array($selectallratings)){
        $sum += $col['NbStars'];
    }
    $average=$sum/$numberofRatings;
    $dbTotal=mysqli_query($con,"UPDATE rates SET NumberOfStars='$average' where pID='$pid'");
    echo "done";
?>