<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <style>
        @font-face {
            font-family: 'montserrat';
            src: url('Montserrat-Regular.ttf');
        }
        
        @font-face {
            font-family: 'bromph';
            src: url('Fonts/BROMPH_TOWN.ttf');
        }
        
        @font-face {
            font-family: 'runtoe';
            src: url('Fonts/Runtoe.ttf');
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #282c35;
            color: #fff;
        }

        .logout-box {
            background-color: #FCF7F8;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 35px;
            font-family: 'bromph';
            letter-spacing: 2px;
            color: #3b3c43;
        }

        p {
            margin-bottom: 30px;
            font-size: 20px;
            color: black;
        }

        .button a {
            display: inline-block;
            transition: transform 0.3s;
            text-decoration: none;
            margin: 0 30px;
            margin-bottom: 30px;
            scale: 1.2;
            font-size: 18px;
        }

        .button a:hover {
            transform: scale(1.2);
            text-decoration: none;
        }

        .button a.yes {
            color: #ea5858;
        }

        .button a.no {
            color: #4CAF50;
        }
    </style>
</head>

<body>
    <div class="logout-box">
        <h1>Delete Product</h1>
        <p>Are you sure you want to delete this product?</p>
        <div class="button">
            <a href="admindelete.php?id=<?php echo $_GET['id']; ?>" class="yes">Yes</a>
            <a href="#" class="no" onclick="goBack()">No</a>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </div>
    </div>
</body>

</html>
