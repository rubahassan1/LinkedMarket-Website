<?php
session_start();
include "config.php";

$userid = null;
if(isset($_SESSION['id']) && is_numeric($_SESSION['id'])){
    // Validate user ID
    $userid = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="buyerhome.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>Buyer</title>
</head>
<body>
    <div id="nav">
        <div id="logo">
            <img src="images/logo.png" alt="" id='logo'>
            <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <ul class="links">
                <li class="active"><a href="buyerhome.php">Home</a></li>
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
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    <div class="dropdown_menu">
        <div class="links">
            <li class="active"><a href="buyerhome.php">Home</a></li>
            <li><a href="buyerprofile.php">Profile</a></li>
            <li><a href="requestProduct.php">Request a Product</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
            <li><a href="logout.php">Logout</a></li>
        </div>
    </div>

    <div class="top">
        <div class='buyerimg'>
            <img src="images/buyerhomeimage.png" alt="">
        </div>
        <div class="slogan">
            <p>Discover, Connect, Thrive: Your Gateway to Quality Products</p>
        </div>
    </div>

    <div class="content">
        <div class="searchbar">
            <input type="text" id='searchproducts' placeholder="Find Products..." oninput="showres(this.value)">
            <i class="fa-solid fa-magnifying-glass"></i>
            <a href="searchPeople.php" style="color:#fff;">Search for People instead</a>
        </div>
        <div class="cart-wishlist">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="wishlist.php"><i class="fa-regular fa-heart"></i></a>
        </div>
    </div>

    <div id="search-results">
        <center>
        <p style="color: #ffffff92;">Results will show here...</p>
        </center>
    </div>
    <h2 class="title" style="color:#fff; text-align:center; font-size:35px;">Explore</h2>
    <div class="carousel">
        <section class="product">
            <?php $dbS=mysqli_query($con,"SELECT * from product ORDER BY RAND() LIMIT 10");
            ?>
            <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
            <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
            <div class="product-container">
            <?php while($random=mysqli_fetch_array($dbS)){?>
                <a href="viewproduct.php?pid=<?php echo $random['pID'];?>" style="text-decoration:none;">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $random['Img'];?>" alt="" class="product-thumb">
                    </div>
                    <div class="product-info">
                        <div class="product-name" id= "prName" name="<?php echo $random['pID']?>"><?php echo $random['Name'];?></div>
                        <?php $pid=$random['pID'];
                            $uid=$random['U_ID'];
                            $product_user=mysqli_query($con,"SELECT * from user where ID='$uid'");
                            $username=mysqli_fetch_array($product_user)['Username'];
                        ?>
                        <?php
                            $product_rating=mysqli_query($con,"SELECT NumberOfStars from rates where pID='$pid'");
                            $rating=mysqli_fetch_array($product_rating)['NumberOfStars'];
                            $start=1;
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
                        ?>
                        <span class="product-price"><?php echo $random['Price'];?>$</span>
                        <div class="username">@<?php echo $username;?></div>
                        <div class="product-stock">
                            <?php
                                if($random['Available']==1){
                                    echo "<div class='available'>In Stock</div>";
                                }
                                else {
                                    echo "<div class='not-available'>Out of Stock</div>";
                                }
                            ?>
                        </div>
                    </div>
                </div></a><?php }?>
            </div>
        </section>
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

        function showres(str) {
            if (str.length === 0) {
                document.getElementById("search-results").style="height: 300px;";
                document.getElementById("search-results").innerHTML = "<center><p style='color: #ffffff92;'>Results will show here...</p></center>";
                return;
            } else {
                document.getElementById("search-results").style='height:fit-content;';
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("search-results").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "SearchProducts.php?q=" + str, true);
                xmlhttp.send();
            }
        }

        //slider js

        const productContainers=[...document.querySelectorAll('.product-container')];
        const nxtBtn= [...document.querySelectorAll('.nxt-btn')];
        const preBtn= [...document.querySelectorAll('.pre-btn')];

        productContainers.forEach((item,i)=>{
            let containerDimensions=item.getBoundingClientRect();
            let containerWidth= containerDimensions.width;
            nxtBtn[i].addEventListener('click',()=>{
                item.scrollLeft+=containerWidth;
            })

            preBtn[i].addEventListener('click',()=>{
                item.scrollLeft-=containerWidth;
            })
        })
    </script>
</body>
</html>
