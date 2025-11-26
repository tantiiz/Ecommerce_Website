<?php
/**
 * Database Connection Test Script
 * Use this to diagnose database connection and table issues
 */

date_default_timezone_set('Asia/Manila');

$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecomfinal";

echo "<h2>Database Connection Test</h2>";
echo "<pre>";

// Test 1: Check if MySQL is running
echo "Test 1: Checking MySQL connection...\n";
$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("❌ FAILED: Connection error: " . $conn->connect_error . "\n\nPlease check:\n- Is XAMPP MySQL service running?\n- Are the credentials correct?\n");
} else {
    echo "✅ PASSED: Connected to MySQL server\n\n";
}

// Test 2: Check if database exists
echo "Test 2: Checking if database '$dbname' exists...\n";
$result = $conn->query("SHOW DATABASES LIKE '$dbname'");
if ($result->num_rows > 0) {
    echo "✅ PASSED: Database '$dbname' exists\n\n";
    $conn->select_db($dbname);
} else {
    die("❌ FAILED: Database '$dbname' does not exist!\n\nPlease create the database or import the SQL file.\n");
}

// Test 3: Check if user table exists
echo "Test 3: Checking if 'user' table exists...\n";
$result = $conn->query("SHOW TABLES LIKE 'user'");
if ($result->num_rows > 0) {
    echo "✅ PASSED: Table 'user' exists\n\n";
} else {
    die("❌ FAILED: Table 'user' does not exist!\n\nPlease import the database schema.\n");
}

// Test 4: Check table structure
echo "Test 4: Checking 'user' table structure...\n";
$result = $conn->query("DESCRIBE user");
echo "Table structure:\n";
while ($row = $result->fetch_assoc()) {
    echo "  - {$row['Field']}: {$row['Type']} " . ($row['Key'] == 'PRI' ? '(PRIMARY KEY)' : '') . 
         ($row['Extra'] == 'auto_increment' ? ' (AUTO_INCREMENT)' : '') . "\n";
}
echo "\n";

// Test 5: Check AUTO_INCREMENT value
echo "Test 5: Checking AUTO_INCREMENT status...\n";
$result = $conn->query("SHOW TABLE STATUS LIKE 'user'");
$row = $result->fetch_assoc();
echo "Current AUTO_INCREMENT value: " . $row['Auto_increment'] . "\n";
if ($row['Auto_increment'] == null || $row['Auto_increment'] == 0) {
    echo "⚠️  WARNING: AUTO_INCREMENT might not be set properly!\n";
} else {
    echo "✅ PASSED: AUTO_INCREMENT is set\n";
}
echo "\n";

// Test 6: Check SQL mode
echo "Test 6: Checking SQL mode...\n";
$result = $conn->query("SELECT @@sql_mode");
$row = $result->fetch_assoc();
echo "Current SQL mode: " . $row['@@sql_mode'] . "\n";
if (strpos($row['@@sql_mode'], 'NO_AUTO_VALUE_ON_ZERO') !== false) {
    echo "⚠️  WARNING: NO_AUTO_VALUE_ON_ZERO is enabled (this can cause issues)\n";
} else {
    echo "✅ PASSED: NO_AUTO_VALUE_ON_ZERO is not enabled\n";
}
echo "\n";

// Test 7: Check for rows with user_id = 0
echo "Test 7: Checking for problematic rows (user_id = 0)...\n";
$result = $conn->query("SELECT COUNT(*) as count FROM user WHERE user_id = 0");
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    echo "⚠️  WARNING: Found {$row['count']} row(s) with user_id = 0 (this can cause conflicts)\n";
} else {
    echo "✅ PASSED: No problematic rows found\n";
}
echo "\n";

// Test 8: Count existing users
echo "Test 8: Counting existing users...\n";
$result = $conn->query("SELECT COUNT(*) as count FROM user");
$row = $result->fetch_assoc();
echo "Total users in database: " . $row['count'] . "\n";
echo "\n";

// Test 9: Test INSERT (dry run - will rollback)
echo "Test 9: Testing INSERT operation (will rollback)...\n";
$conn->autocommit(FALSE);
$test_username = "test_user_" . time();
$test_email = "test_" . time() . "@test.com";
$test_address = "Test Address";
$test_phone = "1234567890";
$test_password = md5("test123");

$stmt = $conn->prepare("INSERT INTO user (`user_name`, `user_email`, `user_address`, `phone_number`, `password`) VALUES (?, ?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("sssss", $test_username, $test_email, $test_address, $test_phone, $test_password);
    if ($stmt->execute()) {
        $inserted_id = $conn->insert_id;
        echo "✅ PASSED: Test INSERT successful! Would create user_id: $inserted_id\n";
        $conn->rollback(); // Rollback the test insert
        echo "   (Test insert rolled back - no data was saved)\n";
    } else {
        echo "❌ FAILED: Test INSERT failed: " . $stmt->error . "\n";
    }
    $stmt->close();
} else {
    echo "❌ FAILED: Could not prepare statement: " . $conn->error . "\n";
}
$conn->autocommit(TRUE);
echo "\n";

echo "</pre>";
echo "<h3>Summary</h3>";
echo "<p>If all tests passed, your database should be working correctly.</p>";
echo "<p>If any test failed, please fix the issue before using the signup form.</p>";
echo "<p><a href='signup.html'>Go to Signup Page</a></p>";

$conn->close();
?>

