<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $admin_username = $_SESSION['admin_username'];
    $current_password = $_POST['current_password'];
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate current password
    $sql = "SELECT * FROM `admin` WHERE `admin_username` = '$admin_username' AND `admin_password` = '$current_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Current password is correct
        if ($new_password === $confirm_password) {
            // Update username and password
            $update_sql = "UPDATE `admin` SET `admin_username` = '$new_username', `admin_password` = '$new_password' WHERE `admin_username` = '$admin_username'";
            if ($conn->query($update_sql) === TRUE) {
                // Update successful
                $_SESSION['admin_username'] = $new_username; // Update session variable
                echo "Account updated successfully!";
                header("Location: adminpage.php"); // Redirect to adminpage.php
                exit(); // Ensure no further code execution after redirection
            } else {
                echo "Error updating account: " . $conn->error;
            }
        } else {
            echo "New password and confirm password do not match!";
        }
    } else {
        echo "Incorrect current password!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
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
        <h1>Edit Admin Account</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_username">New Username:</label>
                <input type="text" class="form-control" id="new_username" name="new_username" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Account</button>
        </form>
    </div>
</body>
</html>
