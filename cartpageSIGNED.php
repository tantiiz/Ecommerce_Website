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

// Check if user is logged in
if (isset($_COOKIE['user_name'])) {
    // User is logged in, retrieve user ID
    $user_name = $_COOKIE['user_name'];

    // Retrieve user ID from the database
    $sql_user_id = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $result_user_id = $conn->query($sql_user_id);

    if ($result_user_id->num_rows > 0) {
        $row = $result_user_id->fetch_assoc();
        $user_id = $row['user_id'];

        // Fetch cart items for the logged-in user only
        $sql_cart_items = "SELECT cart.cart_id, products.prod_id, products.prod_name, products.prod_img, products.prod_price, products.prod_category, cart.quantity, cart.total FROM cart INNER JOIN products ON cart.prod_id = products.prod_id WHERE cart.user_id = $user_id";
        $result_cart_items = $conn->query($sql_cart_items);
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cart Page</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="prodview.css">
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

            <div class="cart container">
                <h1>Shopping Cart</h1>
                <form action="checkoutpage.php" method="post"> <!-- Form for submitting selected items to checkout page -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th><a href="#" onclick="selectAllItems(event)">All</a></th>
                                <th colspan='2'> Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_cart_items->num_rows > 0) {
                                while ($row = $result_cart_items->fetch_assoc()) {
                                    echo "<tr>";
                                    echo '<td class="checkbox-cell"><input type="checkbox" name="item_checkbox[]" value="' . $row['cart_id'] . '"></td>';
                                    echo "<td class='prodimg'>
                                <a href='productview.php?id=" . $row['prod_id'] . "'><img src='" . $row['prod_img'] . "' alt='prod_img'></a>
                              </td>";
                                    echo "<td class='prodname'>
                                <a class='pname' href='productview.php?id=" . $row['prod_id'] . "'>" . $row['prod_name'] . "<br></a><p>" . $row['prod_category'] . "</p>
                              </td>";
                                    echo "<td class='unit-price' data-price='" . $row['prod_price'] . "'>₱" . number_format($row['prod_price'], 2) . "</td>";
                                    echo "<td class='qty-cell'>
                                            <input type='number' class='qty-input' min='1' value='" . $row['quantity'] . "' data-cart-id='" . $row['cart_id'] . "' data-price='" . $row['prod_price'] . "' />
                                      </td>";
                                    echo "<td class='total' data-cart-id='" . $row['cart_id'] . "'>₱" . number_format($row['total'], 2) . "</td>";
                                    echo '<td>
                                <a href="deletefromcart.php?cart_id=' . $row['cart_id'] . '" class="dbtn">Delete</a>
                              </td>';
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Your cart is empty</td></tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" id="totalAmount" class="tot text-right">Total: ₱0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="cobtn">
                        <input type="submit" value="Go to Checkout">
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

        <script>
            function formatCurrency(amount) {
                return "₱" + Number(amount).toFixed(2);
            }

            function selectAllItems(event) {
                if (event) {
                    event.preventDefault();
                }
                var checkboxes = document.getElementsByName("item_checkbox[]");
                Array.prototype.forEach.call(checkboxes, function(checkbox) {
                    checkbox.checked = true;
                });
                calculateTotalAmount();
            }

            function calculateTotalAmount() {
                var checkboxes = document.getElementsByName("item_checkbox[]");
                var totalAmount = 0;
                Array.prototype.forEach.call(checkboxes, function(checkbox) {
                    if (checkbox.checked) {
                        var row = checkbox.closest("tr");
                        var amountCell = row.querySelector(".total").textContent;
                        var amount = parseFloat(amountCell.replace(/[^\d.]/g, ""));
                        if (!isNaN(amount)) {
                            totalAmount += amount;
                        }
                    }
                });
                document.getElementById("totalAmount").textContent = "Total: " + formatCurrency(totalAmount);
            }

            function updateLineTotal(cartId, lineTotal) {
                var totalCell = document.querySelector(".total[data-cart-id='" + cartId + "']");
                if (totalCell) {
                    totalCell.textContent = formatCurrency(parseFloat(lineTotal));
                }
            }

            function handleQuantityChange(input) {
                var cartId = input.getAttribute("data-cart-id");
                var quantity = parseInt(input.value, 10);
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    input.value = 1;
                }

                var params = new URLSearchParams();
                params.append("cart_id", cartId);
                params.append("quantity", quantity);

                fetch("updatecartquantity.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: params.toString()
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateLineTotal(cartId, data.line_total);
                            calculateTotalAmount();
                        } else if (data.message) {
                            alert(data.message);
                        } else {
                            alert("Unable to update quantity. Please try again.");
                        }
                    })
                    .catch(() => alert("Network error while updating quantity."));
            }

            function queueQuantityUpdate(input) {
                if (input.updateTimer) {
                    clearTimeout(input.updateTimer);
                }
                input.updateTimer = setTimeout(function() {
                    handleQuantityChange(input);
                }, 300);
            }

            document.addEventListener("DOMContentLoaded", function() {
                var quantityInputs = document.querySelectorAll(".qty-input");
                quantityInputs.forEach(function(input) {
                    input.addEventListener("change", function() {
                        handleQuantityChange(input);
                    });
                    input.addEventListener("input", function() {
                        queueQuantityUpdate(input);
                    });
                });

                var checkboxes = document.getElementsByName("item_checkbox[]");
                Array.prototype.forEach.call(checkboxes, function(checkbox) {
                    checkbox.addEventListener("change", calculateTotalAmount);
                });

                calculateTotalAmount();
            });
        </script>

        </html>
<?php
    } else {
        echo "User not found";
    }
} else {
    // User is not logged in, redirect to login page or handle accordingly
    header("Location: signin.html");
    exit();
}
?>