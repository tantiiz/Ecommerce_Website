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
$sql = "SELECT `prod_id`, `prod_name`, `prod_price`, `prod_category`, `prod_img` FROM products";

// Handle category filtering
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $sql .= " WHERE `prod_category` = '$category'";
}

// Handle sorting
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'lth':
            $sql .= " ORDER BY `prod_price` ASC";
            break;
        case 'htl':
            $sql .= " ORDER BY `prod_price` DESC";
            break;
        case 'latest':
            $sql .= " ORDER BY `prod_id` DESC";
            break;
    }
}

// Add ORDER BY RAND() if no category filter is applied
// if (!isset($_GET['category'])) {
//     $sql .= " ORDER BY RAND()";
// }

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSCS-2A Store</title>
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
                        <a class="nav-link" href="#">PRODUCTS</a>
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

    <div class="container initialitem">

        <div class="row">
            <div class="col-md-3">

                <!-- Search form -->
                <form>
                    <label for="search">Search by Product Name</label>
                    <input type="text" class="search" name="search" placeholder="Search here" id="searchInput" onkeyup="liveSearch()" required>
                </form>

                <div class="cat">
                    <div class="catlist">
                        <h4>Category</h4>
                        <a href="productpageSIGNED.php">All</a>
                        <a href="productpageSIGNED.php?category=Solo Leveling">Solo Leveling</a>
                        <a href="productpageSIGNED.php?category=Naruto">Naruto</a>
                        <a href="productpageSIGNED.php?category=One Piece">One Piece</a>
                        <a href="productpageSIGNED.php?category=Dragon Ball">Dragon Ball</a>
                        <a href="productpageSIGNED.php?category=Jujutsu Kaisen">Jujutsu Kaisen</a>
                        <a href="productpageSIGNED.php?category=Demon Slayer">Demon Slayer</a>
                        <a href="productpageSIGNED.php?category=Others">Others</a>
                    </div>
                    <div class="catlist">
                        <h4>Sort By</h4>
                        <a href="productpageSIGNED.php?sort=lth">Lowest to Highest Price</a>
                        <a href="productpageSIGNED.php?sort=htl">Highest to Lowest Price</a>
                        <a href="productpageSIGNED.php?sort=latest">Latest Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="initialitemp" id="livesearch">
                    <?php
                    if ($result->num_rows > 0) {
                        $count = 0;
                        echo '<div class="row">';
                        while ($row = $result->fetch_assoc()) {
                            if ($count % 4 == 0 && $count != 0) {
                                echo '</div>';
                                echo '<div class="row">';
                            }
                            echo "
                                    <div class='col-md-3 itemlistp'>
                                        <a href='productview.php?id=" . $row['prod_id'] . "'>
                                            <img src='" . $row['prod_img'] . "' alt='prod_img'>
                                            <h5>" . $row['prod_name'] . "</h5>
                                            <p class='itemcat'>" . $row['prod_category'] . "</p>
                                            <p class='price'>₱" . $row['prod_price'] . ".00</p>
                                        </a>
                                    </div>
                                ";
                            $count++;
                        }
                        echo '</div>';
                    }
                    ?>
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

    <script>
        function liveSearch() {
            var input = document.getElementById("searchInput").value;
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("livesearch").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "live_search.php?q=" + input, true);
            xmlhttp.send();
        }
    </script>
</body>

</html>