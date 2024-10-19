<?php
session_start();
include "config.php";

// Sanitize and validate input parameters
$action = isset($_GET['action']) ? $_GET['action'] : '';
$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
$pqty = isset($_GET['pqty']) ? $_GET['pqty'] : '';
$sellerId = isset($_GET['seller']) ? $_GET['seller'] : '';
$customerId = isset($_GET['customer']) ? $_GET['customer'] : '';
$pprice = isset($_GET['ptotalprice']) ? $_GET['ptotalprice'] : '';

// Validate action
if (!in_array($action, ['add', 'remove'])) {
    die("Invalid action");
}

// Validate numeric inputs
if (!is_numeric($pid) || !is_numeric($pqty) || !is_numeric($sellerId) || !is_numeric($customerId) || !is_numeric($pprice)) {
    die("Invalid input");
}

// Prevent SQL injection
$sellerId = mysqli_real_escape_string($con, $sellerId);
$customerId = mysqli_real_escape_string($con, $customerId);
$pid = mysqli_real_escape_string($con, $pid);
$pqty = mysqli_real_escape_string($con, $pqty);
$pprice = mysqli_real_escape_string($con, $pprice);

// Perform action
if ($action == "add") {
    $dbS = mysqli_query($con, "SELECT * FROM `order` WHERE sellerID='$sellerId' AND customerID='$customerId'");
    if (mysqli_num_rows($dbS) == 0) { //if there is no order
        $dbI = mysqli_query($con, "INSERT INTO `order` (sellerID, customerID, orderPrice, NumberOfProducts) VALUES ('$sellerId','$customerId','$pprice','1')");
        $dbOrderId = mysqli_query($con, "SELECT oID FROM `order` WHERE sellerID='$sellerId' AND customerID='$customerId'");
        $orderId = mysqli_fetch_assoc($dbOrderId)['oID'];
        $dbIproduct = mysqli_query($con, "INSERT INTO order_products (oID, pID, quantity, totalPrice) VALUES ('$orderId','$pid','$pqty','$pprice')");
    } else { //if there is an order
        $found=false;
        while($result=mysqli_fetch_array($dbS)){ //check each order
            $oid=$result['oID'];
            $dbPlaced=mysqli_query($con,"SELECT * from placed_order WHERE oID='$oid'");
            if(mysqli_num_rows($dbPlaced)==0){ //if the order is not placed
                $dbU = mysqli_query($con, "UPDATE `order` SET orderPrice = orderPrice + '$pprice', NumberOfProducts = NumberOfProducts + 1 WHERE oID='$oid'");
                $dbUPlaced = mysqli_query($con, "UPDATE `placed_order` SET orderPrice = orderPrice + '$pprice', NumberOfProducts = NumberOfProducts + 1, Date=NOW() WHERE oID='$oid'");
                $dbIproduct = mysqli_query($con, "INSERT INTO order_products (oID, pID, quantity, totalPrice) VALUES ('$oid','$pid','$pqty','$pprice')");
                $found=true;
                break;
            }
            else { //if the order is placed
                $dbNotSent=mysqli_query($con,"SELECT * from placed_order WHERE oID='$oid' AND status is NULL");
                if(mysqli_num_rows($dbNotSent)){ //if the order is placed but not sent
                    $placedorder=mysqli_fetch_array($dbNotSent);
                    $oid=$placedorder['oID'];
                    $dbU = mysqli_query($con, "UPDATE `order` SET orderPrice = orderPrice + '$pprice', NumberOfProducts = NumberOfProducts + 1 WHERE oID='$oid'");
                    $dbUPlaced = mysqli_query($con, "UPDATE `placed_order` SET orderPrice = orderPrice + '$pprice', NumberOfProducts = NumberOfProducts + 1, Date=NOW() WHERE oID='$oid'");
                    $dbIproduct = mysqli_query($con, "INSERT INTO order_products (oID, pID, quantity, totalPrice) VALUES ('$oid','$pid','$pqty','$pprice')");
                    $found=true;
                    break;
                }
            }
        }
        if($found==false){
            $dbI = mysqli_query($con, "INSERT INTO `order` (sellerID, customerID, orderPrice, NumberOfProducts) VALUES ('$sellerId','$customerId','$pprice','1')");
            $oid=mysqli_insert_id($con);
            $dbIproduct = mysqli_query($con, "INSERT INTO order_products (oID, pID, quantity, totalPrice) VALUES ('$oid','$pid','$pqty','$pprice')");
        }     
    }
} 


elseif ($action == "remove") {
    /*$dbS = mysqli_query($con, "SELECT * FROM `order` WHERE sellerID='$sellerId' AND customerID='$customerId'");
    $orderData = mysqli_fetch_assoc($dbS);
    $orderId = $orderData['oID'];
    $numberOfProducts = $orderData['NumberOfProducts'];
    $orderPrice = $orderData['orderPrice'];

    if ($numberOfProducts == 1) {
        $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$orderId' AND pID='$pid'");
        $deleteOrder = mysqli_query($con, "DELETE FROM `order` WHERE oID='$orderId'");
    } else {
        $selectProduct = mysqli_query($con, "SELECT * FROM order_products WHERE oID='$orderId' AND pID='$pid'");
        $productData = mysqli_fetch_assoc($selectProduct);
        $productTotalPrice = $productData['totalPrice'];
        $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$orderId' AND pID='$pid'");
        $updateOrder = mysqli_query($con, "UPDATE `order` SET orderPrice = orderPrice - '$productTotalPrice', NumberOfProducts = NumberOfProducts - 1 WHERE sellerID='$sellerId' AND customerID='$customerId'");
    }*/
    $dbS = mysqli_query($con, "SELECT * FROM `order` WHERE sellerID='$sellerId' AND customerID='$customerId'");
    $found=false;
    while($result=mysqli_fetch_array($dbS)){ //check each order
        $oid=$result['oID'];
        $dbPlaced=mysqli_query($con,"SELECT * from placed_order WHERE oID='$oid'");
            if(mysqli_num_rows($dbPlaced)==0){ //if the order is not placed
                $numberOfProducts = $result['NumberOfProducts'];
                if ($numberOfProducts == 1) {
                    $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$oid' AND pID='$pid'");
                    $deleteOrder = mysqli_query($con, "DELETE FROM `order` WHERE oID='$oid'");
                } else {
                    $selectProduct = mysqli_query($con, "SELECT * FROM order_products WHERE oID='$oid' AND pID='$pid'");
                    $productData = mysqli_fetch_assoc($selectProduct);
                    $productTotalPrice = $productData['totalPrice'];
                    $deleteProduct = mysqli_query($con, "DELETE FROM order_products WHERE oID='$oid' AND pID='$pid'");
                    $updateOrder = mysqli_query($con, "UPDATE `order` SET orderPrice = orderPrice - '$productTotalPrice', NumberOfProducts = NumberOfProducts - 1 WHERE sellerID='$sellerId' AND customerID='$customerId'");
                }
                $found=true;
                break;
            }
    }
    if($found==false){
        echo "Cancel First";
    }
}
?>
