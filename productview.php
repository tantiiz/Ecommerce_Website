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

// Check if product ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Retrieve product details based on the provided product ID
    $sql = "SELECT * FROM products WHERE prod_id = $product_id";
    $result = $conn->query($sql);

    // $sql1 = "SELECT `prod_id`, `prod_name`, `prod_price`, `prod_category`, `prod_img` FROM products";
    // $result1 = $conn->query($sql1);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prod_name = $row['prod_name'];
        $prod_price = $row['prod_price'];
        $prod_category = $row['prod_category'];
        $prod_img = $row['prod_img'];
        $prod_details = $row['prod_details'];
    } else {
        echo "Product not found";
    }
} else {
    echo "Product ID not provided";
}

$flash_message = '';
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $prod_name; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...YOUR_SHA512_HASH_HERE..." crossorigin="anonymous" />
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.min.css">
    <link rel="stylesheet" href="prodview.css">
    <style>
        .flash-message {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1050;
            min-width: 250px;
        }
    </style>
</head>

<body>
    <?php if (!empty($flash_message)) : ?>
        <div class="alert alert-success alert-dismissible fade show flash-message" role="alert">
            <?php echo htmlspecialchars($flash_message); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
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
                        <a class="nav-link" href="accountSIGNED.php">
                            <img src="Pics/profile.png" alt="profile" style="width:20px;">
                            <?php echo '<h6 style="margin:0px; color:white; font-size:10px;">' . $_COOKIE['user_name'] . "</h6>"; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <a onclick="goBack()" href="#" class="backbtn"><img class="backbtn" src="Pics/return.png" alt="back"> Back</a>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <div class="prodview container">
        <div class="row">
            <div class="col-md-4">
                <img src='<?php echo $prod_img; ?>' alt='prod_img'>
            </div>
            <div class="col-md-8">
                <h2><?php echo $prod_name; ?></h2>
                <p class="category"><?php echo $prod_category; ?></p>
                <p class="price">₱<?php echo $prod_price; ?>.00</p>
                <!-- Add to cart and buy now buttons -->
                <div class="action row">
                    <div class="mr-2">
                        <form action="addtocart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="submit" value="Add to Cart" name="add_to_cart" class="cartbtn" />

                        </form>
                    </div>
                    <div>
                        <form action="buynowpage.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="submit" value="Buy Now" class="buybtn" />
                        </form>
                    </div>
                </div>


            </div>
        </div>
        <div class="proddetails">
            <h3>Product Specifications</h3>
            <p><?php echo $prod_details; ?></p>
        </div>

        <!-- All Product Reviews Section -->
        <h3 style="margin-top: 50px;">All Product Reviews</h3>
        <div class="all-reviews">
            <?php
            // Fetch all product reviews along with usernames from the database
            $reviews_query = "SELECT rating.*, user.user_name 
                            FROM rating 
                            INNER JOIN user ON rating.user_id = user.user_id 
                            WHERE rating.prod_id = $product_id";
            $reviews_result = $conn->query($reviews_query);
            if ($reviews_result->num_rows > 0) {
                while ($review_row = $reviews_result->fetch_assoc()) {
                    echo "<div class='review'>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-2'>";
                    // Display image if available
                    if (!empty($review_row['image'])) {
                        echo "<img style='width:100%;' src='" . $review_row['image'] . "' alt='Review Image'>";
                    } else {
                        echo "<p style='font-size: 12px; text-align:center;'>No image uploaded.</p>";
                    }
                    echo "</div>";
                    echo "<div class='col-md-10'>";
                    echo "<p><strong>User Name:</strong> " . $review_row['user_name'] . "</p>";
                    echo "<p><strong>Rating:</strong> ";
                    // Convert rating to star icons
                    $rating = $review_row['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo "<i class='fas fa-star'></i>"; // Full star
                        } else {
                            echo "<i class='far fa-star'></i>"; // Empty star
                        }
                    }
                    echo "</p>";
                    echo "<p><strong>Comments:</strong> " . $review_row['comments'] . "</p>";
                    echo "</div>";

                    echo "</div>";


                    echo "</div>";
                }
            } else {
                echo "<p>No reviews yet for this product.</p>";
            }
            ?>
        </div>

        <h3 style="font-size:20px; margin-top:50px;">Related Products</h3>
        <div class="row">
            <?php
            // Fetch related products (excluding the current product being viewed)
            $sql_related = "SELECT `prod_id`, `prod_name`, `prod_price`, `prod_category`, `prod_img` FROM products WHERE prod_id != $product_id  AND prod_category = '$prod_category' ORDER BY RAND()";
            $result_related = $conn->query($sql_related);
            if ($result_related->num_rows > 0) {
                $count = 0;
                while ($row_related = $result_related->fetch_assoc()) {
                    if ($count < 5) {
                        echo "
                            <div class='col-md-2 itemlistp'>
                                <a href='productview.php?id=" . $row_related['prod_id'] . "'>
                                    <img src='" . $row_related['prod_img'] . "' alt='prod_img'>
                                    <h5>" . $row_related['prod_name'] . "</h5>
                                    <p class='itemcat'>" . $row_related['prod_category'] . "</p>
                                    <p style='font-size:18px; color:red;'>₱" . $row_related['prod_price'] . ".00</p>
                                </a>
                                
                            </div>
                        ";
                        $count++; // Increment counter
                    } else {
                        break; // Exit loop once 5 items are displayed
                    }
                }
            } else {
                echo "No related products found";
            }
            echo "<div style='display: flex; justify-content: center; align-items: center; '>"; // Parent container with flexbox
            echo "<a href='productpageSIGNED.php' style='text-align: center; color: black; margin-left: 30px; font-size: 14px'>Show More</a>>>"; // Centered link
            echo "</div>";
            ?>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var flash = document.querySelector(".flash-message");
            if (flash) {
                setTimeout(function() {
                    flash.classList.remove("show");
                    flash.addEventListener("transitionend", function() {
                        if (flash && flash.parentNode) {
                            flash.parentNode.removeChild(flash);
                        }
                    });
                    setTimeout(function() {
                        if (flash && flash.parentNode) {
                            flash.parentNode.removeChild(flash);
                        }
                    }, 600);
                }, 2500);
            }
        });
    </script>

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