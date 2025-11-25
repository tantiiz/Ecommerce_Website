<?php
session_start();

date_default_timezone_set('Asia/Manila');

$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecomfinal";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all statuses for all users excluding the currently logged-in user
$sql = "SELECT `prod_name`, `prod_price`, `prod_category`, `prod_img` FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSCS- 2A Store</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="homepageSIGNED.php"><img class="logo" src="Pics/logo2.png" alt="logo"></a>

            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homepageSIGNED.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productpageSIGNED.php">PRODUCTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cartpageSIGNED.php">CART</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">CONTACT</a>
                    </li>
                    <li class="nav-item" style="text-align: center;">
                        <a class="nav-link" href="accountSIGNED.php">
                            <img src="Pics/profile.png" alt="profile" style="width:20px;">
                            <?php echo '<h6 style="margin:0px; color:white; font-size:10px;">' . $_COOKIE['user_name'] . "</h6>"; ?>
                        </a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container contact">
        <div class="row">
            <!-- Left Column for Shop Details -->
            <div class="col-md-7">
                <h1>About Our Shop</h1>
                <p>Our collection of action figures features iconic characters from beloved anime series, bringing the vibrant worlds of our favorite shows to life.</p>
                <h2 class="sub">Contact Details</h2>
                <ul class="detailsc">
                    <li><img src="Pics/location.png" alt="loc"> Bacarra, Ilocos Norte</li>
                    <li><img src="Pics/call.png" alt="pnum"> +63 951 7225 174</li>
                    <li><img src="Pics/email.png" alt="emal"> jarrenaceret1518gmail.com</li>
                    <li><img src="Pics/location.png" alt="loc"> San Nicolas, Ilocos Norte</li>
                    <li><img src="Pics/call.png" alt="pnum"> +63 928 739 0651</li>
                    <li><img src="Pics/email.png" alt="emal"> dejesushansdainielatangan@gmail.com</li>
                </ul>
                <h2 class="sub">Follow Us</h2>
                <ul class="socialmed">
                    <li class="list-inline-item"><a href="https://www.facebook.com/jarrenskie15/" target="_blank"><img src="Pics/facebook.png" alt="Facebook"></a></li>
                    <li class="list-inline-item"><a href="https://www.facebook.com/hansdanielle.dejesus" target="_blank"><img src="Pics/facebook.png" alt="Facebook"></a></li>
               
                </ul>
            </div>

            <!-- Right Column for Contact Form -->
            <div class="col-md-5 form">
                <h2>Contact Us</h2>
                <hr style="margin: 0px; margin-bottom: 20px;">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Enter your message"></textarea>
                    </div>
                    <button type="submit" class="btnf btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <footer class='footer'>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="homepageSIGNED.php"><img src="Pics/logo2.png" alt="Your Logo"></a>
                    <p>Unlock the power of your favorite characters with our exclusive anime action figures. Immerse
                        yourself in the world of epic battles and heroic adventures. Collect them all and let your
                        imagination soar!</p>
                </div>
            </div>
            <hr>
            <p class="c">© 2024 Your Company. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>