<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$pid=$_GET['pid'];
$cid=$_GET['catID'];

$dbD=mysqli_query($con,"DELETE FROM category_products WHERE pID='$pid' AND catID='$cid'");
$dbNbPr=mysqli_query($con,"UPDATE category SET NbOfProducts=NbOfProducts-1 WHERE categoryID='$cid'");
$dbUp=mysqli_query($con,"UPDATE product set Category=NULL where pID='$pid'");
?>
