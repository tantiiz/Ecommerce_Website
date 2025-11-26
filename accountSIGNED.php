<?php
session_start();
date_default_timezone_set('Asia/Manila');

$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecomfinal";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details from the database
$user_name = $_COOKIE['user_name'];
$user_details_query = "SELECT * FROM user WHERE user_name = '$user_name'";
$user_details_result = $conn->query($user_details_query);

if ($user_details_result->num_rows > 0) {
    $user_details_row = $user_details_result->fetch_assoc();
} else {
    echo "User not found";
    exit; // Stop further execution if user is not found
}

// Fetch checkout details from the database
$checkout_query = "SELECT * FROM checkout WHERE user_id = '{$user_details_row['user_id']}' ORDER BY `checkout_id` DESC";
$checkout_result = $conn->query($checkout_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="account.css">
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
                        <a class="nav-link" href="contactpageSIGNED.php">CONTACT</a>
                    </li>
                    <li class="nav-item" style="text-align: center;">
                        <a class="nav-link" href="#">
                            <img src="Pics/profile.png" alt="profile" style="width:20px;">
                            <?php echo '<h6 style="margin:0px; color:white; font-size:10px;">' . $_COOKIE['user_name'] . "</h6>"; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="account container">
        <div class="welacc row">
            <div class="col-md-10">
                <h1>Welcome, <?php echo $_COOKIE['user_name']; ?>!</h1>
            </div>
            <div class="logout col-md-2">
                <a href="logout.html"><img src="Pics/logout.png" alt="logout">Logout</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d row">
                    <h4 class="card-title">User Details </h4>
                    <a href="accountedit.php"><img src="Pics/edit.png" alt="edit"></a>
                </div>

                <p><strong>User ID :</strong> <?php echo $user_details_row['user_id']; ?></p>
                <p><strong>Name :</strong> <?php echo $_COOKIE['user_name']; ?></p>
                <p><strong>Phone Number :</strong> <?php echo $user_details_row['phone_number']; ?></p>
                <p><strong>Email :</strong> <?php echo $user_details_row['user_email']; ?></p>
                <p><strong>Address :</strong> <?php echo $user_details_row['user_address']; ?></p>
            </div>
        </div>


        <div class="toreceive">
            <div>
                <h4>Received Orders</h4>
                <div class="row">
                    <?php while ($checkout_row = $checkout_result->fetch_assoc()) : ?>
                        <?php
                        // Fetch product details for each checkout item
                        $product_id = $checkout_row['prod_id'];
                        $product_query = "SELECT * FROM products WHERE prod_id = $product_id";
                        $product_result = $conn->query($product_query);
                        $product_row = $product_result->fetch_assoc();

                        // Check if a rating has been submitted for this checkout item
                        $rating_query = "SELECT * FROM rating WHERE checkout_id = '{$checkout_row['checkout_id']}'";
                        $rating_result = $conn->query($rating_query);
                        ?>
                        <div class="col-md-2">
                            <div class="card mb-3">
                                <?php if ($rating_result->num_rows > 0) : ?>
                                    <p class="completed" style="text-align:center;">COMPLETED</p>
                                <?php else : ?>
                                    <?php if ($checkout_row['status'] == 'Delivered') : ?>
                                        <a href='rating_form.php?checkout_id=<?php echo $checkout_row['checkout_id']; ?>'>
                                            <button class="rate btn-primary">To Rate</button>
                                        </a>
                                    <?php else : ?>
                                        <p class="status"><?php echo $checkout_row['status']; ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <a style="color:black; text-decoration:none;" href="<?php echo 'productview.php?id=' . $product_id; ?>">
                                    <img src="<?php echo $product_row['prod_img']; ?>" class="card-img-top" alt="prod_img">
                                    <div class="card-body">
                                        <p class="prodname"><?php echo $product_row['prod_name']; ?></p>
                                        <p class="price">₱<?php echo $product_row['prod_price']; ?>.00</p>
                                    </div>
                                </a>

                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
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