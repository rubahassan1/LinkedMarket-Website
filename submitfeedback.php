<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$dbUser=mysqli_query($con,"SELECT * from user where ID='$userid'");
$uname=mysqli_fetch_array($dbUser)['Username'];

$productid=$_GET['productid'];
$feedback=$_GET['feedback'];
$dbI = mysqli_query($con,"INSERT into Feedback(pID,uID,content,Date) VALUES ('$productid','$userid','$feedback',NOW())");
echo "<div id='feedbackUname'><b>@".$uname."</b></div>";
echo '<div id="feedbackDate">' . date('Y-m-d') . '</div>';
echo '<div id="feedbackContent">'.$feedback.'</div>';
?>