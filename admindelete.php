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

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM products WHERE prod_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Product deleted successfully";
    } else {
        $_SESSION['message'] = "Error deleting product: " . $conn->error;
    }
    
    $stmt->close();
}

// Redirect back to the admin page after deletion
header("Location: adminpage.php");
exit;
?>
