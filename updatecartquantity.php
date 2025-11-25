<?php
session_start();
date_default_timezone_set('Asia/Manila');

$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecomfinal";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function respondAndExit($isAjax, $response) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if ($response['success']) {
        header("Location: cartpageSIGNED.php");
    } else {
        header("Location: cartpageSIGNED.php?error=quantity");
    }
    exit();
}

$response = [
    'success' => false,
    'line_total' => 0,
    'quantity' => 0,
    'message' => ''
];

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'], $_POST['quantity'])) {
    if (!isset($_COOKIE['user_name'])) {
        if ($isAjax) {
            $response['message'] = 'Please sign in to update your cart.';
            respondAndExit(true, $response);
        } else {
            header("Location: signin.html");
            exit();
        }
    }

    $cart_id = (int) $_POST['cart_id'];
    $quantity = max(1, (int) $_POST['quantity']);
    $user_name = $conn->real_escape_string($_COOKIE['user_name']);

    $user_sql = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $user_result = $conn->query($user_sql);

    if ($user_result && $user_result->num_rows > 0) {
        $user_id = $user_result->fetch_assoc()['user_id'];

        $cart_sql = "SELECT cart.prod_id, products.prod_price FROM cart INNER JOIN products ON cart.prod_id = products.prod_id WHERE cart.cart_id = $cart_id AND cart.user_id = $user_id";
        $cart_result = $conn->query($cart_sql);

        if ($cart_result && $cart_result->num_rows > 0) {
            $cart_row = $cart_result->fetch_assoc();
            $prod_price = $cart_row['prod_price'];
            $new_total = $prod_price * $quantity;

            $update_sql = "UPDATE cart SET quantity = $quantity, total = $new_total WHERE cart_id = $cart_id AND user_id = $user_id";
            if ($conn->query($update_sql) === true) {
                $response['success'] = true;
                $response['line_total'] = number_format($new_total, 2, '.', '');
                $response['quantity'] = $quantity;
            } else {
                $response['message'] = 'Failed to update cart item.';
            }
        } else {
            $response['message'] = 'Cart item not found.';
        }
    } else {
        $response['message'] = 'User not found.';
    }
} else {
    $response['message'] = 'Invalid request.';
}

$conn->close();
respondAndExit($isAjax, $response);
?>

