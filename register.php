<?php
session_start();
include "config.php";

$username;
extract($_POST);
$error1='';

// Password complexity check

if (isset($submit)) {
$fname = mysqli_real_escape_string($con, $fname);
$lname = mysqli_real_escape_string($con, $lname);
$email = mysqli_real_escape_string($con, $email);
$country = mysqli_real_escape_string($con, $country);
$password = mysqli_real_escape_string($con, $password);
if (strlen($password) < 8) {
    $error1 = "Password must be at least 8 characters long";
}
else{
    // Check if email is already taken
    $dbE = mysqli_query($con, "SELECT Email FROM user");
    while ($res1 = mysqli_fetch_array($dbE)) {
        if ($res1['Email'] == $email) {
            $error1 = "Email is already taken";
            break;
        }
    }

    if (empty($error1)) {
        // Proceed with user registration
        $username = strtolower($fname . $lname . rand(100, 999));
        $_SESSION['username'] = $username;
        $hashed_pass=password_hash($password,PASSWORD_BCRYPT);
        $dbI = mysqli_query($con, "INSERT INTO user (FirstName, LastName, Username, Email, Password, Country, Role) VALUES ('$fname','$lname','$username','$email','$hashed_pass','$country','$role')") or die();
        $sql = mysqli_query($con, "SELECT * FROM user WHERE Username = '$username'");
        $res = mysqli_fetch_array($sql);
        $_SESSION['id'] = $res['ID'];
        
        // Redirect based on role
        if ($res['ID'] == 1) {
            $_SESSION['role'] = "admin";
            header("location: adminHome.php"); 
        } else if($res['Role'] == "Supplier"){
            $dbIS = mysqli_query($con,"INSERT INTO Supplier (UID, Sales) VALUES ('".$res['ID']."', 0)");
            $dbIC= mysqli_query($con,"INSERT INTO catalog(uID) VALUES ('".$res['ID']."')");
            $_SESSION['role'] = $res['Role'];
            header("location: supplierhome.php");
        } else if($res['Role'] == "Factory"){
            $dbIF = mysqli_query($con,"INSERT INTO Factory (UID, Sales) VALUES ('".$res['ID']."', 0)");
            $dbIW= mysqli_query($con,"INSERT INTO wishlist(uID) VALUES ('".$res['ID']."')");
            $_SESSION['role'] = $res['Role'];
            header("location: factoryhome.php");
        } else if($res['Role'] == "Buyer"){
            $dbIB = mysqli_query($con,"INSERT INTO Buyer (UID) VALUES ('".$res['ID']."')");
            $dbIW= mysqli_query($con,"INSERT INTO wishlist(uID) VALUES ('".$res['ID']."')");
            $_SESSION['role'] = $res['Role'];
            header("location: buyerhome.php");
        }
    }
}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link rel="stylesheet" href="register.css">
    <title>Registration</title>
</head>
<body>
    <div id="nav">
        <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <ul class="links">
                <li><a href="unsignedhome.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
            <a href="register.php" class="action_btn">Get Started</a>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
    <div class="dropdown_menu">
        <div class="links">
        <li><a href="unsignedhome.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="login.php">Login</a></li>
        </div>
        <li><a href="register.php" class="action_btn">Get Started</a></li>
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
    </script>

    <form class="form-box" action="register.php" method="post">
        <div class="register-container" id="register">
            <div class="top">
                <span>Already have an account? <a href="login.php">Login</a></span>
                <header>Sign Up</header>
            </div>
                <div class="two-forms">
                    <div class="input-box">
                        <input type="text" name="fname" id="" class="input-field" placeholder="Firstname" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="lname" id="" class="input-field" placeholder="Lastname" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
                    <div class="input-box">
                        <input type="text" name="email" id="" class="input-field" placeholder="Email" required>
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="country" id="" class="input-field" placeholder="Country" required>
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" id="" class="input-field" placeholder="Password" required>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="two-col">
                        <div class="one">
                            <?php echo $error1;?>
                        </div>
                        <div class="two">
                            <label><a href="https://www.termsandconditionsgenerator.com/live.php?token=4nyrsVwCxlb486FBCaJbfpk6ABjumNrs">Terms & conditions</a></label>
                        </div>
                    </div>
                    <div class="role-box">
                        Select Your Role: 
                        <div><input type="radio" name="role" id="" value="Supplier">  Supplier</div>
                        <div><input type="radio" name="role" id="" value="Factory">  Factory</div>
                        <div><input type="radio" name="role" id="" value="Buyer" checked>  Buyer</div>
                    </div>
                    <input type="Submit" name="submit" class="submit" value="Create Account">
        </div>
    </form>
</body>
</html>