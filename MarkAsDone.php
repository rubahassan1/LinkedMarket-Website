<?php
include 'config.php';
$id=$_REQUEST['val'];
$dbD = mysqli_query($con, "DELETE FROM Tasks WHERE tID='$id'")
or die("Couldn't remove task<br>");
?>