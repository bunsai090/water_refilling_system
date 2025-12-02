<?php
require_once 'config/database.php';

echo "<h2>Password Reset for Admin User</h2>";

// Get database connection
$conn = getDBConnection();

// Generate new password hash for "admin123"
$new_password = 'admin123';
$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

// Update admin user password
$sql = "UPDATE users SET password = ? WHERE username = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $password_hash);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "<div style='background:#d1fae5;padding:20px;border-radius:8px;color:#065f46;margin:20px 0;'>";
        echo "<h3 style='margin-top:0;'>✅ Password Updated Successfully!</h3>";
        echo "<p><strong>Username:</strong> admin</p>";
        echo "<p><strong>Password:</strong> admin123</p>";
        echo "<p style='margin-bottom:0;'>You can now login using these credentials.</p>";
        echo "</div>";
        
        echo "<a href='login.php' style='background:#0ea5e9;color:white;padding:12px 24px;text-decoration:none;border-radius:6px;display:inline-block;'>Go to Login Page</a>";
        
        // Verify it works
        echo "<hr style='margin:30px 0;'>";
        echo "<h3>Verification:</h3>";
        
        $check = $conn->query("SELECT username, password FROM users WHERE username = 'admin'");
        if ($check && $check->num_rows > 0) {
            $user = $check->fetch_assoc();
            $verify = password_verify('admin123', $user['password']);
            
            if ($verify) {
                echo "<p style='color:green;font-weight:bold;'>✅ Password verification: WORKING</p>";
                echo "<p>Login should work now!</p>";
            } else {
                echo "<p style='color:red;font-weight:bold;'>❌ Verification failed - something went wrong</p>";
            }
        }
    } else {
        echo "<div style='background:#fee2e2;padding:20px;border-radius:8px;color:#991b1b;'>";
        echo "<h3>⚠️ No user updated</h3>";
        echo "<p>User 'admin' was not found in database.</p>";
        echo "</div>";
        
        // Show all users
        $users = $conn->query("SELECT username, full_name FROM users");
        echo "<h4>Users in database:</h4>";
        if ($users->num_rows > 0) {
            echo "<ul>";
            while ($u = $users->fetch_assoc()) {
                echo "<li>" . $u['username'] . " - " . $u['full_name'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No users found!</p>";
        }
    }
} else {
    echo "<div style='background:#fee2e2;padding:20px;border-radius:8px;color:#991b1b;'>";
    echo "<h3>❌ Error updating password</h3>";
    echo "<p>" . $conn->error . "</p>";
    echo "</div>";
}

$conn->close();
?>
