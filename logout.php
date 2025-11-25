<?php
session_start();
setcookie('user_name', '', -1, '/');
setcookie('name', '', -1, '/');
session_destroy();

// Show loading screen with success message below the icon
echo '<html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Logged Out</title>
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
                    margin-top: 10px;
                    font-family: \'Silkscreen\', sans-serif;
                }
            </style>
        </head>
        <body>
            <div class="loader"></div>
            <p class="success-message">Logging out...</p>
        </body>
    </html>';
    

// Redirect after 3 seconds
echo '<meta http-equiv="refresh" content="3;url=http://localhost/EcomFinalProject/index.php" />';
?>
