<?php
session_start();
include "config.php";

// Initialize variables
$userid;
$role;
$catalogID;

// Check if user is logged in
if (isset($_SESSION['id'], $_SESSION['role'])) {
    $userid = $_SESSION['id'];
    $role = $_SESSION['role'];
}

// Retrieve catalog ID for suppliers
if ($role === "Supplier") {
    $dbCatalog = mysqli_query($con, "SELECT cID FROM catalog WHERE uID='$userid'");
    $catalogData = mysqli_fetch_assoc($dbCatalog);
    if ($catalogData) {
        $catalogID = $catalogData['cID'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="addproduct.css">
    <title>Add Post</title>
</head>
<body>
<div id="nav">
        <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <?php if(isset($_SESSION['role'])){ if ($_SESSION['role']=="Factory"){?>
                <ul class="links">
                    <li><a href="factoryhome.php">Home</a></li>
                    <li class="active"><a href="addproduct.php">Add Post</a></li>
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
                    ?>
                </a>
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
                    ?>
                </a>
            <?php }else if($_SESSION['role']=="Supplier"){?>
                <ul class="links">
                <li><a href="supplierhome.php">Home</a></li>
                <li class="active"><a href="addproduct.php">Add Post</a></li>
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
            <?php }}?>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>

<div class="dropdown_menu">
    <?php if(isset($_SESSION['role'])){ if ($_SESSION['role']=="Factory"){?>
                <div class="links">
                    <li><a href="factoryhome.php">Home</a></li>
                    <li><a href="factoryprofile.php">Profile</a></li>
                    <li><a href="addproduct.php">Add Post</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </div>
            <?php }else if($_SESSION['role']=="Supplier"){?>
                <div class="links">
                <li><a href="supplierhome.php">Home</a></li>
                <li><a href="factoryprofile.php">Profile</a></li>
                <li><a href="addproduct.php">Add Post</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
                </div>
            <?php }}?>
    </div>
<div class="content">
<div class="addpost">
    <h1>Add Product</h1><br>
    <form action="submitpost.php" method="post" enctype="multipart/form-data">
        <div class="top">
        <div class="first-side">
                <div id="name">Name: <input type="text" name="pname" id="" required></div>
                <div id="price">Price: <input type="text" name="pprice" id="" required></div>
                <div id="qty"><div id="title">Quantity Limit </div><input type="number" name="min" id="min" required>
                To <input type="number" name="max" id="max" required></div>
                <div id="Category"><?php if ($role === "Supplier") { ?>
                Category <select name="category" id="">
                    <option value="">Select Category</option>
                    <?php
                    if ($catalogID) {
                        $dbCat = mysqli_query($con, "SELECT categoryID, Name FROM category WHERE catalogID='$catalogID'");
                        while ($category = mysqli_fetch_assoc($dbCat)) {
                            echo "<option value='".$category['categoryID']."'>".$category['Name']."</option>";
                        }
                    }
                    ?>
                </select>
                <?php } ?></div>
                <div id="stock"><input type="checkbox" name="stock" id=""> Out of Stock</div>
                </div> <!-- end of first side -->
                <div class="second-side">
                    <div id="desc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="desc">Description:</label>
                    <textarea name="desc" id="" rows="8" cols="50" required></textarea></div>
                    <div id="image">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upload an image: <input type="file" name="img" id="productImage" required></div>
                </div><!-- end of second side -->
            </div><!-- end of top-->
                <div class="btns">
                    <button type="submit" name="submit">Post</button>
                    <div id="discard" onclick="discard()">Discard</div>
                </div>
    </form>
</div>
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

    function discard(){
        window.location.href='factoryhome.php';
    }
</script>
</body>
</html>
