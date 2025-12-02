<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple authentication (in production, use password hashing)
    // For now, just accept any login and create a session
    if (!empty($username) && !empty($password)) {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'Administrator';
        
        header('Location: ../dashboard/index.php');
        exit();
    } else {
        header('Location: ../login.php?error=1');
        exit();
    }
}
?>
