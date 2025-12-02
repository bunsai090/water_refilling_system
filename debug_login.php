<?php
require_once '../config/database.php';
require_once '../models/User.php';

// Enable error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Login Debug Mode</h2>";
echo "<hr>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "<h3>Step 1: Form Submission</h3>";
    echo "Username received: <code>" . htmlspecialchars($username) . "</code><br>";
    echo "Password received: <code>" . htmlspecialchars($password) . "</code><br>";
    echo "<hr>";
    
    if (!empty($username) && !empty($password)) {
        echo "<h3>Step 2: Database Connection</h3>";
        try {
            $conn = getDBConnection();
            echo "✅ Database connected: <strong>water_final</strong><br>";
        } catch (Exception $e) {
            echo "❌ Connection failed: " . $e->getMessage() . "<br>";
            exit;
        }
        echo "<hr>";
        
        echo "<h3>Step 3: Query User</h3>";
        $query = "SELECT user_id, username, password, full_name, email, role, status FROM users WHERE username = ?";
        echo "Query: <code>$query</code><br>";
        echo "Parameter: <code>$username</code><br>";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        echo "Rows found: <strong>" . $result->num_rows . "</strong><br>";
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "✅ User found!<br>";
            echo "User ID: " . $user['user_id'] . "<br>";
            echo "Username: " . $user['username'] . "<br>";
            echo "Full Name: " . $user['full_name'] . "<br>";
            echo "Role: " . $user['role'] . "<br>";
            echo "Status: " . $user['status'] . "<br>";
            echo "Password Hash (first 60 chars): <code>" . substr($user['password'], 0, 60) . "...</code><br>";
            echo "<hr>";
            
            echo "<h3>Step 4: Status Check</h3>";
            if ($user['status'] == 'Active') {
                echo "✅ User status is Active<br>";
            } else {
                echo "❌ User status is: " . $user['status'] . " (must be 'Active')<br>";
                exit;
            }
            echo "<hr>";
            
            echo "<h3>Step 5: Password Verification</h3>";
            echo "Input password: <code>$password</code><br>";
            echo "Stored hash: <code>" . $user['password'] . "</code><br>";
            
            $verify_result = password_verify($password, $user['password']);
            echo "password_verify() result: <strong>" . ($verify_result ? "TRUE" : "FALSE") . "</strong><br>";
            
            if ($verify_result) {
                echo "<p style='background:#d1fae5;padding:15px;border-radius:8px;color:#065f46;'>";
                echo "✅ <strong>PASSWORD MATCHES!</strong><br>";
                echo "Authentication would succeed. You can login!";
                echo "</p>";
                
                // Show what session would be created
                echo "<h3>Session Variables (would be created):</h3>";
                echo "<ul>";
                echo "<li>user_id: " . $user['user_id'] . "</li>";
                echo "<li>username: " . $user['username'] . "</li>";
                echo "<li>full_name: " . $user['full_name'] . "</li>";
                echo "<li>email: " . $user['email'] . "</li>";
                echo "<li>role: " . $user['role'] . "</li>";
                echo "</ul>";
                
                echo "<p><a href='../login.php' style='background:#0ea5e9;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;display:inline-block;margin-top:10px;'>Try Real Login</a></p>";
            } else {
                echo "<p style='background:#fee2e2;padding:15px;border-radius:8px;color:#991b1b;'>";
                echo "❌ <strong>PASSWORD DOES NOT MATCH!</strong><br>";
                echo "The password hash in database is incorrect.";
                echo "</p>";
                
                // Generate correct hash
                $correct_hash = password_hash($password, PASSWORD_DEFAULT);
                echo "<h3>Solution: Fix Password Hash</h3>";
                echo "<p>Click button below to update password in database:</p>";
                echo "<form method='POST' action='fix_password.php?fix=1' style='margin:10px 0;'>";
                echo "<button type='submit' style='background:#10b981;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;'>Fix Password Hash</button>";
                echo "</form>";
                
                echo "<p style='font-size:12px;color:#666;'>Or run this SQL manually in phpMyAdmin:</p>";
                echo "<textarea style='width:100%;height:80px;font-family:monospace;font-size:11px;'>";
                echo "UPDATE users SET password = '$correct_hash' WHERE username = 'admin';";
                echo "</textarea>";
            }
        } else {
            echo "<p style='background:#fee2e2;padding:15px;border-radius:8px;color:#991b1b;'>";
            echo "❌ <strong>USER NOT FOUND!</strong><br>";
            echo "No user with username '<strong>$username</strong>' exists in database.";
            echo "</p>";
            
            echo "<h3>Users in database:</h3>";
            $all_users = $conn->query("SELECT username, full_name FROM users");
            if ($all_users->num_rows > 0) {
                echo "<ul>";
                while ($u = $all_users->fetch_assoc()) {
                    echo "<li>" . $u['username'] . " (" . $u['full_name'] . ")</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No users found in database!</p>";
            }
        }
    } else {
        echo "<p style='background:#fef3c7;padding:15px;border-radius:8px;color:#92400e;'>";
        echo "⚠️ Empty username or password";
        echo "</p>";
    }
} else {
    // Show login form
    ?>
    <h3>Debug Login Form</h3>
    <form method="POST" style="max-width:400px;border:1px solid #ddd;padding:20px;border-radius:8px;">
        <div style="margin-bottom:15px;">
            <label style="display:block;margin-bottom:5px;font-weight:600;">Username:</label>
            <input type="text" name="username" value="admin" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
        </div>
        <div style="margin-bottom:15px;">
            <label style="display:block;margin-bottom:5px;font-weight:600;">Password:</label>
            <input type="password" name="password" value="admin123" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
        </div>
        <button type="submit" style="background:#0ea5e9;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;width:100%;">Test Login</button>
    </form>
    
    <p style="margin-top:20px;padding:10px;background:#f0f0f0;border-radius:5px;">
        This debug page will show you EXACTLY what's happening during login.
    </p>
    <?php
}
?>
