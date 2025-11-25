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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $prod_details = $_POST['prod_details'];
    $prod_category = $_POST['prod_category'];

    if($_FILES["prod_img"]["error"] == 4){
        echo "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["prod_img"]["name"];
        $fileSize = $_FILES["prod_img"]["size"];
        $tmpName = $_FILES["prod_img"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if ( !in_array($imageExtension, $validImageExtension) ){
            echo "<script> alert('Invalid Image Extension'); </script>";
        } else if($fileSize > 1000000){
            echo "<script> alert('Image Size Is Too Large'); </script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, 'Pics/' . $newImageName);
            // Insert product into database
            $sql = "INSERT INTO products (`prod_name`, `prod_price`, `prod_category`, `prod_details`, `prod_img`) 
                    VALUES ('$prod_name', '$prod_price', '$prod_category', '$prod_details', 'Pics/$newImageName')";

            if ($conn->query($sql) === TRUE) {
                // Product added successfully
                header("Location: adminpage.php");
                exit();
            } else {
                // Error adding product
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css"> 
</head>

<body>
    <div class="container">
        <a onclick="goBack()" href="#" class="backbtn"><img class="backbtn" src="Pics/return.png" alt="back"> Back</a>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>

        

        <div class="addprod">
            <h1>Add New Product</h1>
            <div class="col-md-12">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prod_name">Product Name</label>
                        <input type="text" class="form-control" id="prod_name" name="prod_name" required>
                    </div>

                    <div class="form-group">
                        <label for="prod_details">Details</label>
                        <textarea class="form-control" id="prod_details" name="prod_details" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="prod_price">Price</label>
                        <input type="number" class="form-control" id="prod_price" name="prod_price" min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="prod_category">Category</label>
                        <select class="form-control" id="prod_category" name="prod_category" required>
                            <option value="">-- Select Category --</option>
                            <option value="Solo Leveling">Solo Leveling</option>
                            <option value="Naruto">Naruto</option>
                            <option value="One Piece">One Piece</option>
                            <option value="Dragon Ball">Dragon Ball</option>
                            <option value="Jujutsu Kaisen">Jujutsu Kaisen</option>
                            <option value="Demon Slayer">Demon Slayer</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prod_img">Product Image</label>
                        <input type="file" class="form-control-file" id="prod_img" name="prod_img" accept=".jpg, .png, .jpeg" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

