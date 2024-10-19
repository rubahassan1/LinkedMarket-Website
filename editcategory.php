<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$catID=$_GET['catID'];
$dbS=mysqli_query($con,"SELECT * from category_products where catID='$catID'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editcategory.css">
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div id="nav">
        <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <ul class="links">
                <li><a href="supplierhome.php">Home</a></li>
                <li><a href="addproduct.php">Add Post</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <a href="notifications.php" class="notification"><?php
            $readNot=mysqli_query($con, "SELECT * from notification where `Read`='0' AND ReceiverID='$userid'");
            $readReq=mysqli_query($con, "SELECT * from connectionrequests where `read`='0' AND connectionID='$userid'");
            if(mysqli_num_rows($readNot)==0 && mysqli_num_rows($readReq)==0){
                echo "<i class='fa-regular fa-bell'></i>";
            }
            else{
                echo "<i class='fa-regular fa-bell fa-bounce'></i>";
            }
            ?></a>
            <a href="factoryprofile.php" class="profile"><?php 
                if(isset($_SESSION['id'])){
                    $dbs=mysqli_query($con,"SELECT Image from user where ID='$userid'");
                    $img=mysqli_fetch_assoc($dbs)['Image'];
                    if($img==NULL){
                        echo '<i class="fa-regular fa-circle-user"></i>';
                    }
                    else{
                        echo '<img src="'.$img.'" alt="">';
                    }
                }
            ?></a>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    <div class="dropdown_menu">
        <div class="links">
        <li><a href="supplierhome.php">Home</a></li>
        <li><a href="factoryprofile.php">Profile</a></li>
        <li><a href="addproduct.php">Add Post</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
        </div>
    </div>
    <h1 class='catName'>Category: <?php $dbName=mysqli_query($con,"SELECT Name from category where categoryID='$catID'");
        $name=mysqli_fetch_array($dbName)['Name'];
        echo $name;?></h1>
    <div class='products'>
        <?php
        while($col=mysqli_fetch_array($dbS)){
            echo '<a href=editproduct.php?pid='.$col['pID'].' style="text-decoration:none;">';
            $dbP=mysqli_query($con,"SELECT * from product where pID='".$col['pID']."'");
            $product=mysqli_fetch_array($dbP);
            
            echo '<div class="product-card">';
            echo '<div class="content">';
            echo '<img class="product-image" src="' . $product['Img'] . '">';
            echo '<div class="product-name" id= "prName" name="'.$product['pID'].'">' . $product['Name'] . '</div>';
            echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>";
            $rate=mysqli_query($con,"SELECT * from rates where pID='".$product['pID']."'");
            $rating=mysqli_fetch_assoc($rate);
            $start=1;
            echo '<div class="rate-price">';
            while($start<=5){
                if($rating<$start){
                    ?>
                    <i class="fa-regular fa-star" style="color:#FFD700;"></i>
                    <?php
                }
                else{
                    ?>
                    <i class="fa-solid fa-star" style="color:#FFD700;"></i>
                    <?php
                }
                $start++;
            }
            echo '<div class="product-price">';
            echo $product['Price']."$";
            echo '</div>';
            echo '</div>';
            echo "<div class='product-stock' style='text-align:center;";
                    if($product['Available']==1){
                        echo " color:green;'>In Stock";
                    }
                    else {
                        echo " color:red;'>Out of Stock";
                    }
                    echo "</div>";
            echo '</div>';
            echo "</a>";
            echo '<div class="rmvproduct">';
            echo "<button id='".$product['pID']."' onclick='removefromCat(this,".$catID.")' class='rmvbtn'>Remove</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <div id="deleteCat" style="clear:both;"><button onclick='deleteCategory(<?php echo $catID;?>)'>Delete Category</button></div>
    <div id="errors">

    </div>
    <script>
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')
            toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }

    function removefromCat(product,catID){
            var productid=product.id;
            var url = "removeCat.php?pid=" + productid+"&catID="+catID;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            window.location.reload();
    }

    function deleteCategory(catID){
        if(confirm("Are you sure you want to delete this category?")){
        var url = "deleteCat.php?catID="+catID;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("errors").innerHTML = xmlhttp.responseText;
                    }
                };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
        }
        window.location.href="supplierhome.php";
        window.location.href="supplierhome.php";
    }

    </script>
</body>
</html>