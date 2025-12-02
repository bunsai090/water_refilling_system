<?php
// Database Diagnostic Script
echo "<h2>Database Connection Test</h2>";

// Connection details
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'water_refilling_db';

// Attempt connection
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("<p style='color:red'>❌ Connection Failed: " . $conn->connect_error . "</p>");
}
echo "<p style='color:green'>✅ Connected to MySQL server</p>";

// Check if database exists
$result = $conn->query("SHOW DATABASES LIKE 'water_refilling_db'");
if ($result->num_rows > 0) {
    echo "<p style='color:green'>✅ Database 'water_refilling_db' exists</p>";
    
    // Select database
    $conn->select_db($db);
    
    // Check for tables
    echo "<h3>Tables in database:</h3>";
    $tables = $conn->query("SHOW TABLES");
    
    if ($tables->num_rows > 0) {
        echo "<ul>";
        while ($row = $tables->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
        
        // Check users table specifically
        $users = $conn->query("SELECT COUNT(*) as count FROM users");
        if ($users) {
            $count = $users->fetch_assoc();
            echo "<p style='color:green'>✅ Users table exists with " . $count['count'] . " record(s)</p>";
            
            // Show admin user
            $admin = $conn->query("SELECT username, full_name, role FROM users WHERE username = 'admin'");
            if ($admin && $admin->num_rows > 0) {
                $user_data = $admin->fetch_assoc();
                echo "<p style='color:green'>✅ Admin user found: " . $user_data['full_name'] . " (" . $user_data['role'] . ")</p>";
            } else {
                echo "<p style='color:orange'>⚠️ Admin user NOT found in users table</p>";
            }
        } else {
            echo "<p style='color:red'>❌ Error accessing users table: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red'>❌ No tables found in database! You need to import the SQL file.</p>";
        echo "<h3>How to import:</h3>";
        echo "<ol>";
        echo "<li>Open phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>";
        echo "<li>Click on 'water_refilling_db' in left sidebar (or create it first)</li>";
        echo "<li>Click 'Import' tab</li>";
        echo "<li>Choose file: water_refilling_db.sql</li>";
        echo "<li>Click 'Go'</li>";
        echo "</ol>";
    }
} else {
    echo "<p style='color:orange'>⚠️ Database 'water_refilling_db' does NOT exist</p>";
    echo "<p>Creating database now...</p>";
    
    if ($conn->query("CREATE DATABASE water_refilling_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        echo "<p style='color:green'>✅ Database created successfully!</p>";
        echo "<p style='color:orange'>⚠️ Now you need to import the tables:</p>";
        echo "<ol>";
        echo "<li>Open phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>";
        echo "<li>Click on 'water_refilling_db' in left sidebar</li>";
        echo "<li>Click 'Import' tab</li>";
        echo "<li>Choose file: water_refilling_db.sql</li>";
        echo "<li>Click 'Go'</li>";
        echo "</ol>";
    } else {
        echo "<p style='color:red'>❌ Error creating database: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
