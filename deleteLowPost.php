<?php
session_start();
include "config.php";

$pid=$_GET['pid'];
$action=$_GET['action'];

$dbS=mysqli_query($con,"SELECT * from product where pID='$pid'");
$product=mysqli_fetch_array($dbS);

$userID=$product['U_ID'];
$dbUser=mysqli_query($con,"SELECT * from user where ID='$userID'");
$user=mysqli_fetch_array($dbUser);
$username=$user['Username'];

if($action=='notify'){
    $notification="Dear ".$username.",<br><br>Your post \"".$product['Name']."\" has received a low rating. As part of our quality assurance process, we want to inform you that posts with low ratings may be subject to removal if they do not receive positive feedback or a higher rating in the future.\n\nPlease take this into consideration and consider making any necessary improvements to ensure the quality and relevance of your posts.\n\nThank you for your understanding and cooperation.<br><br>Sincerely,<br>The LinkedMarket Team";
    $dbI=mysqli_query($con,"INSERT into notification(content,ReceiverID,Date) VALUES('$notification','$userID',NOW())");
}
else if($action=='remove'){
    $select_orders=mysqli_query($con,"SELECT * from order_products where pID='$pid'");
if(mysqli_num_rows($select_orders)!=0){
    while($order=mysqli_fetch_array($select_orders)){
        $oid=$order['oID'];
        $dbproduct=mysqli_query($con,"SELECT * from order_products where oID='$oid' AND pID='$pid'");
        $productinfo=mysqli_fetch_array($dbproduct);
        $pprice=$productinfo['totalPrice'];

        $dborder=mysqli_query($con,"SELECT * from `order` where oID='$oid'");
        $orderinfo=mysqli_fetch_array($dborder);
        $sellerId=$orderinfo['sellerID'];
        $orderPrice=$orderinfo['orderPrice'];
        $nbProducts=$orderinfo['NumberOfProducts'];

        if ($nbProducts == 1) {
            $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$oid' AND pID='$pid'");
            $deleteOrder = mysqli_query($con, "DELETE FROM `order` WHERE oID='$oid'");
        } else {
            $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$oid' AND pID='$pid'");
            $updateOrder = mysqli_query($con, "UPDATE `order` SET orderPrice = orderPrice - '$pprice', NumberOfProducts = NumberOfProducts - 1 WHERE sellerID='$sellerId' AND customerID='$userID'");
        }
    }
}

$dbDWishlist=mysqli_query($con,"DELETE from wishlist_products where pID='$pid'");

$dbDrating=mysqli_query($con,"DELETE from user_rating where pID='$pid'");

$dbDrates=mysqli_query($con,"DELETE from rates where pID='$pid'");

$dbDfeedbacks=mysqli_query($con,"DELETE from feedback where pID='$pid'");

$dbselectCat=mysqli_query($con,"SELECT * from category_products where pID='$pid'");
if(mysqli_num_rows($dbselectCat)!=0){
    $dbCatID=mysqli_fetch_array($dbselectCat)['catID'];
    $dbUpdate=mysqli_query($con,"UPDATE category set NbOfProducts = NbOfProducts - 1 where categoryID='$dbCatID'");
}
$dbDCategory=mysqli_query($con,"DELETE from category_products where pID='$pid'");


$dbDproduct=mysqli_query($con,"DELETE from product where pID='$pid'");

}
?>