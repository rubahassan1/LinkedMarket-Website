<?php
session_start();
include "config.php";

$userid = null;
if(isset($_SESSION['id']) && is_numeric($_SESSION['id'])){
    // Validate user ID
    $userid = $_SESSION['id'];
}

$productid = null;
$action = null;

if(isset($_GET['pid']) && is_numeric($_GET['pid']) && isset($_GET['action'])) {
    $productid = $_GET['pid']; // Sanitize product ID
    $action = $_GET['action']; // Sanitize action

    if($userid && $productid && $action) {
        // Use prepared statements to prevent SQL injection
        $stmt_wishlist = mysqli_prepare($con, "SELECT wID FROM wishlist WHERE uID=?");
        mysqli_stmt_bind_param($stmt_wishlist, "i", $userid);
        mysqli_stmt_execute($stmt_wishlist);
        $result_wishlist = mysqli_stmt_get_result($stmt_wishlist);
        $wishlistID = mysqli_fetch_assoc($result_wishlist)['wID'];

        if($wishlistID) {
            if($action == "add"){
                // Use prepared statement to prevent SQL injection
                $stmt_add = mysqli_prepare($con, "INSERT INTO wishlist_products(wID, pID) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt_add, "ii", $wishlistID, $productid);
                mysqli_stmt_execute($stmt_add);
            } elseif($action == "remove"){
                // Use prepared statement to prevent SQL injection
                $stmt_remove = mysqli_prepare($con, "DELETE FROM wishlist_products WHERE wID=? AND pID=?");
                mysqli_stmt_bind_param($stmt_remove, "ii", $wishlistID, $productid);
                mysqli_stmt_execute($stmt_remove);
            }
        }
    }
}
?>

