<?php
session_start();
include "config.php";
$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}
extract($_POST);
if(isset($submit)){
    $dbI=mysqli_query($con,"INSERT into tasks (Description,StartDate,EndDate,fID) VALUES ('$pname','$start','$end','$userid')")
    or die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="factoryhome.css">
    <title>Factory</title>
</head>
<body>
    <div id="nav">
        <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <ul class="links">
                <li class="active"><a href="factoryhome.php">Home</a></li>
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
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    <div class="dropdown_menu">
        <div class="links">
        <li class="active"><a href="factoryhome.php">Home</a></li>
        <li><a href="factoryprofile.php">Profile</a></li>
        <li><a href="addproduct.php">Add Post</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
        </div>
    </div>
    <div class='top'>
    <div class="search">
        <input type="text" name="" id="" placeholder="Search for People" oninput="showHint(this.value)"><br>
        <i class="fa-solid fa-magnifying-glass"></i>
        <div id="suggestions" style="color:black;"></div>
        <a href="searchSupplies.php" style="color:#fff;">Search for supplies instead</a>
    </div>
    <div class="calculator-btn">
        <a href="calculator.php"><button>Product Cost Calculator</button></a>
    </div>
    <div class="cart-wishlist">
        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="wishlist.php"><i class="fa-regular fa-heart"></i></a>
    </div></div>
    <div class="schedule">
        <h1>Organize Your Production</h1>
        <form action="factoryhome.php" id="frm" method="post" onsubmit="return validateForm()">
            <input type="text" name="pname" id="pname" placeholder="Product Name"><br><br>
            Start: <input type="date" name="start" id="start"><br><br>
            End: <input type="date" name="end" id="end"><br><br>
            <button name="submit">Start Production</button>
        </form>
        <a href="viewschedule.php"><button>View Schedule</button></a><br>
        <a href="viewProductRequests.php"><button>View Products Requests</button></a>
    </div><br>
    <div class="factory-img">
        <img src="images/factoryhomeimage.png" alt="">
    </div>
    <div class="article">
        <h1>Ways to Optimize Production Efficiency in Your Factory</h1><br>
        <p>In today's manufacturing world, efficiency is the name of the game. To stay ahead, factories must streamline operations and maximize output. Here are some key strategies to help factories optimize production efficiency:
        <ol>
        <li> <b>Lean Manufacturing:</b>  Minimize waste and maximize value-added activities to streamline operations and boost productivity.</li>
        <li> <b>Automation and Technology:</b> Invest in robotics and smart systems to automate tasks, reduce errors, and increase throughput.</li>
        <li> <b>Just-in-Time (JIT) Manufacturing:</b> Produce goods only as needed to reduce inventory costs and improve responsiveness to market demands.</li>
        <li> <b>Employee Empowerment:</b> Provide training and encourage employee involvement in process improvement to drive productivity and quality.</li>
        <li> <b>Data Analytics:</b> Utilize data to identify inefficiencies and make data-driven decisions for continuous improvement.</li>
        <li> <b>Collaboration and Communication:</b> Foster teamwork and communication between departments to streamline workflows and resolve issues efficiently.</li>
        </ol>
        <p>By implementing these strategies, factories can enhance efficiency, reduce costs, and achieve sustainable success in today's competitive market.</p>
    </div>
    <div class="currentorders">
        <h1>Current Orders</h1><br>
        <table border='1' class="orders-table">
            <tr>
                <th>Username</th>
                <th>Order Id</th>
                <th>Location</th>
                <th>Date</th>
                <th>View Order</th>
            </tr>
            <?php
                $dbOrders=mysqli_query($con,"SELECT * from placed_order where sellerID='$userid' AND (status='sent' OR status IS NULL)");
                while($col=mysqli_fetch_array($dbOrders)){
                    echo "<tr>";
                    $customerId=$col['customerID'];
                    $selectUser=mysqli_query($con,"SELECT * from user where ID='$customerId'");
                    $user=mysqli_fetch_array($selectUser);
                    echo "<td>".$user['Username']."</td>";
                    echo "<td>".$col['oID']."</td>";
                    echo  "<td>".$user['Country']."</td>";
                    echo "<td>".$col['Date']."</td>";
                    echo "<td><a href='vieworder.php?oid=".$col['oID']."'><button>View</button></a></td>";
                    echo "</tr>";
                }
            ?>
        </table>
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

        function validateForm() {
            var pname = document.forms["frm"]["pname"].value;
            var start = document.forms["frm"]["start"].value;
            var end = document.forms["frm"]["end"].value;

            if (pname === "" || start === "" || end === "") {
                alert("Please fill in all fields");
                return false; // Prevent form submission
            }
    
            // If all fields are filled, allow form submission
            alert("Task added successfully");
            return true;
            pname = document.forms["frm"]["pname"].value="";
            document.forms["frm"]["start"].value="";
            document.forms["frm"]["end"].value="";
        }

        function showHint(str) {
            if (str.length === 0) {
                document.getElementById("suggestions").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("suggestions").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "search1.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</body>
</html>