<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}
$productid=$_GET['pid'];

$dbs=mysqli_query($con,"SELECT * from product where pID='$productid'");
$result=mysqli_fetch_array($dbs);
$pname=$result['Name'];
$pdescription=$result['Description'];
$pprice=$result['Price'];
$pmin=$result['MinQuantity'];
$pmax=$result['MaxQuantity'];
$pimage=$result['Img'];
$pavailable=$result['Available'];
$puid=$result['U_ID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link rel="stylesheet" href="viewproduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <?php }else if($_SESSION['role']=="admin"){?>
                <ul class="links">
                <li><a href="adminhome.php">Home</a></li>
                <li><a href="manageposts.php">Manage Posts</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
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
            <?php }else if($_SESSION['role']=="Supplier"){?>
                <div class="links">
                <li><a href="supplierhome.php">Home</a></li>
                <li><a href="factoryprofile.php">Profile</a></li>
                <li><a href="addproduct.php">Add Post</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
                </div>
            <?php }else if($_SESSION['role']=="admin"){?>
                <div class="links">
                <li><a href="adminhome.php">Home</a></li>
                <li><a href="manageposts.php">Manage Posts</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
                </div>
            <?php }}?>
    </div>
    <div class="info">
        <div class='productimg'>
        <img src="<?php echo $pimage; ?>" alt="">
        </div>
        <b>Name: </b><?php echo $pname; ?><br><br>
        <b>Description: </b><?php echo $pdescription; ?><br><br>
        <b>Quantity Limit: </b><?php echo $pmin; ?> to <?php echo $pmax; ?><br><br>
        <b>Price per Unit: </b><?php echo $pprice; ?>$ <br><br>
        <?php if($pavailable==1) echo "<b>In Stock</b>"; else echo "<b>Out of Stock</b>"; ?><br><br>
        <b>Posted by: </b>@<?php $dbUser=mysqli_query($con,"SELECT Username from user where ID='$puid'");
        echo mysqli_fetch_array($dbUser)['Username'];?><br><br>
        <?php if($_SESSION['role']=="Factory" || $_SESSION['role']=="Buyer"){?>
        <b>Quantity: </b><input type="number" name="" id="qty" min="<?php echo $pmin;?>" max="<?php echo $pmax;?>" value="<?php echo $pmin;?>" onkeydown="return false;" onchange="calculateTotal()"><br><br>
        <b>Total Price: </b><input type="text" name="" id="totalprice" value="<?php echo $pmin*$pprice;?>" disabled>$
        <?php }?>
    </div><br>
    <?php
    if($_SESSION['role']=="Buyer" || $_SESSION['role']=="Factory"){?>
    <div class="btns">
        <button onclick="addToCart(<?php echo $pavailable;?>)" id="cart-btn"><?php 
            // Check if there are any orders with this product
    $selectOrder = mysqli_query($con, "SELECT * FROM order_products WHERE pID='$productid'");
    $found = false;
    $buttonText = "Add to Cart";
    
    if (mysqli_num_rows($selectOrder) > 0) {
        while ($orders = mysqli_fetch_array($selectOrder)) {
            $oid = $orders['oID'];
            // Check if the order is placed
            $checkPlaced = mysqli_query($con, "SELECT * FROM placed_order WHERE oID='$oid'");
            if (mysqli_num_rows($checkPlaced) == 0) {
                // The order is not placed
                $selectorder = mysqli_query($con, "SELECT * FROM `order` WHERE sellerID='$puid' AND customerID='$userid' AND oID='$oid'");
                if (mysqli_num_rows($selectorder) > 0) {
                    $buttonText = "Remove from Cart";
                    $found = true;
                    break;
                }
            } else {
                // The order is placed
                $placedorder = mysqli_fetch_array($checkPlaced);
                $status = $placedorder['status'];
                $orderID = $placedorder['oID'];
                if ($status != 'sent' && $status != 'received') {
                    $selectorder = mysqli_query($con, "SELECT * FROM `order` WHERE sellerID='$puid' AND customerID='$userid' AND oID='$orderID'");
                    if (mysqli_num_rows($selectorder) > 0) {
                        $buttonText = "Remove from Cart";
                        $found = true;
                        break;
                    }
                }
            }
        }
    }

    echo $buttonText;
            /*$dborder=mysqli_query($con,"SELECT oID from `order` where sellerID='$puid' and customerID='$userid'");
            if(mysqli_num_rows($dborder)==0){
                echo "Add to Cart";
            }
            else{
                $oid=mysqli_fetch_assoc($dborder)['oID'];
                $dbproduct=mysqli_query($con,"SELECT * from order_products where pID='$productid' AND oID='$oid'");
                if(mysqli_num_rows($dbproduct)==0){
                    echo "Add to Cart";
                }
                else{
                    echo "Remove from Cart";
                }
            }*/
        ?></button>
        <button onclick="addToWishList()" id="wishlist-btn"><?php 
        $select=mysqli_query($con,"Select * from wishlist_products where pID='$productid'");
        if(mysqli_num_rows($select)==0) echo "Add to WishList";
        else echo "Remove from WishList";?></button>
    </div><br><br>
    <?php }?>
    
    <?php if($_SESSION['role']=="Buyer" || $_SESSION['role']=="Factory"){?>
    <div class="rate">
        <h3>Rate This Product</h3>
        <?php $dbSrates=mysqli_query($con,"SELECT * from user_rating where uID='$userid' AND pID='$productid'");
        $nbrows=mysqli_num_rows($dbSrates);
        if($nbrows!=0){
        $rating=mysqli_fetch_array($dbSrates);
        $nbofstars=$rating['NbStars'];}?>
        <div class="star-widget">
        <span class="fa fa-star fa-2x <?php if($nbrows!=0){ if($nbofstars>=1) echo 'checked';}?>" id="star1" onclick="rate(1)"></span>
        <span class="fa fa-star fa-2x <?php if($nbrows!=0){ if($nbofstars>=2) echo 'checked';}?>" id="star2" onclick="rate(2)"></span>
        <span class="fa fa-star fa-2x <?php if($nbrows!=0){ if($nbofstars>=3) echo 'checked';}?>" id="star3" onclick="rate(3)"></span>
        <span class="fa fa-star fa-2x <?php if($nbrows!=0){ if($nbofstars>=4) echo 'checked';}?>" id="star4" onclick="rate(4)"></span>
        <span class="fa fa-star fa-2x <?php if($nbrows!=0){ if($nbofstars>=5) echo 'checked';}?>" id="star5" onclick="rate(5)"></span>
    </div>
    <div class="feedback">
        <h3>Feedbacks:</h3>
        <div>
            Submit Yours: <input type="text" name="feedback" id="feedback">
            <button name="submit" id="submit" onclick="submitFeedback(<?php echo $productid;?>)">Submit</button>
        </div><br><br>
        <?php
            $selectfeedbacks = mysqli_query($con, "SELECT * FROM Feedback WHERE pID='$productid'");
            while ($productFeedbacks = mysqli_fetch_array($selectfeedbacks)) {
                $feedbackUserId = $productFeedbacks['uID'];
                $selectFeedbackUser = mysqli_query($con, "SELECT * FROM user WHERE ID='$feedbackUserId'");
                $feedbackUserInfo = mysqli_fetch_array($selectFeedbackUser);
                $uname = $feedbackUserInfo['Username'];
                echo "<div class='feedback-item'>"; // Added class 'feedback-item'
                echo "<div id='feedbackUname'><b>@" . $uname . "</b></div>";
                $date = $productFeedbacks['Date'];
                echo "<div id='feedbackDate'>" . $date . "</div>";
                $content = $productFeedbacks['content'];
                echo "<div id='feedbackContent'>" . $content . "</div>";
                echo "</div><br>";
            }
        ?>
    </div>
    <?php }else{?>
        <div class="feedback">
        <h3>Feedbacks:</h3><?php
        $selectfeedbacks = mysqli_query($con, "SELECT * FROM Feedback WHERE pID='$productid'");
        while ($productFeedbacks = mysqli_fetch_array($selectfeedbacks)) {
            $feedbackUserId = $productFeedbacks['uID'];
            $selectFeedbackUser = mysqli_query($con, "SELECT * FROM user WHERE ID='$feedbackUserId'");
            $feedbackUserInfo = mysqli_fetch_array($selectFeedbackUser);
            $uname = $feedbackUserInfo['Username'];
            echo "<div class='feedback-item'>"; // Added class 'feedback-item'
            echo "<div id='feedbackUname'><b>@" . $uname . "</b></div>";
            $date = $productFeedbacks['Date'];
            echo "<div id='feedbackDate'>" . $date . "</div>";
            $content = $productFeedbacks['content'];
            echo "<div id='feedbackContent'>" . $content . "</div>";
            echo "</div><br>";
        }
    ?></div><?php }?>
    <div id="error"></div>
    <script>
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')
            toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }


        function calculateTotal(){
            var unitprice= <?php echo $pprice; ?>;
            var quantity=document.getElementById("qty").value;
            var total=unitprice*quantity;
            document.getElementById('totalprice').value=total;
        }
        function addToWishList(){
            if(document.getElementById("wishlist-btn").innerHTML=="Add to WishList"){
                document.getElementById("wishlist-btn").innerHTML="Remove from WishList";
                var productId = "<?php echo $productid; ?>";
                var url = "addwishList.php?pid=" + productId+"&action=add";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
            else{
                document.getElementById("wishlist-btn").innerHTML="Add to WishList";
                var productId = "<?php echo $productid; ?>";
                var url = "addwishList.php?pid=" + productId+"&action=remove";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
        }
        function addToCart(available){
            if(document.getElementById("cart-btn").innerHTML=="Add to Cart"){
                if(available==1){
                    document.getElementById("cart-btn").innerHTML="Remove from Cart";
                    var productId = "<?php echo $productid; ?>";
                    var productquantity= document.getElementById("qty").value;
                    var sellerId="<?php echo $puid;?>";
                    var customerId="<?php echo $userid;?>";
                    var totalprice=document.getElementById("totalprice").value;
                    var url = "addcart.php?pid=" + productId+"&pqty="+productquantity+"&seller="+sellerId+"&customer="+customerId+"&ptotalprice="+totalprice+"&action=add";
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("GET", url, true);
                    xmlhttp.send();
                }
                else{
                    alert("Can't add to Cart. Product is out of stock.");
                }
            }
            else{
                var productId = "<?php echo $productid; ?>";
                var productquantity= document.getElementById("qty").value;
                var sellerId="<?php echo $puid;?>";
                var customerId="<?php echo $userid;?>";
                var totalprice=document.getElementById("totalprice").value;
                var url = "addcart.php?pid=" + productId+"&pqty="+productquantity+"&seller="+sellerId+"&customer="+customerId+"&ptotalprice="+totalprice+"&action=remove";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        var response = xmlhttp.responseText;
                        if(response=='Cancel First'){
                        alert("Cancel your order in the cart first.");
                    }
                    else{
                        document.getElementById("cart-btn").innerHTML="Add to Cart";
                    }
                    }
                };
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
        }

        function rate(value){
            var productId=<?php echo $productid;?>;
            var url = "rateProduct.php?pid=" + productId +"&rate="+value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            window.location.reload();
        }

        function submitFeedback(productid) {
            var feedbackValue = document.getElementById('feedback').value.trim();
            if (feedbackValue == "") {
                alert("Feedback field is empty");
            }
            if (feedbackValue !== "") {
                var feedback = document.getElementById('feedback').value;
                var url = "submitfeedback.php?productid=" + productid + "&feedback=" + feedback;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        var newFeedbackDiv = document.createElement('div');
                        newFeedbackDiv.innerHTML = xmlhttp.responseText;
                        var feedbackContainer = document.querySelector('.feedback');
                        feedbackContainer.appendChild(newFeedbackDiv);
                    }
                };
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            document.getElementById('feedback').value="";
            alert("Your Feedback is submitted. We appretiate your help!")
            }
}
    </script>
</body>
</html>