<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

extract($_POST);
if(isset($submit)){
    $selectUser=mysqli_query($con,"SELECT ID from user where Username='$FUname'");
    if(mysqli_num_rows($selectUser)!=0){
        $uID=mysqli_fetch_array($selectUser)['ID'];
        $selectfactory=mysqli_query($con,"SELECT FID from factory where UID='$uID'");
        if(mysqli_num_rows($selectfactory)!=0){
            $FID=mysqli_fetch_array($selectfactory)['FID'];
            $dbI=mysqli_query($con,"INSERT into product_requests(requesterID,Name,Description,Size,Color,Quality,Quantity,MinPrice,MaxPrice,RequestDate,fID) VALUES ('$userid','$name','$desc','$size','$color','$quality','$quantity','$minPrice','$maxPrice',NOW(),'$FID')");
            header('Location: buyerhome.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request a Product</title>
    <link rel="stylesheet" href="requestProduct.css">
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
            <li><a href="buyerhome.php">Home</a></li>
            <li class="active"><a href="requestProduct.php">Request a Product</a></li>
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
        <a href="buyerprofile.php" class="profile">
            <?php if ($userid) {
                $dbs = mysqli_query($con, "SELECT Image FROM user WHERE ID='$userid'");
                $img = mysqli_fetch_assoc($dbs)['Image'];
                echo $img ? '<img src="'.$img.'" alt="">' : '<i class="fa-regular fa-circle-user"></i>';
            } ?>
        </a>
        <div class="toggle_btn">
            <i class="fa-solid fa-bars"></i>
        </div>
    </div>
</div>

<div class="dropdown_menu">
        <div class="links">
            <li><a href="buyerhome.php">Home</a></li>
            <li><a href="buyerprofile.php">Profile</a></li>
            <li class="active"><a href="requestProduct.php">Request a Product</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
            <li><a href="logout.php">Logout</a></li>
        </div>
</div>
<div class="request-product">
    <form action="requestProduct.php" method="post" onsubmit="return verifyFactory()" id="requestForm">
        <h1>Request Product</h1>
        <div id="uname">Factory Username: <input type="text" name="FUname" id="username" required></div>
        <div class="top">
        <div class="left-side">
            <div id="pname">Product Name: <input type="text" name="name" id="" required></div>
            <div id="desc">Description:&nbsp;&nbsp;<textarea name="desc" id="" cols="30" rows="10" required></textarea></div>
        </div><br>
        <div class="right-side">
            <div id="size">Size: <input type="text" name="size" id="" required></div>
            <div id="color">Color: <input type="text" name="color" id="" required></div>
            <div id="quality"><div>Quality: </div><div><input type="radio" name="quality" id="" value="1st" checked>1st</div>
            <div><input type="radio" name="quality" value="2nd" id="">2nd</div>
            <div><input type="radio" name="quality" value="3rd" id="">3rd</div></div>
        </div></div>
        <div class="price-quantity">
            <div id="quantity">Quantity: <input type="number" name="quantity" id="" required></div>
            <div id="pprice"><div>Unit Price Range($):&nbsp;&nbsp;</div><div style="display:flex; flex-direction:row; align-items:center;">From:&nbsp;&nbsp;<input type="text" name="minPrice" id="" required>&nbsp;&nbsp;To:&nbsp;&nbsp;<input type="text" name="maxPrice" id="" required></div></div>
        </div>
        <div class="submit">
            <button type="submit" name="submit">Submit Request</button>
        </div>
    </form>
    <div class="discard">
    <a href="buyerhome.php"><button>Discard</button></a>
    </div>
    </div>
    <div id="res"></div>
</body>
<script>
    const toggleBtn = document.querySelector('.toggle_btn')
    const toggleBtnIcon = document.querySelector('.toggle_btn i')
    const dropDownMenu = document.querySelector('.dropdown_menu')

    toggleBtn.onclick = function (){
        dropDownMenu.classList.toggle('open')
        const isOpen = dropDownMenu.classList.contains('open')
        toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
    }

    function verifyFactory(){
        var Uname=document.getElementById('username').value;
        var xmlhttp = new XMLHttpRequest();
        var result;
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                result = xmlhttp.responseText;
                if (result == 'Error') {
                    alert("Factory is not Found");
                    return false;
                } else {
                    alert("Request Sent Successfully");
                    return true; // Submit the form if factory is found
                }
            }
        };
        xmlhttp.open("GET", "verifyfactoryRequest.php?uname=" + Uname, true);
        xmlhttp.send();
    }
</script>
</html>