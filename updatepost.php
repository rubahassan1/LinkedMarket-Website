<?php
session_start();
include 'config.php';
extract($_POST);

$oldcategory=$_POST['oldCat'];

$userid=$_SESSION['id'];
$pid = $_POST['pid'];
if (isset($_POST["submit"])) {
    $target_file;
    if ($_FILES["img"]["name"]!="") {
        $target_dir = "productsIMG/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $uploadOK = 1;

        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check === false) {
            echo "<div class='message'>File is not an image.</div><br>";
            $uploadOK = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif") {
            echo "<div class='message'>Sorry, only JPG, PNG, and GIF files are allowed.</div><br>";
            $uploadOK = 0;
        }

        if ($uploadOK == 0) {
            echo "<div class='message2'>Your file was not uploaded.</div>";
            echo "<button class='ok' onclick='tryAgain()'>OK</button>";
        } else {
            if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                echo "<div class='message2'>Sorry, there was an error uploading your file.</div>";
                echo "<button class='ok' onclick='tryAgain()'>OK</button>";
                exit(); // Exit if image upload fails
            }
        }
        if ($_POST['newcategory'] == '') {
            $updateQuery = "UPDATE product SET Name='$pname', Description='$desc', Price='$pprice', MinQuantity='$min', MaxQuantity='$max', Category=NULL, Img='$target_file', Available='".(isset($_POST['stock']) ? '0' : '1')."', U_ID='$userid' WHERE pID='$pid'";
            if($oldcategory!=''){
                $updateOldCat=mysqli_query($con,"UPDATE category SET NbOfProducts=NbOfProducts - 1 where categoryID='$oldcategory'");
                $dbD=mysqli_query($con,"Delete from category_products where catID='$oldcategory' AND pID='$pid'");
            }
        } else {
            $updateQuery = "UPDATE product SET Name='$pname', Description='$desc', Price='$pprice', MinQuantity='$min', MaxQuantity='$max', Category='$newcategory', Img='$target_file', Available='".(isset($_POST['stock']) ? '0' : '1')."', U_ID='$userid' WHERE pID='$pid'";
            if($oldcategory!=''){
                $updateOldCat=mysqli_query($con,"UPDATE category SET NbOfProducts=NbOfProducts - 1 where categoryID='$oldcategory'");
                $dbD=mysqli_query($con,"Delete from category_products where catID='$oldcategory' AND pID='$pid'");
            }
            $updateNewCat=mysqli_query($con,"UPDATE category SET NbOfProducts=NbOfProducts + 1 where categoryID='$newcategory'");
            $dbinsert=mysqli_query($con,"INSERT into category_products(catID,pID) VALUES ('$newcategory','$pid')");
        }
    }
    else{
        if ($_POST['newcategory'] == '') {
            $updateQuery = "UPDATE product SET Name='$pname', Description='$desc', Price='$pprice', MinQuantity='$min', MaxQuantity='$max', Category=NULL, Available='".(isset($_POST['stock']) ? '0' : '1')."', U_ID='$userid' WHERE pID='$pid'";
            if($oldcategory!=''){
                $updateOldCat=mysqli_query($con,"UPDATE category SET NbOfProducts=NbOfProducts - 1 where categoryID='$oldcategory'");
                $dbD=mysqli_query($con,"Delete from category_products where catID='$oldcategory' AND pID='$pid'");
            }
        } else {
            $updateQuery = "UPDATE product SET Name='$pname', Description='$desc', Price='$pprice', MinQuantity='$min', MaxQuantity='$max', Category='$newcategory', Available='".(isset($_POST['stock']) ? '0' : '1')."', U_ID='$userid' WHERE pID='$pid'";
            if($oldcategory!=''){
                $updateOldCat=mysqli_query($con,"UPDATE category SET NbOfProducts=NbOfProducts - 1 where categoryID='$oldcategory'");
                $dbD=mysqli_query($con,"Delete from category_products where catID='$oldcategory' AND pID='$pid'");
            }
            $updateNewCat=mysqli_query($con,"UPDATE category SET NbOfProducts=NbOfProducts + 1 where categoryID='$newcategory'");
            $dbinsert=mysqli_query($con,"INSERT into category_products(catID,pID) VALUES ('$newcategory','$pid')");
        }
    }

    if (mysqli_query($con, $updateQuery)) {
        if(isset($_SESSION['role'])){
            $role=$_SESSION['role'];
            if($role=="Factory"){
                header("Location:factoryhome.php");
            }
            else if($role=="Supplier"){
                header("Location:supplierhome.php");
            }
        }
    } else {
        echo "<div class='message2'>Error updating record: " . mysqli_error($con) . "</div>";
        echo "<button class='ok' onclick='tryAgain()'>OK</button>";
    }
}
?>
