<?php
session_start();
include 'config.php';
extract($_POST);

$userid=$_SESSION['id'];

if (isset($_POST["submit"])) {
    $target_dir = "productsIMG/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $uploadOK = 1;

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check !== false) {
            
            $uploadOK = 1;
        } else {
            echo "<div class='message'>File is not an image.</div><br>";
            $uploadOK = 0;
        }
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif") {
        echo "<div class='message'>Sorry, only JPG, PNG, and GIF files are allowed.</div><br>";
        $uploadOK = 0;
    }

    if ($uploadOK == 0) {
        echo "<div class='message2'>Your file was not uploaded.</div>";
        echo "<button class='ok' onclick='tryAgain()'>OK</button>";
    } else {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                if ($_POST['category'] == '') {
                    if(isset($_POST['stock'])){
                        $q = mysqli_query($con, "INSERT INTO product(Name,Description,Price,MinQuantity,MaxQuantity,Img,Available,U_ID) VALUES ('$pname', '$desc', '$pprice', '$min', '$max', '$target_file','0','$userid')");
                        $inserted_id = mysqli_insert_id($con);
                        $rate=mysqli_query($con,"INSERT into rates(pID,NumberofStars) VALUES('$inserted_id','0')");
                    } else {
                        $q = mysqli_query($con, "INSERT INTO product(Name,Description,Price,MinQuantity,MaxQuantity,Img,Available,U_ID) VALUES ('$pname', '$desc', '$pprice', '$min', '$max', '$target_file','1','$userid')");
                        $inserted_id = mysqli_insert_id($con);
                        $rate=mysqli_query($con,"INSERT into rates(pID,NumberofStars) VALUES('$inserted_id','0')");
                    }
                }
                else{
                    if(isset($_POST['stock'])){
                        $q = mysqli_query($con, "INSERT INTO product(Name,Description,Price,MinQuantity,MaxQuantity,Category,Img,Available,U_ID) VALUES ('$pname', '$desc', '$pprice', '$min', '$max','$category','$target_file','0','$userid')");
                        $inserted_id = mysqli_insert_id($con);
                        $c = mysqli_query($con, "UPDATE category SET NbOfProducts=NbOfProducts + 1 where categoryID='$category'");
                        $cp=mysqli_query($con,"INSERT into category_products(catID,pID) VALUES('$category','$inserted_id')");
                        $rate=mysqli_query($con,"INSERT into rates(pID,NumberofStars) VALUES('$inserted_id','0')");
                    } else {
                        $q = mysqli_query($con, "INSERT INTO product(Name,Description,Price,MinQuantity,MaxQuantity,Category,Img,Available,U_ID) VALUES ('$pname', '$desc', '$pprice', '$min', '$max','$category','$target_file','1','$userid')");
                        $inserted_id = mysqli_insert_id($con);
                        $c = mysqli_query($con, "UPDATE category SET NbOfProducts=NbOfProducts + 1 where categoryID='$category'");
                        $cp=mysqli_query($con,"INSERT into category_products(catID,pID) VALUES('$category','$inserted_id')");
                        $rate=mysqli_query($con,"INSERT into rates(pID,NumberofStars) VALUES('$inserted_id','0')");
                    }
                }
        }
        if(isset($_SESSION['role'])){
            $role=$_SESSION['role'];
            if($role=="Factory"){
                header("Location:factoryhome.php");
            }
            else if($role=="Supplier"){
                header("Location:supplierhome.php");
            }
        }
    }
}

?>