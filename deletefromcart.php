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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cart_id'])) {
    // Get the cart ID to delete
    $cart_id = $_GET['cart_id'];

    // SQL to delete record
    $sql = "DELETE FROM cart WHERE cart_id=$cart_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the cart page
        header("Location: cartpageSIGNED.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
