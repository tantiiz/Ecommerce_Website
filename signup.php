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

        // Set character set to UTF-8 to handle special characters properly
        $conn->set_charset("utf8mb4");
        
        // CRITICAL: Remove NO_AUTO_VALUE_ON_ZERO from SQL mode (both SESSION and try GLOBAL)
        // This is the main cause of user_id = 0 issues
        $conn->query("SET SESSION sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '')");
        // Try to set global mode (may fail if user doesn't have privileges, that's OK)
        @$conn->query("SET GLOBAL sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '')");
        
        // Delete any problematic rows with user_id = 0 (only if they exist)
        // This is safe and won't affect real users
        $conn->query("DELETE FROM user WHERE user_id = 0");
        
        // CRITICAL: Force AUTO_INCREMENT to be enabled on the column
        // This ensures the column will auto-increment even if it wasn't set before
        $conn->query("ALTER TABLE user MODIFY user_id INT(10) NOT NULL AUTO_INCREMENT");
        
        // Get the maximum user_id and ensure AUTO_INCREMENT is set higher
        $max_result = $conn->query("SELECT IFNULL(MAX(user_id), 0) as max_id FROM user WHERE user_id > 0");
        if ($max_result) {
            $max_row = $max_result->fetch_assoc();
            $max_id = (int)$max_row['max_id'];
            $next_id = max($max_id + 1, 1); // At least 1, or max_id + 1
            
            // Set AUTO_INCREMENT to the next available ID
            $conn->query("ALTER TABLE user AUTO_INCREMENT = $next_id");
        }

        $_hashed_password = md5($_POST['password']);

        // Check if the email is already in use using prepared statement
        // This ensures each user has a unique email address
        $check_email_query = "SELECT * FROM user WHERE user_email = ?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt->close();
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
            $stmt->close();
            // Email is not in use, check if username is already taken
            $check_username_query = "SELECT * FROM user WHERE user_name = ?";
            $stmt = $conn->prepare($check_username_query);
            $stmt->bind_param("s", $_POST['username']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $stmt->close();
                // Username is already in use, show error message
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
                            <p class="error-message">Username is already taken!</p>
                        </body>
                    </html>';
                echo '<meta http-equiv="refresh" content="2;url=http://localhost/EcomFinalProject/signup.html" />';
            } else {
                $stmt->close();
                // Both email and username are available, proceed with registration
                // This INSERT will create a NEW user with a unique AUTO_INCREMENT user_id
                // Existing users in the database will remain untouched
                $sql = "INSERT INTO user (`user_name`, `user_email`, `user_address`, `phone_number`, `password`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                
                if (!$stmt) {
                    // Show error if prepare failed
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
                                        color: #ff0000;
                                    }
                                </style>
                            </head>
                            <body>
                                <p class="error-message">Database Error: ' . $conn->error . '</p>
                            </body>
                        </html>';
                    $conn->close();
                    exit();
                }
                
                $stmt->bind_param("sssss", $_POST['username'], $_POST['email'], $_POST['address'], $_POST['phonenumber'], $_hashed_password);

                if ($stmt->execute()) {
                    // Get the inserted user_id
                    $inserted_user_id = $conn->insert_id;
                    $stmt->close();
                    
                    // Verify the user was actually inserted by checking the database
                    // This is more reliable than just checking insert_id
                    $verify_query = "SELECT user_id, user_name, user_email FROM user WHERE user_email = ?";
                    $verify_stmt = $conn->prepare($verify_query);
                    $verify_stmt->bind_param("s", $_POST['email']);
                    $verify_stmt->execute();
                    $verify_result = $verify_stmt->get_result();
                    
                    if ($verify_result->num_rows > 0) {
                        // User successfully inserted and verified in database
                        $verify_row = $verify_result->fetch_assoc();
                        $verify_stmt->close();
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
                        // Insert appeared to succeed but verification failed
                        $verify_stmt->close();
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
                                            color: #ff0000;
                                            text-align: center;
                                            padding: 20px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <p class="error-message">Registration failed: Could not verify user creation.<br><br>Please run the database fix script first:<br><a href="fix_database.php" style="color: #4CAF50;">Fix Database</a></p>
                                </body>
                            </html>';
                        echo '<meta http-equiv="refresh" content="5;url=http://localhost/EcomFinalProject/signup.html" />';
                    }
                } else {
                    // Show error message for database error with detailed information
                    $error_msg = $stmt->error ? $stmt->error : $conn->error;
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
                                        color: #ff0000;
                                        text-align: center;
                                        padding: 20px;
                                        max-width: 600px;
                                    }
                                </style>
                            </head>
                            <body>
                                <p class="error-message">Database Error: ' . htmlspecialchars($error_msg) . '<br><br>Please try again or contact support.</p>
                            </body>
                        </html>';
                    echo '<meta http-equiv="refresh" content="5;url=http://localhost/EcomFinalProject/signup.html" />';
                    $stmt->close();
                }
            }
        }
        $conn->close();
    }
}
?>
