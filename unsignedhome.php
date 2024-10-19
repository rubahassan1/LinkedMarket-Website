<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="unsignedhome.css">
</head>
<body>
    <div id="nav">
        <div id="logo">
        <img src="images/logo.png" alt="" id='logo'>
        <h1>Linked<span style="color:#255BB3;">Market</span></h1>
        </div>
        <div id="rightNav">
            <ul class="links">
                <li class="active"><a href="unsignedhome.php">Home</a></li>
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
        <li class="active"><a href="unsignedhome.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="mailto:linked_market@gmail.com">Contact</a></li>
        <li><a href="login.php">Login</a></li>
        </div>
        <li><a href="register.php" class="action_btn">Get Started</a></li>
    </div>
    <div id="head">
        <div id="title">
            <p id="first">Elevate Your Supply Chain Experience: Seamless Solutions for Streamlined Operations</p>
            <p id="second">Where Connections Thrive, Success Unfolds Together</p>
        </div>
        <img src="images/unsignedhomeimage.png" alt="">
    </div>
    <div id="features">
        <h1>Key Features:</h1>
        <div>
            <h3>User Authentication</h3>
            <p>Seamlessly and securely access your account tailored to your role as a supplier, factory representative, or buyer, ensuring personalized interaction and security.</p>
        </div>
        <div>
            <h3>Product Management</h3>
            <p>Effortlessly showcase and manage your products with comprehensive descriptions, images, and pricing, providing an engaging platform for users to explore.</p>
        </div>
        <div>
            <h3>Custom Requests</h3>
            <p>Receive personalized product requests from buyers, enabling tailored solutions to meet their specific requirements and preferences.</p>
        </div>
        <div>
            <h3>Feedback System</h3>
            <p>Gather valuable feedback on your products from buyers to facilitate continuous improvement and enhancement, fostering a collaborative environment.</p>
        </div>
        <div>
            <h3>Transaction Management</h3>
            <p> Effectively oversee transactions within the supply chain network, ensuring smooth communication and streamlined operations for all stakeholders involved.</p>
        </div>
        <div>
            <h3>Connection Management</h3>
            <p>Keep track of your contacts and interactions within the network, fostering collaboration and facilitating seamless transactions.</p>
        </div>
    </div>
    <div id="article">
        <h1>Navigating Success: Mastering Product Flow and Quality</h1>
        <div id="firstcontent">
            <div id="firsttext">
                <p>In today's fast-paced business landscape, mastering the flow and quality of your products is essential for achieving success. Whether you're a supplier, factory, or buyer, understanding how to effectively manage your product flow and maintain high quality is key to staying competitive in the market.</p>
                <p>For suppliers, optimizing product flow means ensuring a seamless process from sourcing raw materials to delivering finished goods to factories. By streamlining supply chain operations and leveraging technology, suppliers can minimize bottlenecks, reduce lead times, and enhance overall efficiency. Additionally, maintaining consistent quality throughout the production process is crucial for building trust with buyers and ensuring long-term success.
            </div>
            <img src="images/productquality.png" alt="" id="firstimg">
        </div>
        <div id="secondcontent">
            <img src="images/Image2.png" alt="" id="secondimg">
            <div id="secondtext">
                <p>Factories play a critical role in product flow and quality by implementing efficient manufacturing processes and stringent quality control measures. By investing in modern technology and automation, factories can increase productivity, minimize defects, and deliver products that meet or exceed customer expectations. Moreover, fostering a culture of continuous improvement and innovation is essential for adapting to changing market demands and staying ahead of the competition.</p>
                <p>For buyers, navigating product flow involves making informed decisions about sourcing, procurement, and inventory management. By collaborating closely with suppliers and factories, buyers can ensure timely delivery of high-quality products while optimizing costs and mitigating risks. Additionally, leveraging data analytics and supply chain visibility tools can provide valuable insights into product availability, pricing trends, and market dynamics.</p>
            </div>
        </div>
        <p>In conclusion, mastering product flow and quality is a journey that requires collaboration, innovation, and continuous improvement. By embracing best practices and leveraging technology, businesses can enhance their competitiveness, drive growth, and achieve sustainable success in today's dynamic marketplace. Let's embark on this journey together and navigate towards success!</p>
        <p>Remember, success isn't just about reaching your destination—it's about the journey you take to get there. So let's embrace the challenges, learn from our experiences, and continue to strive for excellence in everything we do. Together, we can navigate the complexities of product flow and quality and chart a course towards greater success and prosperity.</p>
    </div>
    <div id="signup-container">
        <p style="color:#ffffff; font-weight:bold;">Signup Now!</p>
        <a href="register.php">
            <button>Click here</button>
        </a>

    </div>
    <div id="footer">
        <div id="phone">
            <i class="fa-solid fa-phone"></i>
            +96181211039
        </div>
        <div id="socialmedia">
            <a href="#"><img src="images/instagram.png" alt=""></a>
            <a href="#"><img src="images/facebook.png" alt=""></a>
            <a href="#"><img src="images/linkedin.png" alt="" style="width:50px"></a>
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
    </script>
</body>
</html>