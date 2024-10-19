<?php
session_start();
include "config.php";

$oid=$_GET['oid'];
$action=$_GET['action'];

$dbS=mysqli_query($con,"SELECT * from placed_order where oID='$oid'");
$order=mysqli_fetch_array($dbS);
$receiverID=$order['customerID'];
$sellerID=$order['sellerID'];
if($action=='sent'){
    $selectseller=mysqli_query($con,"SELECT * from user where ID='$sellerID'");
    $selectcustomer=mysqli_query($con,"SELECT * from user where ID='$receiverID'");
    $seller=mysqli_fetch_array($selectseller);
    $customer=mysqli_fetch_array($selectcustomer);
    $content = "Dear ".$customer['Username'].", your order from ".$seller['Username']." placed on ".$order['Date']." is now sent to you, you may receive it soon.";
    $dbI=mysqli_query($con,"INSERT into `notification`(content,ReceiverID,Date) VALUES('$content','$receiverID',NOW())");
    $dbU=mysqli_query($con,"UPDATE placed_order set Notified='1' where oID='$oid'");
}
else if($action=='received'){
    $selectseller=mysqli_query($con,"SELECT * from user where ID='$sellerID'");
    $selectcustomer=mysqli_query($con,"SELECT * from user where ID='$receiverID'");
    $seller=mysqli_fetch_array($selectseller);
    $customer=mysqli_fetch_array($selectcustomer);
    $content = "Dear ".$seller['Username'].", the order you sent to ".$customer['Username']." is received. Thank You.";
    $dbI=mysqli_query($con,"INSERT into `notification`(content,ReceiverID,Date) VALUES('$content','$sellerID',NOW())");
    if($seller['Role']=="Factory"){
        $dbSales=mysqli_query($con,"UPDATE factory set Sales = Sales + '". $order['orderPrice'] ."' where UID='$sellerID'");
    }
    else if($seller['Role']=="Supplier"){
        $dbSales=mysqli_query($con,"UPDATE Supplier set Sales = Sales + '". $order['orderPrice'] ."' where UID='$sellerID'");
    }
    $dbDeletePlaced=mysqli_query($con,"DELETE from placed_order where oID='$oid'");
    $dbDeleteOrderPr=mysqli_query($con,"DELETE from order_products where oID='$oid'");
    $dbDeleteOrder=mysqli_query($con,"DELETE from `order` where oID='$oid'");
}
echo "done";
?>