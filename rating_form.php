<?php
session_start();
date_default_timezone_set('Asia/Manila');

$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecomfinal";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $rating = $_POST["rating"];
    $comments = $_POST["comments"];
    $checkout_id = $_POST["checkout_id"]; // Retrieve checkout_id from the form

    // Check if image file is uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "Pics/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            exit;
        }
        // Move uploaded file to directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    } else {
        $image_path = null;
    }


    // Fetch prod_id and user_id based on checkout_id
    $checkout_query = "SELECT prod_id, user_id FROM checkout WHERE checkout_id = ?";
    $stmt = $conn->prepare($checkout_query);
    $stmt->bind_param("i", $checkout_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($prod_id, $user_id);
        $stmt->fetch();

        // Insert rating data into database
        $sql = "INSERT INTO rating (prod_id, user_id, checkout_id, rating, comments, `image`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisss", $prod_id, $user_id, $checkout_id, $rating, $comments, $image_path);

        // Execute the statement
        if ($stmt->execute()) {
            // Rating successfully added
            echo "<script>alert('Rating submitted successfully.');</script>";
            echo "<script>window.location.href = 'accountSIGNED.php';</script>";
            exit();
        } else {
            echo "Error submitting rating: " . $conn->error;
        }
    } else {
        echo "Checkout not found.";
    }

    // Close statement
    $stmt->close();
}


// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="prodview.css">
</head>
<body>
    <div class="container">
        <a onclick="goBack()" href="#" class="bbtn"><img class="backbtn" src="Pics/return.png" alt="back"> Back</a>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <div class="rsec">
            <h1>Rate Product</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <select class="form-control" id="rating" name="rating" required>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comments">Comments:</label>
                    <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Upload Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                </div>
                <input type="hidden" name="checkout_id" value="<?php echo isset($_GET['checkout_id']) ? $_GET['checkout_id'] : ''; ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>