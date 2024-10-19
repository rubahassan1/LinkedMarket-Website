<?php
session_start();
include "config.php";

$catID=$_GET['catID'];
$dbU=mysqli_query($con,"UPDATE product SET Category=NULL where Category='$catID'");
$dbDcp=mysqli_query($con,"DELETE from category_products where catID='$catID'");
$dbDc=mysqli_query($con,"DELETE from category where categoryID='$catID'");
echo "error";
?>