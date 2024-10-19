<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <link rel="stylesheet" href="manageposts.css">
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
                <li><a href="adminhome.php">Home</a></li>
                <li class="active"><a href="manageposts.php">Manage Posts</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    <div class="dropdown_menu">
        <div class="links">
        <li><a href="adminhome.php">Home</a></li>
        <li class="active"><a href="manageposts.php">Manage Posts</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
        </div>
    </div>
    <h1 class="title">Low Rating Posts</h1>
    <div class="products">
        <?php
            $sql = mysqli_query($con,"SELECT p.*, u.*, r.NumberOfStars 
            FROM product p 
            JOIN `User` u ON p.U_ID = u.ID 
            LEFT JOIN Rates r ON r.pID = p.pID 
            WHERE r.NumberOfStars<3");
        while ($col = mysqli_fetch_array($sql)) {
            echo '<div class="product-card">';
            echo '<a href="viewproduct.php?pid='.$col['pID'].'" style="text-decoration:none;">';
            echo '<img class="product-image" src="'.$col['Img'].'">';
            echo '<div class="product-name" id= "prName" name="'.$col['pID'].'">' . $col['Name'] . '</div>';
            echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>";
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
            echo "<div class='product-stock'>";
            if($col['Available']==1){
                echo "In Stock";
            }
            else {
                echo "Out of Stock";
            }
            echo "</div>";
            echo "</a>";
            echo "<div class='button-container'>";
            echo "<button id='".$col['pID']."' class='removebtn' onclick='deletePost(this)'>Remove</button><br>";
            echo "<button id='".$col['pID']."' onclick='notify(this)' class='notifybtn'>Notify</button>";
            echo "</div>";
            echo "</div>";
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

        function deletePost(product){
            if(confirm("Are you sure you want to delete this post?")){
            var productid=product.id;
            var url = "deleteLowPost.php?pid=" + productid+"&action=remove";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            window.location.reload();
            }
        }

        function notify(product){
            alert("Notification Sent");
            var productid=product.id;
            var url = "deleteLowPost.php?pid=" + productid+"&action=notify";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
    </script>
</body>
</html>