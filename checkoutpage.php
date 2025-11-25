<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="homepageSIGNED.php"><img class="logo" src="Pics/logo1.png" alt="logo"></a>

            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
    
    <?php
        session_start();
        date_default_timezone_set('Asia/Manila');
        // Establish a database connection
        $host = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "ecomfinal";

        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if any items were selected for checkout
        if(isset($_POST['item_checkbox']) && !empty($_POST['item_checkbox'])) {
            // Retrieve selected item IDs
            $selected_items = $_POST['item_checkbox'];

            // Query to fetch selected items details from the database
            $selected_items_query = "SELECT products.prod_name, products.prod_price, products.prod_img, cart.quantity, cart.total FROM cart INNER JOIN products ON cart.prod_id = products.prod_id WHERE cart.cart_id IN (".implode(",", $selected_items).")";
            
            // Execute the query
            $selected_items_result = $conn->query($selected_items_query);

            $currentDateTime = date('m-d-Y | H:i A');

            // Check if query executed successfully
            if ($selected_items_result) {
                if ($selected_items_result->num_rows > 0) {
    
                    // Fetch user address from the database
                    $user_name = $_COOKIE['user_name'];
                    $user_address_query = "SELECT user_address FROM user WHERE user_name = '$user_name'";
                    $user_address_result = $conn->query($user_address_query);
                    $user_address_row = $user_address_result->fetch_assoc();
                    $user_address = $user_address_row['user_address'];

                    // Display user address
                    echo "<div class='checkout container'>";
                    echo "<h1>Checkout</h1>";
                    echo "<div class='row' style='height: 110px;'>
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
                                <p class='coloc'><img src='Pics/location-pin.png' alt='loc'> " . $user_address . "</p>
                                <p class='coloc time'>" . $currentDateTime . "</p>
                            </div>
                          </div>";

                    // Initialize total amount variable
                    $total_amount = 0;

                    while ($row = $selected_items_result->fetch_assoc()) {
                        echo "<div class='row'>";
                        echo "<div class='col-md-2 item-image'>
                                <img src='" . $row['prod_img'] . "' alt='prod_img'>
                              </div>";
                        echo "<div class='col-md-10 item-details'>";
                        echo "<p class='item-name'>" . $row['prod_name'] . "</p>";
                        echo "<p class='item-price'>₱" . $row['prod_price'] . " x " . $row['quantity'] . "pc/s</p>";
                        echo "<p class='item-total'>Total: ₱" . $row['total'] . ".00</p>";
                        echo "</div>";
                        echo "</div>";

                        // Add each item's total price to the total amount
                        $total_amount += $row['total'];
                    }
                    echo "</div>";

                    // Display the total amount
                    echo "<footer class='footer fixed-bottom'>";
                    echo "<div class='container'>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-8'>";
                    echo "<p>Total Amount : <b class='totalcheckout'>₱" . number_format($total_amount, 2) . "</b></p>";
                    echo "</div>"; ?>
                    
                    <div class='col-md-4 text-right'>
                    <form method="post" action="placeorder.php">
                        <input type="hidden" name="selected_items" value="<?php echo htmlspecialchars(json_encode($selected_items)); ?>">
                        <input type="hidden" name="paymentMethod" value="" id="paymentMethodField">
                        <button type="submit" class="po btn btn-primary btn-block">Place Order</button>
                    </form>
                    </div>

                    <?php echo "</div>";
                    echo "</div>";
                    echo "</footer>";
                } else {
                    echo "<div class='checkout container'><p>No items selected for checkout.</p></div>";
                }
            } else {
                echo "<div class='checkout container'><p>Error fetching selected items details: " . $conn->error . "</p></div>";
            }
        } else {
            echo "<div class='checkout container'><p>No items selected for checkout.</p></div>";
        }

        // Close the database connection
        $conn->close();
    ?>


    <!-- Sticky footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php
                        // Initialize total amount variable
                        $total_amount = 0;

                        // Loop through selected items to calculate total amount
                        if(isset($selected_items_result) && $selected_items_result->num_rows > 0) {
                            while ($row = $selected_items_result->fetch_assoc()) {
                                // Add each item's total price to the total amount
                                $total_amount += $row['total'];
                            }
                        }

                        // Display the total amount
                        echo "<p>Total Amount: ₱" . number_format($total_amount, 2) . "</p>";
                    ?>
                </div>
                <div class="col-md-4">
                    <button class="po btn btn-primary btn-block">Place Order</button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
    // JavaScript function to set the payment method value before form submission
    document.querySelector('#paymentMethod').addEventListener('change', function() {
        document.querySelector('#paymentMethodField').value = this.value;
    });
</script>
</body>
</html>
