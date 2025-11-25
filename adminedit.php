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

// Check if product ID is provided
if (!isset($_GET['id'])) {
    die("Product ID not provided");
}

$product_id = $_GET['id'];

// Fetch product details
$sql = "SELECT * FROM products WHERE prod_id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Product not found");
}

$row = $result->fetch_assoc();

// Handle form submission for updating product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Update product in the database without changing the image path
    $update_sql = "UPDATE products SET prod_name = '$name', prod_details = '$details', prod_price = '$price', prod_category = '$category' WHERE prod_id = $product_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Edit Successfully!');</script>";
        echo "<script>window.location.href = 'adminpage.php';</script>";
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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

    <div class="editacc container">
        <h1>Edit Product</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $product_id; ?>">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['prod_name']; ?>">
            </div>
            <div class="form-group">
                <label for="details">Product Details:</label>
                <textarea rows="5" class="form-control" id="details" name="details"><?php echo $row['prod_details']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Product Price:</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['prod_price']; ?>">
            </div>
            <div class="form-group">
                <label for="category">Product Category:</label>
                <select class="form-control" id="category" name="category">
                    <option value="Solo Leveling" <?php if ($row['prod_category'] === 'Solo Leveling') echo 'selected'; ?>>Solo Leveling</option>
                    <option value="Naruto" <?php if ($row['prod_category'] === 'Naruto') echo 'selected'; ?>>Naruto</option>
                    <option value="One Piece" <?php if ($row['prod_category'] === 'One Piece') echo 'selected'; ?>>One Piece</option>
                    <option value="Dragon Ball" <?php if ($row['prod_category'] === 'Dragon Ball') echo 'selected'; ?>>Dragon Ball</option>
                    <option value="Jujutsu Kaisen" <?php if ($row['prod_category'] === 'Jujutsu Kaisen') echo 'selected'; ?>>Jujutsu Kaisen</option>
                    <option value="Demon Slayer" <?php if ($row['prod_category'] === 'Demon Slayer') echo 'selected'; ?>>Demon Slayer</option>
                    <option value="Others" <?php if ($row['prod_category'] === 'Others') echo 'selected'; ?>>Others</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

</body>
</html>
