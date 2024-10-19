<?php
session_start();
include 'config.php';
$query = $_REQUEST["q"];
$userid=$_SESSION["id"];
//Maximum 5 rows
$sql = "SELECT * FROM user WHERE (Username LIKE '%$query%' OR FirstName LIKE '%$query%' OR LastName LIKE '%$query%') AND Role != 'admin' AND id != $userid LIMIT 5";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$suggestions = [];
while ($row = mysqli_fetch_array($result)) {
    $suggestions[] = $row; 
}
if(mysqli_num_rows($result)!=0){
echo "<ul style=\"list-style-type: none;\">";
foreach ($suggestions as $suggestion) {
    echo "<li style=\"list-style-type: none;\"><a style=\"text-decoration: none; \" href=\"";
    if($suggestion['Role']=="Factory"){
        echo "viewfactory.php";
    }
    else if($suggestion['Role']=="Supplier"){
        echo "viewsupplier.php";
    }
    else if($suggestion['Role']=="Buyer"){
        echo "viewbuyer.php";
    }
    echo "?viewid=" .$suggestion['ID']. "\">" . $suggestion['Username'] . "</a></li>";
    }
echo "</ul>";
}
?>