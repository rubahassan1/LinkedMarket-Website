<?php
session_start();
include "config.php";

$userid;
if(isset($_SESSION['id']) && is_numeric($_SESSION['id'])){
    // Validate user ID
    $userid = $_SESSION['id'];
}
extract($_POST);
if(isset($submit)){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    
    // Check if the username exists
    $stmt_user = mysqli_query($con, "SELECT ID FROM user WHERE Username = '$username'");
    if(mysqli_num_rows($stmt_user)){
    $user=mysqli_fetch_array($stmt_user);
        $receiverID = $user['ID'];
        
        // Insert the notification
        $stmt_insert = mysqli_prepare($con, "INSERT INTO notification (content, ReceiverID, Date) VALUES (?, ?, NOW())");
        mysqli_stmt_bind_param($stmt_insert, "si", $content, $receiverID);
        $dbI = mysqli_stmt_execute($stmt_insert);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminhome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Home Page</title>
</head>
<body>
<div id="nav">
        <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <ul class="links">
                <li class="active"><a href="adminhome.php">Home</a></li>
                <li><a href="manageposts.php">Manage Posts</a></li>
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
        <li class="active"><a href="adminhome.php">Home</a></li>
        <li><a href="manageposts.php">Manage Posts</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
        </div>
    </div>
    <div class="top">
        <div class='supplierimg'>
            <img src="images/supplierhomeimage.png" alt="">
        </div>
        <div class="slogan">
            <p>Empowering Operations, Inspiring Success</p>
        </div>
    </div>
    <div class="send-notification">
    <form action="adminhome.php" method="post" onsubmit="return verifyUsername()" id="notifyForm">
        <label for="username">Notification To:</label>
        <input type="text" name="username" id="username" placeholder="Username" required><br><br>
        <textarea name="content" id="" placeholder="Write the Notification Here..." required></textarea>
        <button name="submit">Send</button>
    </form>
    </div>
    <div class="sentorders">
        <h1>Sent Orders</h1>
        <table border='1' class="orders-table">
            <tr>
                <th>Order Id</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Send Notification</th>
            </tr>
            <?php
                $dbOrders=mysqli_query($con,"SELECT * from placed_order where status='sent' AND Notified='0'");
                while($col=mysqli_fetch_array($dbOrders)){
                    echo "<tr>";
                    $sellerId=$col['sellerID'];
                    $customerId=$col['customerID'];
                    $selectSeller=mysqli_query($con,"SELECT * from user where ID='$sellerId'");
                    $selectCustomer=mysqli_query($con,"SELECT * from user where ID='$customerId'");
                    $seller=mysqli_fetch_array($selectSeller);
                    $customer=mysqli_fetch_array($selectCustomer);
                    echo "<td>".$col['oID']."</td>";
                    echo "<td>".$seller['Username']."</td>";
                    echo  "<td>".$customer['Username']."</td>";
                    echo "<td>".$col['Date']."</td>";
                    echo "<td><button onclick='notifySent(".$col['oID'].")'>Notify Customer</button></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>

    <div class="receivedorders">
        <h1>Received Orders</h1>
        <table border='1' class="orders-table">
            <tr>
                <th>Order Id</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Send Notification</th>
            </tr>
            <?php
                $dbOrders=mysqli_query($con,"SELECT * from placed_order where status='received'");
                while($col=mysqli_fetch_array($dbOrders)){
                    echo "<tr>";
                    $sellerId=$col['sellerID'];
                    $customerId=$col['customerID'];
                    $selectSeller=mysqli_query($con,"SELECT * from user where ID='$sellerId'");
                    $selectCustomer=mysqli_query($con,"SELECT * from user where ID='$customerId'");
                    $seller=mysqli_fetch_array($selectSeller);
                    $customer=mysqli_fetch_array($selectCustomer);
                    echo "<td>".$col['oID']."</td>";
                    echo "<td>".$seller['Username']."</td>";
                    echo  "<td>".$customer['Username']."</td>";
                    echo "<td>".$col['Date']."</td>";
                    echo "<td><button onclick='notifyReceived(".$col['oID'].")'>Notify Seller</button></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
    <div id='error'></div>
    <script>
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')
            toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }

        function notifySent(orderID){
            alert("Notification Sent.");
            var url="notify.php?action=sent&oid="+orderID;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("error").innerHTML = xmlhttp.responseText;
                    }
            };
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            window.location.reload();
            window.location.reload();
        }

        function notifyReceived(orderID){
            alert("Notification Sent.");
            var url="notify.php?action=received&oid="+orderID;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        document.getElementById("error").innerHTML = xmlhttp.responseText;
                    }
            };
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            window.location.reload();
            window.location.reload();
        }

        function verifyUsername(){
        var Uname=document.getElementById('username').value;
        var xmlhttp = new XMLHttpRequest();
        var result;
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                result = xmlhttp.responseText;
                if (result== 'Error') {
                    alert("User is not Found");
                    return false;
                } else {
                    alert("Notification Sent Successfully");
                    return true; // Submit the form if user is found
                }
            }
        };
        xmlhttp.open("GET", "verifyUsername.php?uname=" + Uname, true);
        xmlhttp.send();
    }
    </script>
</body>
</html>