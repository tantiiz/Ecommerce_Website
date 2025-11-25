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

// Retrieve checkout details from POST request
if(isset($_POST['selected_items'], $_POST['paymentMethod'])) {
    $selected_items = json_decode($_POST['selected_items']);
    $paymentMethod = $_POST['paymentMethod'];
    $user_name = $_COOKIE['user_name']; // Assuming user is logged in

    // Retrieve user address from the database
    $user_address_query = "SELECT user_address FROM user WHERE user_name = '$user_name'";
    $user_address_result = $conn->query($user_address_query);
    $user_address_row = $user_address_result->fetch_assoc();
    $user_address = $user_address_row['user_address'];

    // Insert checkout details into database
    $checkout_date = date('Y-m-d H:i:s');
    $user_id_query = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $user_id_result = $conn->query($user_id_query);
    $user_id_row = $user_id_result->fetch_assoc();
    $user_id = $user_id_row['user_id'];

    foreach($selected_items as $item_id) {
        // Retrieve product details from the cart or wherever they're stored
        // Assuming you have a table named 'cart'
        $cart_item_query = "SELECT prod_id, quantity, total FROM cart WHERE cart_id = $item_id";
        $cart_item_result = $conn->query($cart_item_query);
        $cart_item_row = $cart_item_result->fetch_assoc();

        // Insert checkout details into checkout table
        $prod_id = $cart_item_row['prod_id'];
        $quantity = $cart_item_row['quantity'];
        $total_price = $cart_item_row['total'];

        $insert_query = "INSERT INTO checkout (user_id, prod_id, quantity, total_price, checkout_date, payment_method, address, status) VALUES ('$user_id', '$prod_id', '$quantity', '$total_price', '$checkout_date', '$paymentMethod', '$user_address', 'Pending')";
        $conn->query($insert_query);
    }

    // Clear the cart or update its status after successful checkout
    $clear_cart_query = "DELETE FROM cart WHERE cart_id IN (".implode(",", $selected_items).")";
    $conn->query($clear_cart_query);

    echo "<script>alert('Checkout successful! Thank you for shopping with us.');</script>";
    echo "<script>window.location.href = 'cartpageSIGNED.php';</script>";
    exit();
} else {
    // Handle case where data is not received properly
    echo "Error: Checkout details not received.";
}

// Close the database connection
$conn->close();
?>
