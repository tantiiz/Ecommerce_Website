<?php
session_start();

// Redirect unauthenticated users to login page
if (empty($_SESSION['admin_username'])) {
    header("Location: adminlogin.php");
    exit();
}
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

// Fetch all products
$sql = "SELECT * FROM products";


// Handle category filtering
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $sql .= " WHERE `prod_category` = '$category'";
}

// Handle sorting
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'lth':
            $sql .= " ORDER BY `prod_price` ASC";
            break;
        case 'htl':
            $sql .= " ORDER BY `prod_price` DESC";
            break;
        case 'latest':
            $sql .= " ORDER BY `prod_id` DESC";
            break;
    }
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css">
</head>

<body>


    <div class="admin container">
        <h1>Welcome admin <?php echo $_SESSION['admin_username']; ?>!</h1>
        <div class="row">
            <div class="col-md-3">
                <!-- Search form -->
                <form>
                    <label for="search">Search by Product Name</label>
                    <input type="text" class="search" name="search" placeholder="Search here" id="searchInput" onkeyup="liveSearch()" required>
                </form>

                <div class="cat">
                    <div class="catlist">
                        <h4>Category</h4>
                        <a href="adminpage.php">All</a>
                        <a href="adminpage.php?category=Solo Leveling">Solo Leveling</a>
                        <a href="adminpage.php?category=Naruto">Naruto</a>
                        <a href="adminpage.php?category=One Piece">One Piece</a>
                        <a href="adminpage.php?category=Dragon Ball">Dragon Ball</a>
                        <a href="adminpage.php?category=Jujutsu Kaisen">Jujutsu Kaisen</a>
                        <a href="adminpage.php?category=Demon Slayer">Demon Slayer</a>
                        <a href="adminpage.php?category=Others">Other</a>
                    </div>
                    <div class="catlist">
                        <h4>Sort By</h4>
                        <a href="adminpage.php?sort=lth">Lowest to Highest Price</a>
                        <a href="adminpage.php?sort=htl">Highest to Lowest Price</a>
                        <a href="adminpage.php?sort=latest">Latest Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="manage row">
                    <div class="col-md-6">
                        <h2>Product Management</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="adminaction">
                            <a href="adminorders.php"><abbr title="Orders"><img src="Pics/order.png" alt="orders"></abbr></a>
                            <a href="admineditacc.php"><abbr title="Edit Account"><img src="Pics/edit-info.png" alt="edit"></abbr></a>
                            <a href="adminadd.php"><abbr title="Add Product"><img src="Pics/add.png" alt="add"></abbr></a>
                            <a href="adminlogout.html"><abbr title="Logout"><img src="Pics/logout.png" alt="logout"></abbr></a>
                        </div>
                    </div>
                </div>

                <div class="adminprod" id="livesearch">
                    <?php
                    echo "<table border='1'>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>";

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['prod_id'] . "</td>";
                            echo "<td>" . $row['prod_name'] . "</td>";
                            echo "<td class='proddetails'>" . $row['prod_details'] . "</td>";
                            echo "<td>₱" . $row['prod_price'] . ".00</td>";
                            echo "<td>" . $row['prod_category'] . "</td>";
                            echo "<td><img src='" . $row['prod_img'] . "' width='100' height='100' alt='prod_img'></td>";
                            echo "<td><a href='adminedit.php?id=" . $row['prod_id'] . "' style='color:green;font-weight:bold;'>Edit</a><br><a href='admindeletecom.php?id=" . $row['prod_id'] . "' style='color:red;font-weight:bold;'>Delete</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function liveSearch() {
            var input = document.getElementById("searchInput").value;
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("livesearch").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "adminsearch.php?q=" + input, true);
            xmlhttp.send();
        }
    </script>

</body>

</html>