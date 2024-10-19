<?php
session_start();
include "config.php";

$error=''; 
extract($_POST);
if(isset($submit)){
	if ((empty($_POST['username']) && empty($_POST['email'])) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
	}else{
		$username=$_POST['username'];
		$password=$_POST['password'];		
		// To protect MySQL injection for Security purpose
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$password = mysqli_real_escape_string($con, $_POST['password']);
		$sql = mysqli_query($con, "SELECT * FROM user WHERE Username='".$username."' OR Email='".$username."'");
		$res=mysqli_fetch_array($sql);
        if(mysqli_num_rows($sql)==0){
            $error="Username, Email or Password is invalid";
        }
        else{
		if (password_verify($password,$res['Password'])) { 
			$_SESSION['username']=$username; 
            $_SESSION['id']=$res['ID'];
			if ($res['ID'] == 1) {
                $_SESSION['role'] = "admin";
                header("location: adminhome.php"); 
            } else if($res['Role']=="Supplier"){
                $_SESSION['role'] = $res['Role'];
                header("location: supplierhome.php");
            } else if($res['Role']=="Factory"){
                $_SESSION['role'] = $res['Role'];
                header("location: factoryhome.php");
            }else if($res['Role']=="Buyer"){
                $_SESSION['role'] = $res['Role'];
                header("location: buyerhome.php");
            }
		} else {
			$error = "Username, Email or Password is invalid";
		}
    }
		mysqli_close($con); // Closing Connection
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
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
                <li class="active"><a href="login.php">Login</a></li>
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
        <li class="active"><a href="login.php">Login</a></li>
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

<form action="login.php" method="post" class="form-box">
        <div class="register-container" id="register">
            <div class="top">
                <span>Don't have an account? <a href="register.php">Sign Up</a></span>
                <header>Login</header>
            </div>
                    <div class="input-box">
                        <input type="text" name="username" id="" class="input-field" placeholder="Username/Email" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" id="" class="input-field" placeholder="Password" required>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="error"><?php echo $error;?></div>
                    <div class="forgot">
                        <a href="password-reset/forgot-password.php">Forgot Password?</a>
                    </div>
                    <input type="Submit" name="submit" class="submit" value="Submit">
        </div>
    </div>
</body>
</html>