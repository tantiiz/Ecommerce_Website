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

// Fetch orders with username and product name
$sql = "SELECT checkout.checkout_id, user.user_name, products.prod_name, checkout.quantity, checkout.total_price, checkout.checkout_date, checkout.payment_method, checkout.address, checkout.status
        FROM checkout 
        INNER JOIN user ON checkout.user_id = user.user_id
        INNER JOIN products ON checkout.prod_id = products.prod_id ORDER BY checkout.checkout_id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <a onclick="goBack()" href="#" class="backbtn"><img class="backbtn" src="Pics/return.png" alt="back"> Back</a>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <div class="orders">
        <h1>Orders</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Checkout Date</th>
                    <th>Payment Method</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='uname'>" . $row['user_name'] . "</td>";
                        echo "<td>" . $row['prod_name'] . "</td>";
                        echo "<td>" . $row['quantity'] . "pc/s</td>";
                        echo "<td>₱" . $row['total_price'] . ".00</td>";
                        echo "<td>" . $row['checkout_date'] . "</td>";
                        echo "<td>" . $row['payment_method'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td class='abtn'>";
                        if ($row['status'] == 'Shipped Out') {
                            echo "<button class='b delivered' data-checkout-id='" . $row['checkout_id'] . "' onclick='orderDelivered(" . $row['checkout_id'] . ")'>Order Delivered</button>";
                        } else if ($row['status'] == 'Delivered') {
                            echo "<span class='complete'>COMPLETED</span>";

                        } else {
                            echo "<button class='b shipout' data-checkout-id='" . $row['checkout_id'] . "' onclick='shipOut(" . $row['checkout_id'] . ")'>Ship Out</button>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function shipOut(checkoutId) {
        $.ajax({
            type: "POST",
            url: "update_ship_out.php",
            data: { checkout_id: checkoutId },
            success: function(response) {
                console.log(response);
                // Update the UI or perform any additional actions upon successful update
                $(".shipout[data-checkout-id='" + checkoutId + "']").remove(); // Remove the "Ship Out" button
                setTimeout(function() {
                        location.reload();
                    }, 100);
            }
        });
    }

    function orderDelivered(checkoutId) {
        $.ajax({
            type: "POST",
            url: "update_order_delivered.php",
            data: { checkout_id: checkoutId },
            success: function(response) {
                console.log(response);
                // Update the UI or perform any additional actions upon successful update
                $(".delivered[data-checkout-id='" + checkoutId + "']").remove(); // Remove the "Order Delivered" button
                setTimeout(function() {
                        location.reload();
                    }, 100);
            }
        });
    }
</script>
</body>

</html>
