<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}
extract($_POST);

$dbS=mysqli_query($con,"SELECT * from user where ID='$userid'");
$user=mysqli_fetch_array($dbS);
$username=$user['Username'];
$firstname=$user['FirstName'];
$lastname=$user['LastName'];
$country=$user['Country'];
$hashedpassword=$user['Password'];
$image=$user['Image'];

if (isset($_POST["submit"])){
    if ($_FILES["profile-img"]["name"]!="") {
        $target_file;
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["profile-img"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $uploadOK = 1;
        $check = getimagesize($_FILES["profile-img"]["tmp_name"]);
        if ($check === false) {
            echo "<div class='message'>File is not an image.</div><br>";
            $uploadOK = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif") {
            echo "<div class='message'>Sorry, only JPG, PNG, and GIF files are allowed.</div><br>";
            $uploadOK = 0;
        }

        if ($uploadOK == 0) {
            echo "<div class='message2'>Your file was not uploaded.</div>";
            echo "<button class='ok' onclick='tryAgain()'>OK</button>";
        } else {
            if (!move_uploaded_file($_FILES["profile-img"]["tmp_name"], $target_file)) {
                echo "<div class='message2'>Sorry, there was an error uploading your file.</div>";
                echo "<button class='ok' onclick='tryAgain()'>OK</button>";
                exit(); // Exit if image upload fails
            }
        }
    if($oldpassword=="" && $newpassword!=""){
        echo "Please fill old password";
    }
    else if($oldpassword!="" && $newpassword!=""){
        if(password_verify($oldpassword,$hashedpassword)){
            $newhashedPass=password_hash($newpassword,PASSWORD_BCRYPT);
            $dbU=mysqli_query($con,"UPDATE user set FirstName='$fname', LastName='$lname', UserName='$uname', Password='$newhashedPass', Country='$cntry', `Image`='$target_file' where ID='$userid'");
            if($_SESSION['role']=="Factory"){
                header('Location: factoryhome.php');
            }
            else if($_SESSION['role']=="Supplier"){
                header('Location: supplierhome.php');
            }
            else if($_SESSION['role']=="Buyer"){
                header('Location: buyerhome.php');
            }
            exit();
        } else {
            echo "Wrong old password";
        }
    }
    else if ($oldpassword=="" && $newpassword=="") {
        $dbU=mysqli_query($con,"UPDATE user set FirstName='$fname', LastName='$lname', UserName='$uname', Country='$cntry', `Image`='$target_file' where ID='$userid'");
        if($_SESSION['role']=="Factory"){
            header('Location: factoryhome.php');
        }
        else if($_SESSION['role']=="Supplier"){
            header('Location: supplierhome.php');
        }
        else if($_SESSION['role']=="Buyer"){
            header('Location: buyerhome.php');
        }
        exit();
    }
}
else{
    if($oldpassword=="" && $newpassword!=""){
        echo "Please fill old password";
    }
    else if($oldpassword!="" && $newpassword!=""){
        if(password_verify($oldpassword,$hashedpassword)){
            $newhashedPass=password_hash($newpassword,PASSWORD_BCRYPT);
            $dbU=mysqli_query($con,"UPDATE user set FirstName='$fname', LastName='$lname', UserName='$uname', Password='$newhashedPass', Country='$cntry' where ID='$userid'");
            if($_SESSION['role']=="Factory"){
                header('Location: factoryhome.php');
            }
            else if($_SESSION['role']=="Supplier"){
                header('Location: supplierhome.php');
            }
            else if($_SESSION['role']=="Buyer"){
                header('Location: buyerhome.php');
            }
            exit();
        } else {
            echo "Wrong old password";
        }
    }
    else if ($oldpassword=="" && $newpassword=="") {
        $dbU=mysqli_query($con,"UPDATE user set FirstName='$fname', LastName='$lname', UserName='$uname', Country='$cntry' where ID='$userid'");
        if($_SESSION['role']=="Factory"){
            header('Location: factoryhome.php');
        }
        else if($_SESSION['role']=="Supplier"){
            header('Location: supplierhome.php');
        }
        else if($_SESSION['role']=="Buyer"){
            header('Location: buyerhome.php');
        }
        exit();
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <link rel="stylesheet" href="editprofile.css">
    <title>Edit Profile</title>
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
    <form class="form-box" action="editprofile.php" method="post" style="height: 600px;" enctype="multipart/form-data">
        <div class="register-container" id="register">
            <div class="top">
                <header>Edit Profile</header>
            </div>
                <div class="two-forms">
                    <div class="input-box">
                        <input type="text" name="fname" id="" class="input-field" placeholder="Firstname"  value="<?php echo $firstname;?>" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="lname" id="" class="input-field" placeholder="Lastname"  value="<?php echo $lastname;?>" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
                    <div class="input-box">
                        <input type="text" name="uname" id="" class="input-field" placeholder="Username" value="<?php echo $username;?>" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="cntry" id="" class="input-field" placeholder="Country" value="<?php echo $country;?>" required>
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="oldpassword" id="" class="input-field" placeholder="Old Password">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="newpassword" id="" class="input-field" placeholder="New Password">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                    Current Image Source: <?php if($image==NULL) echo "Not Set"; else echo $image; ?><br><br>
                    Upload a new image: <input type="file" name="profile-img" id="profileImage">
                    </div><br>
                    <input type="Submit" name="submit" class="submit" value="Submit new Info"><br>
                    <div class="two-col">
                    <div class="submit" style="text-align:center; color:white; background-color:rgb(188, 6, 6); align-content:center;" onclick="DeleteAccount()">
                    Delete Account
                    </div>
                    <div class="submit" style="text-align:center; align-content:center;" onclick="discard()">
                    Discard
                    </div>
                    </div>
        </div>
    </form>
    <div id="errors"></div>
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
            <?php if($_SESSION['role']=="Factory"){?>
            window.location.href="factoryhome.php";
            <?php }
            else if($_SESSION['role']=="Supplier"){?>
            window.location.href="supplierhome.php";
            <?php }
            else if($_SESSION['role']=="Supplier"){?>
            window.location.href="buyerhome.php";
            <?php } ?>
        }

        function DeleteAccount(){
            if(confirm("Are you sure you want to delete your account?")){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "deleteaccount.php", true);
                xmlhttp.send();
                window.location.href="unsignedhome.php";
            }
        }
    </script>
</body>
</html>