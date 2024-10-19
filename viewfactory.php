<?php
session_start();
include "config.php";
$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}
$factoryid = $_GET['viewid'];

function formatSalesNumber($sales) {
    if ($sales >= 1000000000000) {
        return round($sales / 1000000000000, 2) . "T";
    } elseif ($sales >= 1000000000) {
        return round($sales / 1000000000, 2) . "B";
    } elseif ($sales >= 1000000) {
        return round($sales / 1000000, 2) . "M";
    } elseif ($sales >= 1000) {
        return round($sales / 1000, 2) . "K";
    } else {
        return $sales;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="factoryprofile.css">
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
            <?php }}?>
    </div>

    <div class="profile-card">
        <div class="header">
            <div class="profileImage">
                <?php 
                    $dbs=mysqli_query($con,"SELECT Image from user where ID='$factoryid'");
                    $img=mysqli_fetch_assoc($dbs)['Image'];
                    if($img==NULL){
                        echo '<i class="fa-regular fa-circle-user"></i>';
                    }
                    else{
                        echo '<img src="'.$img.'" alt="">';
                    }
                ?>
            </div>
            <div class="postsNumber">
                <?php 
                    $dbs=mysqli_query($con,"SELECT * from product where U_ID='$factoryid'");
                    echo "<div class=number>".mysqli_num_rows($dbs)."</div>";
                ?>
                <div>POSTS</div>
            </div>
            <div class="connectionsNumber">
                <?php 
                    $dbs=mysqli_query($con,"SELECT * from connection where uID='$factoryid' OR connectionID='$factoryid'");
                    echo "<div class=number>".mysqli_num_rows($dbs)."</div>";
                ?>
                <div>CONNECTIONS</div>
            </div>
            <div class="salesNumber">
            <?php 
                $dbs=mysqli_query($con,"SELECT * from factory where UID='$factoryid'");
                $sales=mysqli_fetch_array($dbs)['Sales'];
                $newsales=formatSalesNumber($sales);
                echo "<div class=number>".$newsales."$</div>";
            ?>
                <div>SALES</div>
            </div>
        </div>
        <div class="info">
            <?php 
                    $dbs=mysqli_query($con,"SELECT * from user where ID='$factoryid'");
                    $col=mysqli_fetch_array($dbs);
                    echo "Name: ".$col['FirstName']."&nbsp;".$col['LastName']."<br>";
                    echo "Username: @".$col['Username']."<br>";
                    echo "Role: ".$col['Role']."<br>";
                    echo "Country: ".$col['Country'];
                ?>
        </div>
        <div class="bio"><?php
                    $dbs=mysqli_query($con,"SELECT Bio from Factory where UID='$factoryid'");
                    $bio=mysqli_fetch_assoc($dbs)['Bio'];
                    if($bio!=NULL){
                        echo $bio;
                    }
                ?>
        </div>
        <div class="profileBtns">
            <button onclick="connect()" id="connectbtn"><?php 
                $dbconnect=mysqli_query($con,"SELECT * from connectionrequests where (uID='$userid' AND connectionID='$factoryid')OR(uID='$factoryid' AND connectionID='$userid')");
                if(mysqli_num_rows($dbconnect)!=0){
                    $result=mysqli_fetch_array($dbconnect);
                    if($result['uID']==$userid){
                        echo "Connection Request Sent";
                    }
                    else{
                        echo "Accept Connection";
                    }
                }
                else{
                    $dbs=mysqli_query($con,"SELECT * from connection where (uID='$userid' AND connectionID='$factoryid')OR(uID='$factoryid' AND connectionID='$userid')");
                    if(mysqli_num_rows($dbs)!=0){
                        echo "Connected";
                    }
                    else{
                        echo "Connect";
                    }
                }
            ?></button>
            <a href="mailto:<?php $dbs=mysqli_query($con,"SELECT * from user where ID='$factoryid'");
            $col=mysqli_fetch_array($dbs); echo $col['Email'];?>
            "><button>Contact</button></a>
        </div>
        <div class="posts">
            <?php
                $sql = mysqli_query($con,"SELECT p.*, u.*, r.NumberOfStars 
                    FROM product p 
                    JOIN `User` u ON p.U_ID = u.ID 
                    LEFT JOIN Rates r ON r.pID = p.pID 
                    WHERE p.U_ID='$factoryid'");
                while ($col = mysqli_fetch_array($sql)) {
                    echo '<a href="viewproduct.php?pid='.$col['pID'].'" style="text-decoration:none;">';
                    echo '<div class="product-card">';
                    echo '<img class="product-image" src="'.$col['Img'].'">';
                    echo '<div class="product-name" id= "prName" name="'.$col['pID'].'" style="text-align:center; justify-content:center;">' . $col['Name'] . '</div>';
                    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>";
                    echo "<div style='text-align:center;'>";
                    $rating = $col["NumberOfStars"];
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
                    echo "<span class='product-price'>".$col['Price']."$</span>";
                    echo "</div>";
                    echo "<div class='product-stock' style='color:";
                    if($col['Available']==1){
                        echo "green'>In Stock";
                    }
                    else {
                        echo "red'>Out of Stock";
                    }
                    echo "</div>";
                    echo '</div>';
                    echo "<a>";
                }
            ?>
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

        function connect(){
            if(document.getElementById("connectbtn").innerHTML=="Connect"){
                document.getElementById("connectbtn").innerHTML="Connection Request Sent";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $factoryid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=request";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
            else if(document.getElementById("connectbtn").innerHTML=="Connection Request Sent"){
                document.getElementById("connectbtn").innerHTML="Connect";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $factoryid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=cancel";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
            else if(document.getElementById("connectbtn").innerHTML=="Accept Connection"){
                document.getElementById("connectbtn").innerHTML="Connected";
                document.getElementById("connectbtn").style="color:lightgray";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $factoryid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=accept";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
            else if(document.getElementById("connectbtn").innerHTML=="Connected"){
                document.getElementById("connectbtn").innerHTML="Connect";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $factoryid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=remove";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
        }
          
    </script>
</body>
</html>