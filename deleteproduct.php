<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    // Validate session ID to prevent session fixation attacks
    $userid = intval($_SESSION['id']); // Cast session ID to integer for security
}

$pid = isset($_GET['pid']) ? intval($_GET['pid']) : null; // Validate and sanitize product ID

if($userid && $pid) {
    // Use prepared statements to prevent SQL injection
    $stmt_orders = mysqli_prepare($con, "SELECT oID, totalPrice FROM order_products WHERE pID=?");
    mysqli_stmt_bind_param($stmt_orders, "i", $pid);
    mysqli_stmt_execute($stmt_orders);
    $result_orders = mysqli_stmt_get_result($stmt_orders);

    if(mysqli_num_rows($result_orders) != 0){
        while($order = mysqli_fetch_assoc($result_orders)){
            $oid = $order['oID'];
            $pprice = $order['totalPrice'];

            // Use prepared statements to prevent SQL injection
            $stmt_order = mysqli_prepare($con, "SELECT sellerID, orderPrice, NumberOfProducts FROM `order` WHERE oID=?");
            mysqli_stmt_bind_param($stmt_order, "i", $oid);
            mysqli_stmt_execute($stmt_order);
            $result_order = mysqli_stmt_get_result($stmt_order);
            $orderinfo = mysqli_fetch_assoc($result_order);

            $sellerId = $orderinfo['sellerID'];
            $orderPrice = $orderinfo['orderPrice'];
            $nbProducts = $orderinfo['NumberOfProducts'];

            if ($nbProducts == 1) {
                $stmt_deleteProduct = mysqli_prepare($con, "DELETE FROM order_products WHERE oID=? AND pID=?");
                mysqli_stmt_bind_param($stmt_deleteProduct, "ii", $oid, $pid);
                mysqli_stmt_execute($stmt_deleteProduct);

                $stmt_deleteOrder = mysqli_prepare($con, "DELETE FROM `order` WHERE oID=?");
                mysqli_stmt_bind_param($stmt_deleteOrder, "i", $oid);
                mysqli_stmt_execute($stmt_deleteOrder);
            } else {
                $stmt_deleteProduct = mysqli_prepare($con, "DELETE FROM order_products WHERE oID=? AND pID=?");
                mysqli_stmt_bind_param($stmt_deleteProduct, "ii", $oid, $pid);
                mysqli_stmt_execute($stmt_deleteProduct);

                $stmt_updateOrder = mysqli_prepare($con, "UPDATE `order` SET orderPrice = orderPrice - ?, NumberOfProducts = NumberOfProducts - 1 WHERE sellerID=? AND customerID=?");
                mysqli_stmt_bind_param($stmt_updateOrder, "disi", $pprice, $sellerId, $userid);
                mysqli_stmt_execute($stmt_updateOrder);
            }
        }
    }

    // Use prepared statements to prevent SQL injection
    $stmt_deleteWishlist = mysqli_prepare($con, "DELETE FROM wishlist_products WHERE pID=?");
    mysqli_stmt_bind_param($stmt_deleteWishlist, "i", $pid);
    mysqli_stmt_execute($stmt_deleteWishlist);

    $stmt_deleteRating = mysqli_prepare($con, "DELETE FROM user_rating WHERE pID=?");
    mysqli_stmt_bind_param($stmt_deleteRating, "i", $pid);
    mysqli_stmt_execute($stmt_deleteRating);

    $stmt_deleteRates = mysqli_prepare($con, "DELETE FROM rates WHERE pID=?");
    mysqli_stmt_bind_param($stmt_deleteRates, "i", $pid);
    mysqli_stmt_execute($stmt_deleteRates);

    $stmt_deleteFeedbacks = mysqli_prepare($con, "DELETE FROM feedback WHERE pID=?");
    mysqli_stmt_bind_param($stmt_deleteFeedbacks, "i", $pid);
    mysqli_stmt_execute($stmt_deleteFeedbacks);

    $stmt_deleteCategory = mysqli_prepare($con, "DELETE FROM category_products WHERE pID=?");
    mysqli_stmt_bind_param($stmt_deleteCategory, "i", $pid);
    mysqli_stmt_execute($stmt_deleteCategory);

    $stmt_deleteProduct = mysqli_prepare($con, "DELETE FROM product WHERE pID=?");
    mysqli_stmt_bind_param($stmt_deleteProduct, "i", $pid);
    mysqli_stmt_execute($stmt_deleteProduct);
}
?>
