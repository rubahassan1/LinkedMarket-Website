<?php
session_start();
include "config.php";

$sender=$_GET['senderId'];
$receiver=$_GET['receiverId'];
$action=$_GET['action'];
if($action=="request"){
    $dbI=mysqli_query($con,"INSERT into connectionrequests(uID,connectionID) VALUES ('$sender','$receiver')");
}
if($action=="cancel"){
    $dbD=mysqli_query($con,"DELETE from connectionrequests WHERE uID='$sender' AND connectionID='$receiver'");
}
if($action=="accept"){
    $dbA=mysqli_query($con,"INSERT into connection VALUES ('$receiver','$sender')");
    $dbD=mysqli_query($con,"DELETE from connectionrequests WHERE uID='$receiver' AND connectionID='$sender'");
}
if($action=="remove"){
    $dbR=mysqli_query($con,"DELETE from connection WHERE (uID='$sender' AND connectionID='$receiver') OR (uID='$receiver' AND connectionID='$sender')");
}
?>