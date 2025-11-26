<?php
/**
 * Automatic Database Fix Script
 * Run this once to fix the AUTO_INCREMENT issue in your database
 * Access via: http://localhost/EcomFinalProject/fix_database.php
 */

date_default_timezone_set('Asia/Manila');

$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecomfinal";

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Database Fix Tool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #282c35;
            color: #fff;
        }
        .success { color: #4CAF50; }
        .error { color: #f44336; }
        .warning { color: #ff9800; }
        .info { color: #2196F3; }
        pre {
            background-color: #1e1e1e;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .step {
            margin: 20px 0;
            padding: 15px;
            background-color: #2d2d2d;
            border-radius: 5px;
            border-left: 4px solid #2196F3;
        }
    </style>
</head>
<body>
    <h1>Database Fix Tool</h1>
    <p>This script will fix the AUTO_INCREMENT issue in your user table.</p>
    <hr>";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<div class='error'>❌ Connection failed: " . $conn->connect_error . "</div></body></html>");
}

echo "<div class='success'>✅ Connected to database successfully</div>";

$errors = [];
$success = [];

// Step 1: Remove NO_AUTO_VALUE_ON_ZERO from SQL mode
echo "<div class='step'><h3>Step 1: Removing NO_AUTO_VALUE_ON_ZERO from SQL mode</h3>";
if ($conn->query("SET SESSION sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '')")) {
    echo "<div class='success'>✅ SQL mode updated (session)</div>";
    $success[] = "SQL mode updated";
} else {
    echo "<div class='warning'>⚠️ Could not update session SQL mode: " . $conn->error . "</div>";
    $errors[] = "Could not update SQL mode";
}
if ($conn->query("SET GLOBAL sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '')")) {
    echo "<div class='success'>✅ SQL mode updated (global)</div>";
} else {
    echo "<div class='warning'>⚠️ Could not update global SQL mode: " . $conn->error . "</div>";
}
echo "</div>";

// Step 2: Delete rows with user_id = 0
echo "<div class='step'><h3>Step 2: Removing problematic rows (user_id = 0)</h3>";
$check_result = $conn->query("SELECT COUNT(*) as count FROM user WHERE user_id = 0");
$check_row = $check_result->fetch_assoc();
$count_before = $check_row['count'];

if ($count_before > 0) {
    echo "<div class='info'>Found $count_before row(s) with user_id = 0</div>";
    if ($conn->query("DELETE FROM user WHERE user_id = 0")) {
        echo "<div class='success'>✅ Deleted $count_before problematic row(s)</div>";
        $success[] = "Deleted $count_before problematic rows";
    } else {
        echo "<div class='error'>❌ Failed to delete rows: " . $conn->error . "</div>";
        $errors[] = "Failed to delete problematic rows";
    }
} else {
    echo "<div class='success'>✅ No problematic rows found</div>";
    $success[] = "No problematic rows to delete";
}
echo "</div>";

// Step 3: Ensure AUTO_INCREMENT is set (FORCE IT)
echo "<div class='step'><h3>Step 3: Ensuring AUTO_INCREMENT is properly configured</h3>";
// First, make sure the column has AUTO_INCREMENT enabled
if ($conn->query("ALTER TABLE user MODIFY user_id INT(10) NOT NULL AUTO_INCREMENT")) {
    echo "<div class='success'>✅ AUTO_INCREMENT enabled on user_id column</div>";
    $success[] = "AUTO_INCREMENT enabled on column";
} else {
    echo "<div class='error'>❌ Failed to enable AUTO_INCREMENT on column: " . $conn->error . "</div>";
    $errors[] = "Failed to enable AUTO_INCREMENT on column";
}
echo "</div>";

// Step 4: Reset AUTO_INCREMENT to correct value
echo "<div class='step'><h3>Step 4: Resetting AUTO_INCREMENT to correct value</h3>";
// Get max user_id, but exclude 0 (which shouldn't exist but might)
$max_result = $conn->query("SELECT IFNULL(MAX(user_id), 0) as max_id FROM user WHERE user_id > 0");
if ($max_result) {
    $max_row = $max_result->fetch_assoc();
    $max_id = (int)$max_row['max_id'];
    $next_id = max($max_id + 1, 1); // At least 1
    
    echo "<div class='info'>Current max user_id (excluding 0): $max_id</div>";
    echo "<div class='info'>Setting AUTO_INCREMENT to: $next_id</div>";
    
    if ($conn->query("ALTER TABLE user AUTO_INCREMENT = $next_id")) {
        echo "<div class='success'>✅ AUTO_INCREMENT reset to $next_id</div>";
        $success[] = "AUTO_INCREMENT reset to $next_id";
    } else {
        echo "<div class='error'>❌ Failed to reset AUTO_INCREMENT: " . $conn->error . "</div>";
        $errors[] = "Failed to reset AUTO_INCREMENT";
    }
} else {
    echo "<div class='error'>❌ Failed to get max user_id: " . $conn->error . "</div>";
    $errors[] = "Failed to get max user_id";
}
echo "</div>";

// Step 5: Verification
echo "<div class='step'><h3>Step 5: Verification</h3>";
$status_result = $conn->query("SHOW TABLE STATUS LIKE 'user'");
if ($status_result) {
    $status_row = $status_result->fetch_assoc();
    $auto_increment = $status_row['Auto_increment'];
    echo "<div class='info'>Current AUTO_INCREMENT value: $auto_increment</div>";
    
    if ($auto_increment > 0) {
        echo "<div class='success'>✅ AUTO_INCREMENT is properly set</div>";
    } else {
        echo "<div class='error'>❌ AUTO_INCREMENT is not set correctly</div>";
        $errors[] = "AUTO_INCREMENT verification failed";
    }
}

$user_count_result = $conn->query("SELECT COUNT(*) as count, MAX(user_id) as max_id FROM user");
if ($user_count_result) {
    $user_count_row = $user_count_result->fetch_assoc();
    echo "<div class='info'>Total users in database: " . $user_count_row['count'] . "</div>";
    echo "<div class='info'>Highest user_id: " . ($user_count_row['max_id'] ?? 'N/A') . "</div>";
}

$problematic_result = $conn->query("SELECT COUNT(*) as count FROM user WHERE user_id = 0");
if ($problematic_result) {
    $problematic_row = $problematic_result->fetch_assoc();
    if ($problematic_row['count'] == 0) {
        echo "<div class='success'>✅ No problematic rows (user_id = 0) found</div>";
    } else {
        echo "<div class='error'>❌ Still found " . $problematic_row['count'] . " problematic row(s)</div>";
        $errors[] = "Problematic rows still exist";
    }
}
echo "</div>";

// Summary
echo "<hr><h2>Summary</h2>";
if (empty($errors)) {
    echo "<div class='success'><h3>✅ All fixes applied successfully!</h3>";
    echo "<p>Your database should now work correctly. Try creating a new user account.</p>";
    echo "<p><a href='signup.html' style='color: #4CAF50;'>Go to Signup Page</a></p></div>";
} else {
    echo "<div class='error'><h3>⚠️ Some issues occurred:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul></div>";
}

if (!empty($success)) {
    echo "<div class='info'><h3>Completed steps:</h3><ul>";
    foreach ($success as $msg) {
        echo "<li>$msg</li>";
    }
    echo "</ul></div>";
}

$conn->close();

echo "</body></html>";
?>

