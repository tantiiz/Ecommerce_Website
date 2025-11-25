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
  <title>BSCS-2A Store</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="main.css">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img class="logo" src="Pics/logo2.png" alt="logo"></a>

      <!-- Toggle Button for Mobile -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="signup.html">PRODUCTS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="signup.html">CART</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactpage.html">CONTACT</a>
          </li>
          <li class="nav-item" style="text-align: center;">
            <a class="nav-link" href="signup.html">
              <img src="Pics/profile.png" alt="profile" style="width:20px;">
              <h6 style="margin:0px; color:white; font-size:10px;">SIGN UP</h6>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="radio-btns" role="radiogroup" style="margin-top: 60px;">
    <div class="radio-btns__btn" role="radio" aria-checked="false" tabindex="-1" aria-label="Select image one">
      <a href="#"><img src="Pics/sololeveling.png" alt="Image description"></a>
    </div>  

    <div class="radio-btns__btn" role="radio" aria-checked="false" tabindex="-1" aria-label="Select image two">
      <a href="#"><img src="Pics/naruto.png" alt="Image description"></a>
    </div>

    <div class="radio-btns__btn" role="radio" aria-checked="false" tabindex="-1" aria-label="Select image three">
      <a href="#"><img src="Pics/onepiece.png" alt="Image description"></a>
    </div>

    <div class="radio-btns__btn" role="radio" aria-checked="false" tabindex="-1" aria-label="Select image three">
      <a href="#"><img src="Pics/dragonball.jpg" alt="Image description"></a>
    </div>

    <div class="radio-btns__btn" role="radio" aria-checked="false" tabindex="-1" aria-label="Select image three">
      <a href="#"><img src="Pics/jujutsukaisen.jpg" alt="Image description"></a>
    </div>
  </div>

  <div class="welcome-message col-md-12">
    <h1>Welcome Otaku!</h1>
    <p>Find your favorite anime characters in action figure!<br>Explore our wide range of high-quality anime action figures.</p>
    <a href="signup.html">Buy Now</a>
  </div>

  <div class="container category">
    <h4>Featured Category</h4>
    <hr>
    <div class="categorylist">
      <a href="signup.html">Solo Leveling</a>
      <a href="signup.html">Naruto</a>
      <a href="signup.html">One Piece</a>
      <a href="signup.html">Dragon Ball</a>
      <a href="signup.html">Jujutsu Kaisen</a>
    </div>
  </div>

  <div class="container initialitem">
    <h4>Products</h4>
    <hr>
    <?php
    if ($result->num_rows > 0) {
      echo "<div class='itemlist'>";
      $count = 0; // Initialize counter
      while ($row = $result->fetch_assoc()) {
        if ($count < 4) { // Check if count is less than 4
          echo "
                  <a href='signup.html'>
                    <img src='" . $row['prod_img'] . "' alt='prod_img'>
                    <h5>" . $row['prod_name'] . "</h5>
                    <p class='itemcat'>" . $row['prod_category'] . "</p>
                    <p class='price'>₱" . $row['prod_price'] . ".00</p>
                  </a>
                ";
          $count++; // Increment counter
        } else {
          break; // Exit loop once 4 items are displayed
        }
      }
      echo "</div>";
    }
    ?>
    <a class="showmore" href="signup.html">
      <p>Show More</p>
    </a>

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