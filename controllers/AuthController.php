<?php
require_once '../config/database.php';
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        // Get database connection
        $conn = getDBConnection();
        
        // Create User model instance
        $userModel = new User($conn);
        
        // Attempt authentication
        $user = $userModel->authenticate($username, $password);
        
        if ($user) {
            // Authentication successful - set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect to dashboard
            header('Location: ../dashboard/index.php');
            exit();
        } else {
            // Authentication failed
            header('Location: ../login.php?error=invalid');
            exit();
        }
    } else {
        // Empty fields
        header('Location: ../login.php?error=empty');
        exit();
    }
}
?>
