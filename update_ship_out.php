<?php
    session_start();

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

    $checkout_id = $_POST['checkout_id'];

    // Update status to "Shipped Out"
    $sql = "UPDATE checkout SET status = 'Shipped Out' WHERE checkout_id = $checkout_id";

    if ($conn->query($sql) === TRUE) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $conn->close();
?>
