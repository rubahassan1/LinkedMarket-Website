<?php
include "config.php";

$uname=$_GET['uname'];
$selectUser=mysqli_query($con,"SELECT * from user where Username='$uname'");
if(mysqli_num_rows($selectUser)==0){
    echo "Error";
}
else{
    echo "Verified";
}
?>