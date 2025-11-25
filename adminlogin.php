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

    $sql = "SELECT * FROM `admin` WHERE `admin_username` = '" . $_POST['adminusername'] . "' AND `admin_password` = '" . $_POST['adminpassword'] . "'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        // Set session variable
        $_SESSION['admin_username'] = $row['admin_username'];

        // Redirect to admin page
        header("Location: adminpage.php");
        exit();
    } else {
        // Show error message
        echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Login Failed</title>
                    <style>
                        body {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            height: 100vh;
                            background-color: #282c35;
                            color: #fff;
                            margin: 0;
                        }

                        .error-message {
                            margin-top: 20px;
                            font-family: \'Silkscreen\', sans-serif;
                            font-size: 20px;
                            color: #ff0000; /* Error message color */
                        }
                    </style>
                </head>
                <body>
                    <p class="error-message">Admin not found!</p>
                </body>
            </html>';
            echo '<meta http-equiv="refresh" content="3;url=http://localhost/EcomFinalProject/adminlogin.html" />';
    }

    
}
?>
