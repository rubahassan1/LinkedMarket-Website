<?php
session_start();
include "config.php";

$userid = "";
if(isset($_SESSION['id']) && $_SESSION['id'] !== ''){
    $userid = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cart.css">
    <title>Cart</title>
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
            <?php }else if($_SESSION['role']=="Buyer"){?>
                <ul class="links">
                <li><a href="buyerhome.php">Home</a></li>
                <li><a href="requestProduct.php">Request a Product</a></li>
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
            <a href="buyerprofile.php" class="profile"><?php 
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
            <?php }else if($_SESSION['role']=="Buyer"){?>
                <div class="links">
                <li><a href="buyerhome.php">Home</a></li>
                <li><a href="buyerprofile.php">Profile</a></li>
                <li><a href="requestProduct.php">Request a Product</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </div>
            <?php }}?>
    </div>
    <div class='title'><b>Cart</b></div>
    <?php
        $selectorder = mysqli_query($con,"SELECT * from `order` where customerID='$userid'");
        while($order = mysqli_fetch_array($selectorder)){
            echo "<div class='order' id=".$order['oID'].">";
            $sellerId = $order["sellerID"];
            $selectseller = mysqli_query($con,"SELECT * from user where ID='$sellerId'");
            $sellerinfo = mysqli_fetch_array($selectseller);
            $sellerName = $sellerinfo['Username'];
            $sellerRole = $sellerinfo['Role'];
            echo "<h2>".$sellerRole.": @".$sellerName."</h2>";
            $orderId = $order["oID"];
            $selectProducts = mysqli_query($con,"SELECT * from order_products where oID='$orderId'");
            while($product = mysqli_fetch_array($selectProducts)){
                echo "<div class=product>";
                $productId = $product['pID'];
                $getinfo = mysqli_query($con,"SELECT * from product where pID='$productId'");
                $productinfo = mysqli_fetch_array($getinfo);
                $productName = $productinfo['Name'];
                echo "<div id='pname'>Name: ".$productName."</div>";
                $productQty = $product['quantity'];
                echo "<div id='pqty'>Quantity: ".$productQty."</div>";
                $price = $product['totalPrice'];
                echo "<div id='pprice'>Price: ".$price."$</div>";
                echo "<div id='view'><a href='viewproduct.php?pid=".$productId."'>View Product</a></div>";
                echo "<div id='remove'><a href='' id='".$productId."' onclick='RemoveFromCart(this,".$orderId.")'>Remove</a></div>";
                echo "</div><br>";
            }
            $orderPrice = $order['orderPrice'];
            $formattedPrice = number_format($orderPrice, 2); // Format the price with 2 decimal digits
            echo "<div id='orderprice'>Total: $" . $formattedPrice . "</div>";
            $dbCheckPlaced = mysqli_query($con,"SELECT * from placed_order where oID='$orderId'");
            if(mysqli_num_rows($dbCheckPlaced) == 0){
                echo "<button id='receiveBtn' disabled>Order Received</button>";
                echo "<button id='place".$orderId."' onclick='placeOrder(".$orderId.")'>Place Order</button>";
            }
            else{
                $status = mysqli_fetch_array($dbCheckPlaced)['status'];
                if($status == NULL){
                    echo "<button id='receiveBtn' onclick='setReceived(".$orderId.")'>Order Received</button>";
                    echo "<button id='place".$orderId."' onclick='placeOrder(".$orderId.")'>Cancel Order</button>";
                }
                else if($status=='sent'){//sent 
                    echo "<button id='receiveBtn' onclick='setReceived(".$orderId.")'>Order Received</button>";
                    echo "<button id='place".$orderId."' disabled>Cancel Order</button>";
                }
                else{//received
                    echo "<button id='receiveBtn' disabled>Order Received</button>";
                    echo "<button id='place".$orderId."' disabled>Cancel Order</button>";
                }
            }
            echo "</div><br><br>";
        }
    ?>
    <script>
    const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')
            toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }

    function RemoveFromCart(product,orderId) {
        var placebtnId = "place"+orderId;
        if(document.getElementById(placebtnId).innerHTML == "Cancel Order"){
            alert("Can't remove product. Order is placed.");
        }
        else{ 
            var productId = product.id;
            var url = "removecart.php?pid=" + productId + "&oid=" + orderId;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                window.location.reload();
            }
            };
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
    }
    
    function placeOrder(orderId){
        var placebtnId = "place"+orderId;
        if(document.getElementById(placebtnId).innerHTML == "Place Order"){
            document.getElementById(placebtnId).innerHTML = "Cancel Order";
            var url = "placeorder.php?oid=" + orderId + "&action=place";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
        else{
            document.getElementById(placebtnId).innerHTML = "Place Order";
            var url = "placeorder.php?oid=" + orderId + "&action=cancel";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }

        window.location.reload();
    }

    function setReceived(orderId){
        var url = "orderstatus.php?oid=" + orderId + "&status=received";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
        window.location.reload();
    }
    </script>
</body>
</html>
