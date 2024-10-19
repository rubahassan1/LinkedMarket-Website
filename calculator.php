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
    <title>Product Cost Calculator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="calculator.css">
</head>
<body>
<div id="nav">
    <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
    </div>
    <div id="rightNav">
        <ul class="links">
            <li><a href="<?php echo isset($_SESSION['role']) && $_SESSION['role'] === "Factory" ? 'factoryhome.php' : 'supplierhome.php'; ?>">Home</a></li>
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
        <a href="factoryprofile.php" class="profile">
            <?php if ($userid) {
                $dbs = mysqli_query($con, "SELECT Image FROM user WHERE ID='$userid'");
                $img = mysqli_fetch_assoc($dbs)['Image'];
                echo $img ? '<img src="'.$img.'" alt="">' : '<i class="fa-regular fa-circle-user"></i>';
            } ?>
        </a>
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
    <center>
    <div class="calculator">
    <fieldset id="costsFieldset">
        <legend>Cost List:</legend>
        <div id="costContainer">
           
        </div>
        <button type="button" onclick="addCost()" class="costbtn">Add Cost</button>
    </fieldset><br><br>

    <form id="calculatorForm">
        <table>
        <tr>
            <td><label for="totalcost">Total Cost: </label></td>
            <td><input type="text" name="totalcost" id="totalcost"></td>
        </tr>
        <tr>
            <td><label for="profit">Enter profit percentage(%): </label></td>
            <td><input type="text" name="profit" id="profit"></td>
        </tr>
        <tr>
            <td><label for="price">Selling Price: </label></td>
            <td><input type="text" name="price" id="sellingPrice">
            <button type="button" onclick="calculateSellingPrice()" id="calculate">Calculate</button></td>
        </tr>
        </table>
    </form>
    </div></center>
<script>
    const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')
            toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }

    function addCost() {
        const container = document.getElementById('costContainer');
        const newCost = document.createElement('div');
        newCost.innerHTML = `
            <label for="cost">Cost Name:</label>
            <input type="text" name="cost[]" required>
            <label for="amount">Amount:</label>
            <input type="text" name="amount[]" oninput="calculateTotal()" required>
            <button type="button" onclick="removeCost(this)">Remove</button>
        `;
        container.appendChild(newCost);
    }

    function removeCost(button) {
        const container = document.getElementById('costContainer');
        container.removeChild(button.parentNode);
        calculateTotal();
    }

    function calculateTotal(){
        const amounts = document.getElementsByName('amount[]');
        let total = 0;
        for (let i = 0; i < amounts.length; i++) {
            if (!isNaN(parseFloat(amounts[i].value))) {
                total += parseFloat(amounts[i].value);
            }
        }
        document.getElementById('totalcost').value = total.toFixed(2)+"$";
    }

    function calculateSellingPrice() {
        var totalCost = parseFloat(document.getElementById('totalcost').value);
        var profitPercentage = parseFloat(document.getElementById('profit').value);

        if (!isNaN(totalCost) && !isNaN(profitPercentage)) {
            var profitAmount = totalCost * (profitPercentage / 100);
            var sellingPrice = totalCost + profitAmount;
            document.getElementById('sellingPrice').value = sellingPrice.toFixed(2)+"$";
        } else {
            alert("Please enter valid numbers for Total Cost and Profit Percentage.");
        }
    }
</script>
</body>
</html>