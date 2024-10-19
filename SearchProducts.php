<?php
session_start();
include 'config.php';
$query = $_REQUEST["q"];
$userid;
if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
}

//Maximum 5 rows
$sql = "SELECT * FROM product p, User u, Rates r WHERE p.Name LIKE '%$query%' AND p.U_ID=u.ID AND r.pID=p.pID";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
echo "<div class='products'>";
while ($col = mysqli_fetch_array($result)) {
    echo '<a href=viewproduct.php?pid='.$col['pID'].'>';
    echo '<div class="productcard">';
    echo '<img class="productimage" src="' . $col['Img'] . '">';
    echo '<div class="product-name" id= "prName" name="'.$col['pID'].'">' . $col['Name'] . '</div>';
    $user=mysqli_query($con,"SELECT Username from User where ID='".$col['U_ID']."'");
    echo "<div style='color:black;'>@".mysqli_fetch_assoc($user)['Username']."</div>";
    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>";
    $rate=mysqli_query($con,"SELECT * from rates where pID='".$col['pID']."'");
    $rating=mysqli_fetch_assoc($rate);
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
    echo "<span style='color:black;'>".$col['Price']."$</span><br>";
    echo "<span style='color:";
    if($col['Available']==1){
        echo "green'>In Stock</span>";
    }
    else {
        echo "red'>Out of Stock</span>";
    }
    echo '</div>';
    echo "<a>";
}
echo "</div>";
?>

