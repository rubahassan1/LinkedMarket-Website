<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$connID=$_GET['connID'];
$dbD=mysqli_query($con,"DELETE from connection where uID='$connID' OR connectionID='$connID'");
?>