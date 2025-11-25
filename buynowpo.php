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
if(isset($_POST['product_id'], $_POST['paymentMethod'])) {
    $product_id = (int) $_POST['product_id'];
    $paymentMethod = $_POST['paymentMethod'];
    $quantity = isset($_POST['quantity']) ? max(1, (int) $_POST['quantity']) : 1;
    $user_name = $_COOKIE['user_name'];

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

    // Retrieve product details
    $product_query = "SELECT prod_price FROM products WHERE prod_id = $product_id";
    $product_result = $conn->query($product_query);

    if ($product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $prod_price = $product_row['prod_price'];

        // Insert checkout details into checkout table
        $total_price = $prod_price * $quantity;

        $insert_query = "INSERT INTO checkout (user_id, prod_id, quantity, total_price, checkout_date, payment_method, address, status) VALUES ('$user_id', '$product_id', $quantity, '$total_price', '$checkout_date', '$paymentMethod', '$user_address', 'Pending')";
        if ($conn->query($insert_query) === TRUE) {
            // Clear the cart or update its status after successful checkout
            $clear_cart_query = "DELETE FROM cart WHERE user_id = '$user_id' AND prod_id = '$product_id'";
            if ($conn->query($clear_cart_query) === TRUE) {
                echo "<script>alert('Checkout successful! Thank you for shopping with us.');</script>";
                echo "<script>window.location.href = 'cartpageSIGNED.php';</script>";
                exit();
            } else {
                echo "Error clearing cart: " . $conn->error;
            }
        } else {
            echo "Error inserting checkout details: " . $conn->error;
        }
    } else {
        echo "Error: Product not found.";
    }
} else {
    // Handle case where data is not received properly
    echo "Error: Checkout details not received.";
}

// Close the database connection
$conn->close();
?>
                                                                                                                                             