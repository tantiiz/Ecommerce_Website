<?php
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

    $_hashed_password = md5($_POST['password']);

    $sql = "SELECT * FROM user WHERE `user_email` = '" . $_POST['email'] . "' AND `password` = '" . $_hashed_password . "'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        session_start();
        setcookie('user_name', $row['user_name'], time() + (86400 * 30));

        // Show success message
        echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Login Successful</title>
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

                        .loader {
                            border: 8px solid #f3f3f3;
                            border-top: 8px solid #3498db;
                            border-radius: 50%;
                            width: 50px;
                            height: 50px;
                            animation: spin 1s linear infinite;
                        }

                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }

                        .success-message, .error-message {
                            margin-top: 20px;
                            font-family: \'Silkscreen\', sans-serif;
                            font-size: 20px;
                        }

                        .success-message {
                            color: #00ff00; /* Success message color */
                        }

                        .error-message {
                            color: #ff0000; /* Error message color */
                        }
                    </style>
                </head>
                <body>
                    <div class="loader"></div>
                    <p class="success-message">Logging in...</p>
                </body>
            </html>';
        
        // Redirect after 3 seconds
        echo '<meta http-equiv="refresh" content="3;url=http://localhost/EcomFinalProject/productpageSIGNED.php" />';
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
                    <p class="error-message">Account not found!</p>
                </body>
            </html>';
            echo '<meta http-equiv="refresh" content="3;url=http://localhost/EcomFinalProject/signin.html" />';
    }

    
}
?>
