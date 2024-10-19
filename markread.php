<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$action=$_GET['action'];

if($action=='notifications'){
    $dbU=mysqli_query($con,"UPDATE notification set `Read`='1' WHERE ReceiverID='$userid'");
}

else if($action=='requests'){
    $dbU=mysqli_query($con,"UPDATE connectionrequests set `read`='1' WHERE connectionID='$userid'");
}
?>