<?php
require_once '../config/database.php';
require_once '../models/Customer.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$conn = getDBConnection();
$customerModel = new Customer($conn);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $full_name = $_POST['full_name'];
        $address = $_POST['address'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $email = $_POST['email'] ?? null;
        
        if ($customerModel->create($full_name, $address, $phone, $email)) {
            header('Location: ../dashboard/customers.php?success=created');
        } else {
            header('Location: ../dashboard/customers.php?error=create_failed');
        }
        exit();
        break;
        
    default:
        header('Location: ../dashboard/customers.php');
        exit();
}
?>
