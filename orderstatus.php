<?php
session_start();
include "config.php";

$oid=$_GET['oid'];
$status=$_GET['status'];

$dbS=mysqli_query($con,"SELECT * from placed_order where oID='$oid'");
$order=mysqli_fetch_array($dbS);
$receiverID=$order['customerID'];
$sellerID=$order['sellerID'];
$dbU=mysqli_query($con,"UPDATE placed_order SET status='$status' where oID='$oid'");
?>