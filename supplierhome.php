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
    <link rel="stylesheet" href="supplierhome.css">
    <title>Supplier</title>
</head>
<body>
    <div id="nav">
        <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <ul class="links">
                <li class="active"><a href="supplierhome.php">Home</a></li>
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
        <li class="active"><a href="supplierhome.php">Home</a></li>
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
    </div>
    <div class="calculator-btn">
        <a href="calculator.php"><button>Product Cost Calculator</button></a>
    </div>
    </div>
    <div class="catalogContainer">
    <div class="catalog">
        <h1>Build Your Catalog</h1>
        <fieldset id="categoryFieldset">
        <legend>Categories</legend>
        <div id="categories">
            <?php
                $selectcatalog=mysqli_query($con,"SELECT cID from catalog where uID='$userid'");
                $catalogID=mysqli_fetch_array($selectcatalog)['cID'];
                $selectcategories=mysqli_query($con,"SELECT DISTINCT * from category where catalogID='$catalogID'");
                while($category=mysqli_fetch_array($selectcategories)){
                    echo "<div id='catName' onclick='editCategory(".$category['categoryID'].")'>".$category['Name']."</div>";
                }
            ?>
        </div>
        <div id="categoryContainer">
           
    </div>
    </fieldset><br><br>
    <button type="button" id="addbtn" onclick="addCategory()" class="categorybtn">Add Category</button><br><br>
    </div></div>
    <div class="supplier-img">
        <img src="images/factoryhomeimage.png" alt="">
    </div>
    <div class="article">
        <h1>Sustainability in Supplier Operations: Environmental Responsibility and Value Creation</h1><br>
        <p>In the realm of supplier operations, sustainability has emerged as a critical factor shaping business practices and driving value creation. With an increasing emphasis on environmental responsibility, suppliers are seeking innovative ways to integrate sustainability into their operations. Here are key strategies for suppliers to enhance sustainability and create value:</p>
        <ol>
        <li> <b>Environmental Stewardship:</b>  Prioritize environmentally friendly practices such as energy conservation, waste reduction, and emissions control. Implementing green initiatives not only reduces ecological footprint but also enhances brand reputation and attracts environmentally conscious customers.</li>
        <li> <b>Supply Chain Transparency:</b> Foster transparency across the supply chain by tracing the origins of materials and ensuring ethical sourcing practices. By promoting transparency, suppliers can build trust with stakeholders and mitigate risks associated with unethical sourcing or environmental violations.</li>
        <li> <b>Resource Efficiency:</b> Optimize resource utilization through efficient processes and innovative technologies. By minimizing resource consumption and maximizing resource recovery, suppliers can reduce costs, improve operational efficiency, and minimize environmental impact.</li>
        <li> <b>Circular Economy Practices:</b> Embrace circular economy principles by designing products for reuse, recycling, and remanufacturing. By closing the loop on materials and reducing waste, suppliers can create value from discarded resources and contribute to a more sustainable future.</li>
        <li> <b>Collaborative Partnerships:</b> Collaborate with customers, industry partners, and sustainability experts to drive innovation and share best practices. By fostering collaborative partnerships, suppliers can leverage collective expertise to address sustainability challenges and identify opportunities for improvement.</li>
        <li> <b>Stakeholder Engagement:</b> Engage with stakeholders including employees, customers, communities, and investors to communicate sustainability goals and initiatives. By involving stakeholders in the sustainability journey, suppliers can build support, inspire action, and enhance brand credibility.</li>
        <li> <b>Continuous Improvement:</b> Implement a culture of continuous improvement by setting targets, measuring performance, and implementing feedback loops. By continuously striving for improvement, suppliers can adapt to evolving sustainability challenges and drive long-term value creation.</li>
        </ol>
        <p>By embracing sustainability in supplier operations, businesses can not only mitigate environmental risks but also unlock opportunities for innovation, differentiation, and long-term growth. By integrating environmental responsibility into their core business strategies, suppliers can create shared value for society, the environment, and their bottom line.</p>
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
                $dbOrders=mysqli_query($con,"SELECT * from placed_order where sellerID='$userid'");
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
            document.getElementById("frm").submit();
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

        function addCategory() {
            if(document.getElementById('addbtn').innerHTML=="Add Category"){
        const container = document.getElementById('categoryContainer');
        const newCategory = document.createElement('div');
        newCategory.innerHTML = `
            <label for="cost">Category Name:</label>
            <input type="text" id="categoryName" required>
            <button type="button" onclick="removeCategory(this)">Discard</button>
        `;
        container.appendChild(newCategory);
        document.getElementById('addbtn').innerHTML="Save Category";
        }
        else{
            if(document.getElementById('categoryName').value==""){
                alert("Make sure to provide the category name.");
            }
            else{
                catName=document.getElementById('categoryName').value;
                catalogID=<?php echo $catalogID;?> 
                url="addCat.php?catName="+catName+"&catalogID="+catalogID;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
                window.location.reload();
            }
        }
    }

    function removeCategory(button) {
        const container = document.getElementById('categoryContainer');
        container.removeChild(button.parentNode);
        document.getElementById('addbtn').innerHTML="Add Category";
    }

    function editCategory(catID){
        url="editcategory.php?catID="+catID;
        window.location.href=url;
    }
    </script>
</body>
</html>