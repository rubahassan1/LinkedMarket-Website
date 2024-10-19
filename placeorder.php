<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$oid=$_GET['oid'];
$dborder=mysqli_query($con,"SELECT * from `order` where oID='$oid'");
$orderinfo=mysqli_fetch_array($dborder);
$sellerId=$orderinfo['sellerID'];
$orderPrice=$orderinfo['orderPrice'];
$NbOfProducts=$orderinfo['NumberOfProducts'];
$action=$_GET['action'];
if($action=="place"){
    $dbPlace=mysqli_query($con,"INSERT into placed_order(oID,sellerID,customerID,orderPrice,NumberOfProducts,Date) Values('$oid','$sellerId','$userid','$orderPrice','$NbOfProducts',NOW())");
}
else if($action=="cancel"){
    $dbCancel=mysqli_query($con,"DELETE from placed_order where oID='$oid'");
}
?>