<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "linkedmarket";

$con = mysqli_connect($db_host, $db_user, $db_password, $db_name)
or die("Connection failed: " . mysqli_connect_error());

?>
