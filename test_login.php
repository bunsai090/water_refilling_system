<?php
// SUPER SIMPLE TEST - Direct authentication without models
require_once 'config/database.php';

echo "<h2>Direct Login Test (No Models)</h2>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    echo "<h3>Input:</h3>";
    echo "Username: <code>$username</code><br>";
    echo "Password: <code>$password</code><br><hr>";
    
    // Get connection
    $conn = getDBConnection();
    echo "<h3>Database: water_final</h3>";
    
    // Direct query
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "Query executed<br>";
    echo "Rows found: <strong>" . $result->num_rows . "</strong><br><hr>";
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        echo "<h3>User Data:</h3>";
        echo "user_id: " . $user['user_id'] . "<br>";
        echo "username: " . $user['username'] . "<br>";
        echo "full_name: " . $user['full_name'] . "<br>";
        echo "status: " . $user['status'] . "<br>";
        echo "role: " . $user['role'] . "<br>";
        echo "password (first 70): <code>" . substr($user['password'], 0, 70) . "</code><br><hr>";
        
        echo "<h3>Password Check:</h3>";
        $hash = $user['password'];
        
        // Test multiple ways
        echo "Testing password_verify('$password', hash)...<br>";
        $test1 = password_verify($password, $hash);
        echo "Result: " . ($test1 ? "<strong style='color:green'>TRUE ✓</strong>" : "<strong style='color:red'>FALSE ✗</strong>") . "<br>";
        
        if ($test1) {
            echo "<div style='background:#d1fae5;padding:20px;margin:20px 0;border-radius:8px;'>";
            echo "<h2 style='color:#065f46;margin-top:0;'>✅ SUCCESS!</h2>";
            echo "<p>Password verification WORKS!</p>";
            echo "<h3>Creating session...</h3>";
            
            // Create session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            echo "<p>Session created with:</p>";
            echo "<ul>";
            foreach ($_SESSION as $key => $value) {
                if (strpos($key, 'user') !== false || in_array($key, ['username', 'full_name', 'email', 'role'])) {
                    echo "<li><strong>$key:</strong> $value</li>";
                }
            }
            echo "</ul>";
            
            echo "<p><a href='dashboard/index.php' style='background:#0ea5e9;color:white;padding:12px 24px;text-decoration:none;border-radius:6px;display:inline-block;margin-top:10px;'>Go to Dashboard</a></p>";
            echo "</div>";
        } else {
            echo "<div style='background:#fee2e2;padding:20px;margin:20px 0;border-radius:8px;'>";
            echo "<h2 style='color:#991b1b;margin-top:0;'>❌ FAILED</h2>";
            echo "<p>Password does NOT match!</p>";
            echo "<p><strong>Need to reset password hash.</strong></p>";
            
            // Auto-fix
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $update->bind_param("ss", $new_hash, $username);
            
            if ($update->execute()) {
                echo "<p style='color:green;'>✅ Password hash updated! <a href=''>Refresh this page to try again</a></p>";
            }
            echo "</div>";
        }
    } else {
        echo "<div style='background:#fee2e2;padding:20px;'>";
        echo "<h3>❌ User not found!</h3>";
        
        // Show all users
        $all = $conn->query("SELECT username, full_name FROM users");
        echo "<p>Users in database:</p><ul>";
        while ($u = $all->fetch_assoc()) {
            echo "<li>" . $u['username'] . " (" . $u['full_name'] . ")</li>";
        }
        echo "</ul></div>";
    }
    
} else {
    ?>
    <form method="POST" style="max-width:400px;padding:20px;border:1px solid #ddd;border-radius:8px;">
        <h3>Simple Login Test</h3>
        <div style="margin:10px 0;">
            <label>Username:</label><br>
            <input type="text" name="username" value="admin" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
        </div>
        <div style="margin:10px 0;">
            <label>Password:</label><br>
            <input type="text" name="password" value="admin123" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
        </div>
        <button type="submit" style="background:#0ea5e9;color:white;padding:10px;border:none;border-radius:4px;width:100%;cursor:pointer;">TEST LOGIN</button>
    </form>
    <p style="background:#fef3c7;padding:15px;border-radius:8px;margin-top:20px;">
        ⚠️ This bypasses all models and controllers. If this works, we know the problem is in the code flow.
    </p>
    <?php
}
?>
