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

// Check if product ID is provided in the URL
if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Retrieve product details based on the provided product ID
    $sql = "SELECT * FROM products WHERE prod_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prod_name = $row['prod_name'];
        $prod_price = $row['prod_price'];
        $prod_img = $row['prod_img'];
    } else {
        echo "Product not found";
        exit; // Stop further execution if product is not found
    }
} else {
    echo "Product ID not provided";
    exit; // Stop further execution if product ID is not provided
}

// Fetch user address from the database
$user_name = $_COOKIE['user_name'];
$user_address_query = "SELECT user_address FROM user WHERE user_name = '$user_name'";
$user_address_result = $conn->query($user_address_query);
$user_address_row = $user_address_result->fetch_assoc();
$user_address = $user_address_row['user_address'];

// Get the current date and time
$currentDateTime = date('m-d-Y | H:i A');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - <?php echo $prod_name; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="checkout.css">
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

    <div class="checkout container">
        <h1>Checkout</h1>
        <div class="row" style='height: 110px;'>
            <div class='col-6'>
                <label for='paymentMethod' class='col-form-label'>Payment Method</label>
                <select class='form-control' id='paymentMethod'>
                    <option value=''>Select a method</option>
                    <option value='Cash on Delivery'>Cash on Delivery</option>
                    <option value='GCash'>GCash</option>
                    <option value='Paymaya'>PayMaya</option>
                </select>

            </div>
            <div class='col-6 coloc'>
                <p class='coloc'><img src='Pics/location-pin.png' alt='loc'> <?php echo $user_address; ?> </p>
                <p class='coloc time'> <?php echo $currentDateTime; ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 item-image">
                <img src='<?php echo $prod_img; ?>' alt='prod_img'>
            </div>
            <div class='col-md-10 item-details'>
                <p class='item-name'><?php echo $prod_name; ?></p>
                <div class="quantity-control">
                    <label for="quantityInput">Quantity</label>
                    <input type="number" id="quantityInput" min="1" value="1">
                </div>
                <p class="item-price">₱<?php echo number_format($prod_price, 2); ?> each</p>
                <p class="item-price" id="lineTotal">Total: ₱<?php echo number_format($prod_price, 2); ?></p>
                <form method="post" action="placeorder.php">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="hidden" name="quantity" id="placeOrderQuantity" value="1">
                </form>
            </div>
        </div>
    </div>

    <!-- Sticky footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p>Total Amount: <b class='totalcheckout'>₱<?php echo number_format($prod_price, 2); ?></b></p>
                </div>
                <div class='col-md-4 text-right'>
                    <form id="checkoutForm" method="post" action="buynowpo.php">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="quantity" id="quantityField" value="1">
                        <input type="hidden" name="paymentMethod" value="" id="paymentMethodField">
                        <button type="submit" onclick="submitForm()" class="po btn btn-primary btn-block">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    var basePrice = <?php echo (float) $prod_price; ?>;
    var quantityInput = document.getElementById("quantityInput");
    var lineTotal = document.getElementById("lineTotal");
    var footerTotal = document.querySelector(".totalcheckout");

    function formatCurrency(amount) {
        return "₱" + amount.toFixed(2);
    }

    function syncQuantityFields(quantity) {
        document.getElementById("quantityField").value = quantity;
        document.getElementById("placeOrderQuantity").value = quantity;
    }

    function updateTotals() {
        var quantity = parseInt(quantityInput.value, 10);
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
        }
        quantityInput.value = quantity;
        var total = basePrice * quantity;
        lineTotal.textContent = "Total: " + formatCurrency(total);
        footerTotal.textContent = formatCurrency(total);
        syncQuantityFields(quantity);
    }

    quantityInput.addEventListener("change", updateTotals);
    quantityInput.addEventListener("keyup", updateTotals);
    updateTotals();

    function submitForm() {
        var paymentMethod = document.getElementById("paymentMethod").value;
        document.getElementById("paymentMethodField").value = paymentMethod;
        updateTotals();
        document.getElementById("checkoutForm").submit();
    }
</script>

</html>