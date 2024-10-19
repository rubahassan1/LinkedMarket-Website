<?php
    session_start();
    include "config.php";

    $userid;
    if(isset($_SESSION['id'])){
        $userid=$_SESSION['id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    <link rel="stylesheet" href="viewschedule.css">
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
        <li><a href="factoryhome.php">Home</a></li>
        <li><a href="factoryprofile.php">Profile</a></li>
        <li><a href="addproduct.php">Add Post</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
        </div>
    </div>
    <?php
        if(isset($_SESSION['id'])){
            $f_id=$_SESSION['id'];
        }
        $dbS=mysqli_query($con,"SELECT * from tasks where fID='$f_id'");
        echo "<div class='content'><h1>Your Schedule</h1><table><tr><th>Task</th><th>Start Date</th><th>End Date</th><th>Mark as Done</tr>";
        while($res=mysqli_fetch_array($dbS)){
            echo "<tr id='".$res['tID']."'>";
            echo "<td>".$res['Description']."</td>";
            echo "<td>".$res['StartDate']."</td>";
            echo "<td>".$res['EndDate']."</td>";
            echo "<td><input type='checkbox' name='' id='' onchange='deleteTask(".$res['tID'].")'></td></tr>";
        }
        echo "</table></div>";
    ?>
    <script>
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')
            toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }

        function deleteTask(id){
            i=id;
            var confirmation = confirm("Are you sure you want to mark this task as done?");
            if (confirmation) {
                var url = "MarkAsDone.php?val=" + i;
                if (window.XMLHttpRequest) {
                    request = new XMLHttpRequest();
                }
                request.onreadystatechange = function getInfo()
                {
                    if(request.readyState == 4 && request.status == 200)
                    {
                        document.getElementById(i).remove();
                    }
                }
                request.open("GET", url, true);
                request.send();
            }
        }

        
    </script>
</body>
</html>