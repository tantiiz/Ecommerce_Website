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
        $count = 0;
        echo '<div class="row">';
        while ($row = $search_result->fetch_assoc()) {
            if ($count % 4 == 0 && $count != 0) {
                echo '</div>';
                echo '<div class="row">';
            }
            echo "
                <div class='col-md-3 itemlistp'>
                    <a href='productview.php?id=" . $row['prod_id'] . "'>
                        <img src='" . $row['prod_img'] . "' alt='prod_img'>
                        <h5>" . $row['prod_name'] . "</h5>
                        <p class='itemcat'>" . $row['prod_category'] . "</p>
                        <p class='price'>₱" . $row['prod_price'] . ".00</p>
                    </a>
                </div>
            ";
            $count++;
        }
        echo "</div>";
    } else {
        echo "<br>No matching products found.";
    }
} else {
    // If search term is empty, display all products
    $sql = "SELECT `prod_id`, `prod_name`, `prod_price`, `prod_category`, `prod_img` FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $count = 0;
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            if ($count % 4 == 0 && $count != 0) {
                echo '</div>';
                echo '<div class="row">';
            }
            echo "
                <div class='col-md-3 itemlistp'>
                    <a href='productview.php?id=" . $row['prod_id'] . "'>
                        <img src='" . $row['prod_img'] . "' alt='prod_img'>
                        <h5>" . $row['prod_name'] . "</h5>
                        <p class='itemcat'>" . $row['prod_category'] . "</p>
                        <p class='price'>₱" . $row['prod_price'] . ".00</p>
                    </a>
                </div>
            ";
            $count++;
        }
        echo "</div>";
    } else {
        echo "<br>No products found.";
    }
}

$conn->close();
?>
