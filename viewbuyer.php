<?php
session_start();
include 'config.php';

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

$buyerid=$_GET['viewid'];
$dbS=mysqli_query($con,"SELECT * from user where ID='$buyerid'");
$buyer=mysqli_fetch_array($dbS);
$image=$buyer['Image'];
$fname=$buyer['FirstName'];
$lname=$buyer['LastName'];
$username=$buyer['Username'];
$role=$buyer['Role'];
$country=$buyer['Country'];
$email=$buyer['Email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Buyer</title>
    <link rel="stylesheet" href="viewbuyer.css">
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
    <div class="profileImage">
        <?php 
            if(isset($_SESSION['id'])){
                if($image==NULL){
                    echo '<i class="fa-regular fa-circle-user"></i>';
                }
                else{
                    echo '<img src="'.$image.'" alt="">';
                }
            }
        ?>
    </div>
    <div class="info">
            <?php 
                echo "<div><span id='title'>Name: </span>".$fname."&nbsp;".$lname."</div>";
                echo "<div><span id='title'>Username: </span>@".$username."</div>";
                echo "<div><span id='title'>Role: </span>".$role."</div>";
                echo "<div><span id='title'>Country: </span>".$country."</div>";
                echo "<div><span id='title'>Email: </span>".$email."</div>";
                ?>
    </div>
    <div class="profileBtns">
        <button onclick="connect()" id="connectbtn"><?php 
                $dbconnect=mysqli_query($con,"SELECT * from connectionrequests where (uID='$userid' AND connectionID='$buyerid')OR(uID='$buyerid' AND connectionID='$userid')");
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
                    $dbs=mysqli_query($con,"SELECT * from connection where (uID='$userid' AND connectionID='$buyerid')OR(uID='$buyerid' AND connectionID='$userid')");
                    if(mysqli_num_rows($dbs)!=0){
                        echo "Connected";
                    }
                    else{
                        echo "Connect";
                    }
                }
            ?>
        </button>
        <a href="mailto:<?php echo $email;?>"><button>Contact</button></a>
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
            if(document.getElementById("connectbtn").innerHTML.trim()=="Connect"){
                document.getElementById("connectbtn").innerHTML="Connection Request Sent";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $buyerid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=request";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
            else if(document.getElementById("connectbtn").innerHTML.trim()=="Connection Request Sent"){
                document.getElementById("connectbtn").innerHTML="Connect";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $buyerid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=cancel";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
            else if(document.getElementById("connectbtn").innerHTML.trim()=="Accept Connection"){
                document.getElementById("connectbtn").innerHTML="Connected";
                document.getElementById("connectbtn").style="color:lightgray";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $buyerid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=accept";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
            else if(document.getElementById("connectbtn").innerHTML.trim()=="Connected"){
                document.getElementById("connectbtn").innerHTML="Connect";
                var senderId = "<?php echo $userid; ?>";
                var receiverId = "<?php echo $buyerid; ?>";
                var url = "requestconnection.php?senderId=" + senderId + "&receiverId=" + receiverId+"&action=remove";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            }
        }
</script>
</body>
</html>