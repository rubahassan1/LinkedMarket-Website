<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

if($_SESSION['role']=="Factory"){ //if user is a factory
    $dbTasks=mysqli_query($con,"DELETE from tasks where fID='$userid'"); //delete factory's tasks
    $factoryID=mysqli_query($con,"SELECT * from factory where UID='$userid'");
    $fid=mysqli_fetch_array($factoryID)['FID'];
    $dbprodRequests=mysqli_query($con,"DELETE from product_requests where fID='$fid'"); //delete received product requests
    $dbFactory=mysqli_query($con,"DELETE from factory where UID='$userid'"); //delete from table factory
}

if($_SESSION['role']=="Supplier"){ //if user is a supplier
    $dbSupplier=mysqli_query($con,"DELETE from supplier where UID='$userid'");
    $getCatalog=mysqli_query($con,"SELECT * from catalog where uID='$userid'");
    $catalogID=mysqli_fetch_array($getCatalog)['cID'];
    $getCategories=mysqli_query($con,"SELECT * from category where catalogID='$catalogID'");
    while($category=mysqli_fetch_array($getCategories)){
        $categoryID=$category['categoryID'];
        $deleteCatProducts=mysqli_query($con, "DELETE from category_products where catID='$categoryID'");//delete categories products
    }
    $dbCategory=mysqli_query($con,"DELETE from category where catalogID='$catalogID'"); //delete categories
    $dbCatalog=mysqli_query($con, "DELETE from catalog where uID='$userid'"); //delete supplier's catalog
}

if($_SESSION['role']=="Buyer"){ //if user is a buyer
    $dbBuyer=mysqli_query($con,"DELETE from buyer where UID='$userid'"); //delete from table buyer
    $dbprodRequests=mysqli_query($con,"DELETE from product_requests where requesterID='$userid'");
}

if($_SESSION['role']=="Factory" || $_SESSION['role']=="Supplier"){ //common features between supplier and factory
    $getProducts=mysqli_query($con,"SELECT * from product where U_ID='$userid'");
    while($product=mysqli_fetch_array($getProducts)){
        $pid=$product['pID'];
        $dbwishlistProd=mysqli_query($con,"DELETE from wishlist_products where pID='$pid'");
        $dbrating=mysqli_query($con,"DELETE from user_rating where pID='$pid'");
        $dbrate=mysqli_query($con,"DELETE from rates where pID='$pid'");
        $dbfeedbackDelete=mysqli_query($con,"DELETE from feedback where pID='$pid'");
        $dbPlacedOrder=mysqli_query($con,"DELETE from placed_order where sellerID='$userid'");
        $dbOrderProd=mysqli_query($con,"DELETE from order_products where pID='$pid'");
        $dbOrder=mysqli_query($con,"DELETE from `order` where sellerID='$userid'");
    }
    $dbProduct=mysqli_query($con,"DELETE from product where U_ID='$userid'");
}

if($_SESSION['role']=="Factory" || $_SESSION['role']=="Buyer"){ //common features between buyer and factory
    $dbfeedback=mysqli_query($con,"DELETE from feedback where uID='$userid'");
    $dbPlace=mysqli_query($con,"DELETE from placed_order where customerID='$userid'");
    $getCustomerOrders=mysqli_query($con,"SELECT * from `order` where customerID='$userid'");
    while($order=mysqli_fetch_array($getCustomerOrders)){
        $oid=$order['oID'];
        $dbOrderProducts=mysqli_query($con,"DELETE from order_products where oID='$oid'");
    }
    $dbOrders=mysqli_query($con,"DELETE from `order` where customerID='$userid'");
    $getwishlist=mysqli_query($con,"SELECT * from wishlist where uID='$userid'");
    $wid=mysqli_fetch_array($getwishlist)['wID'];
    $dbWishlistProducts=mysqli_query($con,"DELETE from wishlist_products where wID='$wid'");
    $dbWishlist=mysqli_query($con,"DELETE from wishlist where uID='$userid'");
    $sum=0;
    $nbRates=0;
    $getUser_rates=mysqli_query($con,"SELECT * from user_rating where uID='$userid'");
    while($rate=mysqli_fetch_array($getUser_rates)){
        $rid=$rate['rID'];
        $pid=$rate['pID'];
        $dbDeleteRate=mysqli_query($con,"DELETE from user_rating where rID='$rid'");
        $selectNewproductRates=mysqli_query($con,"SELECT * from user_rating where pID='$pid'");
        $nbRates=mysqli_num_rows($selectNewproductRates);
        while($prodRating=mysqli_fetch_array($selectNewproductRates)){
            $userRate=$prodRating['NbStars'];
            $sum+=$userRate;
        }
        $average=$sum/$nbRates;
        $dbUpdateRate=mysqli_query($con,"UPDATE rates SET NumberOfStars='$average'");

    }
}

//delete all connections
$dbConnection=mysqli_query($con,"DELETE from connection where uID='$userid' OR connectionID='$userid'");
//delete all connection requests
$dbConnectionRequest=mysqli_query($con,"DELETE from connectionrequests where uID='$userid' OR connectionID='$userid'");
//delete received notifications
$dbNotification=mysqli_query($con,"DELETE from `notification` where ReceiverID='$userid'");
//And finally delete user
$dbUser=mysqli_query($con,"DELETE from user where ID='$userid'");

session_unset();
session_destroy();

?>