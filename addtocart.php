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
if(isset($_COOKIE['user_name'])) {
    // User is logged in, retrieve user ID
    $user_name = $_COOKIE['user_name'];

    // Retrieve user ID from the database
    $sql_user_id = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $result_user_id = $conn->query($sql_user_id);

    if ($result_user_id->num_rows > 0) {
        $row = $result_user_id->fetch_assoc();
        $user_id = $row['user_id'];

        // Check if product ID is provided and add to cart button is clicked
        if(isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
            $product_id = (int) $_POST['product_id'];
            $quantity = 1; // Default quantity is 1

            $product_name = '';
            $price = 0;

            $sql_get_product_details = "SELECT prod_name, prod_price FROM products WHERE prod_id = $product_id";
            $result_product_details = $conn->query($sql_get_product_details);

            if ($result_product_details && $result_product_details->num_rows > 0) {
                $product_row = $result_product_details->fetch_assoc();
                $product_name = $product_row['prod_name'];
                $price = $product_row['prod_price'];
            } else {
                echo "Product not found.";
                exit();
            }
            
            // Check if the product is already in the cart
            $sql_check_cart = "SELECT * FROM cart WHERE user_id = $user_id AND prod_id = $product_id";
            $result_check_cart = $conn->query($sql_check_cart);
            
            if ($result_check_cart->num_rows > 0) {
                // If product is already in the cart, update the quantity
                $row = $result_check_cart->fetch_assoc();
                $new_quantity = $quantity + $row['quantity']; // Calculate the new quantity
                $total = $new_quantity * $price;
                $sql_update_cart = "UPDATE cart SET quantity = $new_quantity, total = $total WHERE user_id = $user_id AND prod_id = $product_id";
                $conn->query($sql_update_cart);
            } else {
                $total = $quantity * $price;
                $sql_insert_cart = "INSERT INTO cart (user_id, prod_id, prod_name, quantity, total) VALUES ($user_id, $product_id, '$product_name', $quantity, $total)";
                $conn->query($sql_insert_cart);
            }
            
            $_SESSION['flash_message'] = "Added {$product_name} to your cart.";
            header("Location: productview.php?id=$product_id");
            exit();
        } else {
            echo "Error: Product ID not provided or add to cart button not clicked.";
        }
    } else {
        echo "User not found";
    }
} else {
    // User is not logged in, redirect to login page or handle accordingly
    header("Location: signin.html");
    exit();
}
?>
