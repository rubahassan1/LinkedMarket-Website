<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid = mysqli_real_escape_string($con, $_SESSION['id']); // Escape session ID
}

$action = mysqli_real_escape_string($con, $_GET['action']); // Escape action parameter
$connID = mysqli_real_escape_string($con, $_GET['connID']); // Escape connID parameter

if($action == "accept"){
    // Use prepared statement to insert data securely
    $stmt = mysqli_prepare($con, "INSERT INTO connection (uID, connectionID) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ii", $userid, $connID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Use prepared statement to delete data securely
$stmt = mysqli_prepare($con, "DELETE FROM connectionrequests WHERE (uID = ? AND connectionID = ?) OR (uID = ? AND connectionID = ?)");
mysqli_stmt_bind_param($stmt, "iiii", $userid, $connID, $connID, $userid);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

echo "done";
?>
