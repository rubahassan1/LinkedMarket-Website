<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}
$pid=$_GET['pid'];
$oid=$_GET['oid'];

$dbproduct=mysqli_query($con,"SELECT * from order_products where oID='$oid' AND pID='$pid'");
$productinfo=mysqli_fetch_array($dbproduct);
$pprice=$productinfo['totalPrice'];

$dborder=mysqli_query($con,"SELECT * from `order` where oID='$oid'");
$orderinfo=mysqli_fetch_array($dborder);
$sellerId=$orderinfo['sellerID'];
$orderPrice=$orderinfo['orderPrice'];
$nbProducts=$orderinfo['NumberOfProducts'];
echo $userid." ".$pprice." ".$sellerId." ".$orderPrice." ".$nbProducts;

if ($nbProducts == 1) {
    $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$oid' AND pID='$pid'");
    $deleteOrder = mysqli_query($con, "DELETE FROM `order` WHERE oID='$oid'");
} else {
    $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$oid' AND pID='$pid'");
    $updateOrder = mysqli_query($con, "UPDATE `order` SET orderPrice = orderPrice - '$pprice', NumberOfProducts = NumberOfProducts - 1 WHERE sellerID='$sellerId' AND customerID='$userid'");
}
?>