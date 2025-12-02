<?php
require_once '../config/database.php';
require_once '../models/Order.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get database connection
$conn = getDBConnection();
$orderModel = new Order($conn);

// Handle different actions
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        // Create new order
        $customer_id = $_POST['customer_id'];
        $order_type = $_POST['order_type'];
        $quantity = $_POST['quantity'];
        $unit_price = $_POST['unit_price'];
        $notes = $_POST['notes'] ?? null;
        $created_by = $_SESSION['user_id'];
        
        $order_id = $orderModel->create($customer_id, $order_type, $quantity, $unit_price, $created_by, $notes);
        
        if ($order_id) {
            header('Location: ../dashboard/orders.php?success=created');
        } else {
            header('Location: ../dashboard/orders.php?error=create_failed');
        }
        exit();
        break;
        
    case 'update_status':
        // Update order status
        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];
        $payment_status = $_POST['payment_status'] ?? null;
        
        if ($orderModel->updateStatus($order_id, $order_status, $payment_status)) {
            header('Location: ../dashboard/orders.php?success=updated');
        } else {
            header('Location: ../dashboard/orders.php?error=update_failed');
        }
        exit();
        break;
        
    case 'delete':
        // Delete order
        $order_id = $_GET['id'];
        
        if ($orderModel->delete($order_id)) {
            header('Location: ../dashboard/orders.php?success=deleted');
        } else {
            header('Location: ../dashboard/orders.php?error=delete_failed');
        }
        exit();
        break;
        
    default:
        header('Location: ../dashboard/orders.php');
        exit();
}
?>
