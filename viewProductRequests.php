<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products Requests</title>
    <link rel="stylesheet" href="viewProductRequests.css">
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
                <li><a href="factoryhome.php">Home</a></li>
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
        <li><a href="factoryhome.php">Home</a></li>
        <li><a href="factoryprofile.php">Profile</a></li>
        <li><a href="addproduct.php">Add Post</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
        </div>
    </div>
    <?php
        $getFactory=mysqli_query($con,"SELECT * from factory where UID='$userid'");
        $factory=mysqli_fetch_array($getFactory);
        $factoryID=$factory['FID'];
        $getrequests=mysqli_query($con,"SELECT * from product_requests where fID='$factoryID'");
        echo "<div class='title'><h2>Product Requests</h2></div>";
        while($col=mysqli_fetch_array($getrequests)){
            echo "<div class='product-request-container'>";
            $requesterID=$col['requesterID'];
            $getRequester=mysqli_query($con,"SELECT * from user where ID='$requesterID'");
            $requester=mysqli_fetch_array($getRequester);
            $requesterUsername=$requester['Username'];
            echo "<div class='request-info'>";
            echo "<div class='requester'>Request from: @".$requesterUsername."</div><div class='date'>Date: ".$col['RequestDate']."</div><br>";
            echo "</div>";
            echo "<div class='product-details'>";
            echo "<b>Product Name: </b>".$col['Name']."<br>";
            echo "<b>Description: </b>".$col['Description']."<br>";
            echo "<b>Size: </b>".$col['Size']."&nbsp;&nbsp;&nbsp;<b>Color: </b>".$col['Color']."&nbsp;&nbsp;&nbsp;<b>Quality: </b>".$col['Quality']."<br>";
            echo "<b>Quantity: </b>".$col['Quantity']."&nbsp;&nbsp;&nbsp;<b>Price Range: </b>".$col['MinPrice']."$ to ".$col['MaxPrice']."$<br>";
            echo "</div>";
            echo '<div class="btns">';
            echo "<a href='mailto:".$requester['Email']."'><button class='contact-btn'>Contact</button></a>";
            echo "<button onclick='declineRequest(".$col['pRequestID'].")' class='decline-btn'>Decline</button>";
            echo "</div>";
            echo "</div>";
        }
    ?>
</body>
</html>
<script>
    const toggleBtn = document.querySelector('.toggle_btn')
    const toggleBtnIcon = document.querySelector('.toggle_btn i')
    const dropDownMenu = document.querySelector('.dropdown_menu')

    toggleBtn.onclick = function (){
    dropDownMenu.classList.toggle('open')
    const isOpen = dropDownMenu.classList.contains('open')
    toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
    }

    function declineRequest(reqID){
        var url = "declineRequest.php?reqID=" + reqID;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
        window.location.reload();
    }
</script>