<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$oid=$_GET['oid'];
$dborder=mysqli_query($con,"SELECT * from placed_order where oID='$oid'");
$placedorder=mysqli_fetch_array($dborder);
$customerId=$placedorder['customerID'];

$dbUser=mysqli_query($con,"SELECT * from user where ID='$customerId'");
$customerinfo=mysqli_fetch_array($dbUser);
$dborderProducts=mysqli_query($con,"SELECT * from order_products where oID='$oid'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="vieworder.css">
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
        <h2>Customer:</h2>
        <div class="customer">
            <div class="details">
                <div id="name">Name: <?php echo $customerinfo['FirstName']." ".$customerinfo['LastName'];?></div>
                <div id="username">Username: @<?php echo $customerinfo['Username'];?></div>
                <div id="location">Location: <?php echo $customerinfo['Country'];?></div>
                <div id="date">Order Date: <?php echo $placedorder['Date'];?></div>
            </div>
            <div class="customercontact">
                <div id="customerimage"><?php
                    if($customerinfo['Image']!=NULL){
                        echo "<img src='".$customerinfo['Image']."'>";
                        }
                        else{
                            echo '<i class="fa-regular fa-circle-user" style=\'font-size:90px;\'></i>';
                        }
                ?></div>
                <div id="contactbtn"><a href='mailto:<?php echo $customerinfo['Email'];?>'><button>Contact</button></a></div>
            </div>
        </div>
        <h2>Products:</h2>
        <div class="orderproducts">
            <?php while($Opr=mysqli_fetch_array($dborderProducts)){
                $productId=$Opr['pID'];
                $getinfo=mysqli_query($con,"SELECT * from product where pID='$productId'");
                $productinfo=mysqli_fetch_array($getinfo);
                $productName=$productinfo['Name'];
                $productQty=$Opr['quantity'];
                $price=$Opr['totalPrice'];
                ?>
                <div class="product">
                    <div class="pname">Name: <?php echo $productName;?></div>
                    <div class="pqty">Quantity: <?php echo $productQty;?></div>
                    <div class="pprice">Price: <?php echo $price;?>$</div>
                </div>
            <?php }?>
        </div>
        <div class="send">
            <div class="orderprice">Total: <?php echo $placedorder['orderPrice'];?>$</div>
            <div class="orderBtn">
                <button id="sentBtn" onclick="setSent()" <?php if($placedorder['status']=='sent') echo "disabled";?>>Order Sent</button>
            </div>
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

    function setSent(){
        var orderId=<?php echo $oid; ?>;
        var url = "orderstatus.php?oid="+orderId+"&status=sent";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
        window.location.reload();
    }
</script> 
</body>
</html>