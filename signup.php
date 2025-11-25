<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['username'] == "" || $_POST['email'] == "" || $_POST['address'] == "" || $_POST['phonenumber'] == "" || $_POST['password'] == "" || $_POST['confirmpassword'] == "" ) {
        // Show error message for empty fields
        echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Registration Error</title>
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
                    <p class="error-message">All fields are required!</p>
                </body>
            </html>';
    } else if ($_POST['password'] != $_POST['confirmpassword']) {
        // Show error message for password mismatch
        echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Registration Error</title>
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
                    <p class="error-message">Password and confirmed password did not match!</p>
                </body>
                <meta http-equiv="refresh" content="3;url=http://localhost/EcomFinalProject/signup.html" />
            </html>';
    } else {
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

        $_hashed_password = md5($_POST['password']);

        // Check if the email is already in use
        $check_email_query = "SELECT * FROM user WHERE user_email = '" . $_POST['email'] . "'";
        $result = $conn->query($check_email_query);
        if ($result->num_rows > 0) {
            // Email is already in use, show error message
            echo '<html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Registration Error</title>
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
                        <p class="error-message">Email is already in use!</p>
                    </body>
                </html>';
                echo '<meta http-equiv="refresh" content="2;url=http://localhost/EcomFinalProject/signup.html" />';
        } else {
            // Email is not in use, proceed with registration
            $sql = "INSERT INTO user (`user_name`, `user_email`, `user_address`, `phone_number`, `password`) VALUES ('" . $_POST['username'] . "', '" . $_POST['email'] . "', '" . $_POST['address'] . "', '" . $_POST['phonenumber'] . "', '" .  $_hashed_password . "')";

            if ($conn->query($sql) === TRUE) {
                // Show loading screen with success message
                setcookie('user_name', $_POST['username'], time() + (86400 * 30), "/");
                
                echo '<html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Registration Successful</title>
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

                                .success-message {
                                    margin-top: 20px;
                                    font-family: \'Silkscreen\', sans-serif;
                                    font-size: 20px;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="loader"></div>
                            <p class="success-message">Creating Account...</p>
                        </body>
                    </html>';
                    
                // Redirect after 3 seconds
                echo '<meta http-equiv="refresh" content="3;url=http://localhost/EcomFinalProject/signin.html" />';
            } else {
                // Show error message for database error
                echo '<html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Registration Error</title>
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
                            <p class="error-message">Error: ' . $sql . '<br>' . $conn->error . '</p>
                        </body>
                    </html>';
            }
        }
    }
}
?>
