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

$search_term = isset($_GET['q']) ? $_GET['q'] : '';

if (!empty($search_term)) {
    $search_sql = "SELECT `prod_id`, `prod_name`, `prod_price`, `prod_category`, `prod_img` FROM products WHERE `prod_name` LIKE '%$search_term%' OR `prod_category` LIKE '%$search_term%'";
    $search_result = $conn->query($search_sql);

    if ($search_result !== false && $search_result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>";
                
        while ($row = $search_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['prod_id'] . "</td>";
            echo "<td>" . $row['prod_name'] . "</td>";
            echo "<td>₱" . $row['prod_price'] . ".00</td>";
            echo "<td>" . $row['prod_category'] . "</td>";
            echo "<td><img src='" . $row['prod_img'] . "' width='100' height='100' /></td>";
            echo "<td><a href='edit_product.php?id=" . $row['prod_id'] . "'>Edit</a> | <a href='delete_product.php?id=" . $row['prod_id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<br>No matching products found.";
    }
} else {
    // If search term is empty, display all products
    $sql = "SELECT `prod_id`, `prod_name`, `prod_price`, `prod_category`, `prod_img` FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>";
                
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['prod_id'] . "</td>";
            echo "<td>" . $row['prod_name'] . "</td>";
            echo "<td>₱" . $row['prod_price'] . ".00</td>";
            echo "<td>" . $row['prod_category'] . "</td>";
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['prod_img']) . "' width='100' height='100' /></td>";
            echo "<td><a href='edit_product.php?id=" . $row['prod_id'] . "'>Edit</a> | <a href='delete_product.php?id=" . $row['prod_id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
    } else {
        echo "<br>No products found.";
    }
}

$conn->close();
?>
