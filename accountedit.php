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

// Fetch user details from the database
$user_name = $_COOKIE['user_name'];
$user_details_query = "SELECT * FROM user WHERE user_name = '$user_name'";
$user_details_result = $conn->query($user_details_query);

if ($user_details_result->num_rows > 0) {
    $user_details_row = $user_details_result->fetch_assoc();
} else {
    echo "User not found";
    exit; // Stop further execution if user is not found
}

// Handle form submission to update user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];

    // Update user details in the database
    $update_query = "UPDATE user SET phone_number = '$phone_number', user_email = '$user_email', user_address = '$user_address' WHERE user_name = '$user_name'";
    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('User details updated successfully');</script>";
        // Redirect to account page after successful update
        header("Location: accountSIGNED.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="account.css">
    <style>
        body {
            background-color: #30323D;
        }
    </style>
</head>
<body>
    <div class="editacc container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <h1 class="text-center">Edit User Details</h1>
                    <div class="form-group">
                        <label for="phone_number">Phone Number:</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user_details_row['phone_number']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email:</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo $user_details_row['user_email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="user_address">Address:</label>
                        <textarea class="form-control" id="user_address" name="user_address" rows="3"><?php echo $user_details_row['user_address']; ?></textarea>
                    </div>
                    <div class="subbtn">
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
