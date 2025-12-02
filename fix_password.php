<?php
// Password Hash Generator & Checker
require_once 'config/database.php';

echo "<h2>Password Hash Checker</h2>";

$conn = getDBConnection();

// Get admin user from database
$result = $conn->query("SELECT username, password FROM users WHERE username = 'admin'");

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    echo "<h3>Current Admin User:</h3>";
    echo "<p>Username: <strong>" . $user['username'] . "</strong></p>";
    echo "<p>Current Password Hash: <code>" . substr($user['password'], 0, 50) . "...</code></p>";
    
    // Test password
    $test_password = 'admin123';
    echo "<h3>Testing Password: <code>admin123</code></h3>";
    
    if (password_verify($test_password, $user['password'])) {
        echo "<p style='color:green; font-weight:bold;'>✅ Password 'admin123' MATCHES!</p>";
    } else {
        echo "<p style='color:red; font-weight:bold;'>❌ Password 'admin123' does NOT match</p>";
        
        // Generate correct hash
        $correct_hash = password_hash('admin123', PASSWORD_DEFAULT);
        echo "<h3>Fix: Update Password Hash</h3>";
        echo "<p>Run this SQL query in phpMyAdmin:</p>";
        echo "<textarea style='width:100%; height:80px; font-family:monospace;'>";
        echo "UPDATE users SET password = '$correct_hash' WHERE username = 'admin';";
        echo "</textarea>";
        
        echo "<p><strong>OR click the button below to auto-fix:</strong></p>";
        
        if (isset($_GET['fix'])) {
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
            $stmt->bind_param("s", $correct_hash);
            if ($stmt->execute()) {
                echo "<p style='color:green; font-weight:bold;'>✅ Password updated successfully! Now try to login with admin/admin123</p>";
                echo "<p><a href='login.php' style='background:#0ea5e9;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Login Page</a></p>";
            } else {
                echo "<p style='color:red;'>Error updating password: " . $conn->error . "</p>";
            }
        } else {
            echo "<p><a href='?fix=1' style='background:#f59e0b;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Click Here to Auto-Fix Password</a></p>";
        }
    }
} else {
    echo "<p style='color:red;'>❌ Admin user not found in database!</p>";
    echo "<p>You need to create the admin user first.</p>";
    
    if (isset($_GET['create'])) {
        $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, full_name, email, phone, role, status) 
                VALUES ('admin', '$password_hash', 'Administrator', 'admin@waterrefilling.com', '0917-000-0000', 'Administrator', 'Active')";
        
        if ($conn->query($sql)) {
            echo "<p style='color:green;'>✅ Admin user created! Now try to login with admin/admin123</p>";
            echo "<p><a href='login.php' style='background:#0ea5e9;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Login Page</a></p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p><a href='?create=1' style='background:#10b981;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Create Admin User</a></p>";
    }
}

$conn->close();
?>
