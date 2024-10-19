<?php
session_start();
include "config.php";
$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

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
    <title>Profile</title>
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
            <ul class="links">
                <li><a href="<?php if($_SESSION['role']=="Factory") echo "factoryhome.php"; else if($_SESSION['role']=="Supplier") echo "supplierhome.php";?>">Home</a></li>
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
                        echo '<i class="fa-regular fa-circle-user" style=\'font-size:30px;\'></i>';
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

    <div class="profile-card">
        <div class="header">
            <div class="profileImage">
                <?php 
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
            </div>
            <div class="postsNumber">
                <?php 
                if(isset($_SESSION['id'])){
                    $dbs=mysqli_query($con,"SELECT * from product where U_ID='$userid'");
                    echo "<div class=number>".mysqli_num_rows($dbs)."</div>";
                }
                ?>
                <div>POSTS</div>
            </div>
            <div class="connectionsNumber">
                <a href="viewconnections.php">
                <?php 
                if(isset($_SESSION['id'])){
                    $dbs=mysqli_query($con,"SELECT * from connection where uID='$userid' OR connectionID='$userid'");
                    echo "<div class=number>".mysqli_num_rows($dbs)."</div>";
                }
                ?>
                <div>CONNECTIONS</div>
                </a>
            </div>
            <div class="salesNumber">
                <?php 
                if(isset($_SESSION['id'])){
                    if($_SESSION['role']=='Factory'){
                        $dbs=mysqli_query($con,"SELECT * from factory where UID='$userid'");
                        $sales=mysqli_fetch_array($dbs)['Sales'];
                        $newsales=formatSalesNumber($sales);
                        echo "<div class=number>".$newsales."$</div>";
                    }
                    else if($_SESSION['role']=='Supplier'){
                        $dbs=mysqli_query($con,"SELECT * from supplier where UID='$userid'");
                        $sales=mysqli_fetch_array($dbs)['Sales'];
                        $newsales=formatSalesNumber($sales);
                        echo "<div class=number>".$newsales."$</div>";
                    }
                }
                ?>
                <div>SALES</div>
            </div>
        </div>
        <div class="info">
            <?php 
                if(isset($_SESSION['id'])){
                    $dbs=mysqli_query($con,"SELECT * from user where ID='$userid'");
                    $col=mysqli_fetch_array($dbs);
                    echo "Name: ".$col['FirstName']."&nbsp;".$col['LastName']."<br>";
                    echo "Username: @".$col['Username']."<br>";
                    echo "Role: ".$col['Role']."<br>";
                    echo "Country: ".$col['Country'];
                }
                ?>
        </div>
        <div class="bio"><textarea name="" id="bioText" disabled><?php
                if($_SESSION['role']=='Factory'){
                    $dbs=mysqli_query($con,"SELECT Bio from Factory where UID='$userid'");
                    $bio=mysqli_fetch_assoc($dbs)['Bio'];
                    if($bio!=NULL){
                        echo $bio;
                    }
                }
                else if($_SESSION['role']=='Supplier'){
                    $dbs=mysqli_query($con,"SELECT Bio from supplier where UID='$userid'");
                    $bio=mysqli_fetch_assoc($dbs)['Bio'];
                    if($bio!=NULL){
                        echo $bio;
                    }
                }
            ?></textarea></div>
        <div class="profileBtns">
            <a href="editprofile.php"><button>Edit Information</button></a>
            <button onclick="editBio()" id="editbtn">Edit Bio</button>
        </div>
        <div class="posts">
            <?php
                $sql = mysqli_query($con,"SELECT p.*, u.*, r.NumberOfStars 
                    FROM product p 
                    JOIN `User` u ON p.U_ID = u.ID 
                    LEFT JOIN Rates r ON r.pID = p.pID 
                    WHERE p.U_ID='$userid'");
                while ($col = mysqli_fetch_array($sql)) {
                    echo '<a href="editproduct.php?pid='.$col['pID'].'" style="text-decoration:none;">';
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
                    echo "<div class='product-stock' style='text-align:center;";
                    if($col['Available']==1){
                        echo " color:green;'>In Stock";
                    }
                    else {
                        echo " color:red;'>Out of Stock";
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

        function editBio() {
            var editButton = document.getElementById("editbtn");
            var bioTextarea = document.getElementById("bioText");

            if (editButton.innerHTML == "Edit Bio") {
                bioTextarea.removeAttribute('disabled');
                editButton.innerHTML = "Save Bio";

                // Create and append the Discard button
                var discardButton = document.createElement("button");
                discardButton.innerHTML = "Discard";
                discardButton.style.marginLeft = "5px"; // Apply margin using style property
                discardButton.id = "discardbtn"; // Set id for easier retrieval
                discardButton.onclick = function() {
                    var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("bioText").value = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "discardbio.php", true);
                xmlhttp.send();
                    bioTextarea.disabled = true;
                    editButton.innerHTML = "Edit Bio";
                    // Remove the Discard button
                    this.remove();
                };
                // Append the Discard button next to the Edit Bio button
                editButton.insertAdjacentElement('afterend', discardButton);
            } else { //if save button is pressed
                var str=document.getElementById("bioText").value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("bioText").value = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "editbio.php?q=" + str, true);
                xmlhttp.send();
                bioTextarea.disabled = true;
                var discardButton = document.getElementById("discardbtn");
                if (discardButton) { 
                    discardButton.remove(); 
                }
                editButton.innerHTML = "Edit Bio";
            }            
        } 

        document.getElementById("bioText").addEventListener("input", function() {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
        });
    </script>
</body>
</html>