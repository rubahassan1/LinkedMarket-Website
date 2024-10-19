<?php
session_start();
include "config.php";

$userid;
$role;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
    $role=$_SESSION['role'];
}

$catalogID;
if($role=="Supplier"){
    $dbCatalog=mysqli_query($con,"SELECT * from catalog where uID='$userid'");
    $catalogID=mysqli_fetch_array($dbCatalog)['cID'];
}

$pid=$_GET['pid'];

$selectProduct=mysqli_query($con,"SELECT * from product where pID='$pid'");
$product=mysqli_fetch_array($selectProduct);
$name=$product['Name'];
$price=$product['Price'];
$min=$product['MinQuantity'];
$max=$product['MaxQuantity'];
$category=$product['Category'];
$available=$product['Available'];
$description=$product['Description'];
$image=$product['Img'];

$oldcategoryId=$category;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="editproduct.css">
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
    <div class="editproduct">
        <h1>Edit Product</h1><br>
        <form action="updatepost.php?" method="post" enctype="multipart/form-data">
        <div class="top">
        <div class="first-side">
        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
        <input type="hidden" name="oldCat" value="<?php echo $oldcategoryId; ?>">
            <div id="pname">Name: <input type="text" name="pname" id="" required value="<?php echo $name;?>"></div>
            <div id="pprice">Price($): <input type="text" name="pprice" id="" required value="<?php echo $price;?>"></div>
            <div id="qty">Quantity Limit <input type="number" name="min" id="min" required value="<?php echo $min;?>">
            To <input type="number" name="max" id="max" required value="<?php echo $max;?>"></div>
            <div id="category"><?php if($role=="Supplier"){?>
            Category <select name="newcategory" id="">
                <option value="">Select Category</option>
                <?php
                    $dbCat=mysqli_query($con,"SELECT * from category where catalogID='$catalogID'");
                    while($cat=mysqli_fetch_array($dbCat)){
                        echo "<option value='".$cat['categoryID']."' ";
                        if($category!=NULL){
                            if($cat['categoryID']==$category){
                                echo "selected";
                            }
                        }
                        echo ">".$cat['Name']."</option>";
                    }
                ?>
            </select><br><br><?php }?></div>
            <div id="stock"><input type="checkbox" name="stock" id="" <?php if($available==0) echo "checked";?>> Out of Stock</div>
            </div>
            <div class="second-side">
            <div id="desc">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="desc">Description:</label>
                <textarea name="desc" id="" rows="8" cols="50" required><?php echo $description;?></textarea><br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Current Image Source: <?php echo $image; ?><br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upload a new image: <input type="file" name="img" id="productImage">
            </div>
            </div>
            </div>
            <div class="btns">
                <button type="submit" name="submit" id="submit">Update</button>
            </div>
        </form>
        <a href="factoryhome.php"><button>Discard</button></a>
        <button onclick="deletePost()" id="delete">Delete Post</button>
    </div>
    <div class="feedback">
    <h3>Feedbacks:</h3><br>
        <?php
            $selectfeedbacks = mysqli_query($con, "SELECT * FROM Feedback WHERE pID='$pid'");
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
    <script>
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')
            toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }


        function deletePost(){
            if(confirm("Are you sure you want to delete this post?")){
                productId=<?php echo $pid;?>;
                var url = "deleteproduct.php?pid=" + productId;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("errors").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
                window.location.href = "factoryprofile.php";
            }
        }
    </script>
</body>
</html>