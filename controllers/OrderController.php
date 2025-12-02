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
        // Create new order with inventory check
        require_once '../models/Inventory.php';
        $inventoryModel = new Inventory($conn);
        
        $customer_id = $_POST['customer_id'];
        $order_type = $_POST['order_type'];
        $quantity = $_POST['quantity'];
        $unit_price = $_POST['unit_price'];
        $notes = $_POST['notes'] ?? null;
        $created_by = $_SESSION['user_id'];
        
        // Check inventory based on order type
        $inventory_check = true;
        $inventory_item = null;
        
        // For all order types except "Others", check inventory
        if ($order_type != 'Others') {
            // Get inventory item of the same type
            $inventory_items = $inventoryModel->getByType($order_type);
            
            if (!empty($inventory_items)) {
                $inventory_item = $inventory_items[0]; // Get first item of this type
                $available_stock = $inventory_item['quantity'];
                
                if ($available_stock < $quantity) {
                    // Not enough stock
                    header('Location: ../dashboard/orders.php?error=insufficient_stock&available=' . $available_stock . '&type=' . urlencode($order_type));
                    exit();
                }
            } else {
                // No inventory item found for this type
                header('Location: ../dashboard/orders.php?error=no_inventory&type=' . urlencode($order_type));
                exit();
            }
        }
        
        // Create the order
        $order_id = $orderModel->create($customer_id, $order_type, $quantity, $unit_price, $created_by, $notes);
        
        if ($order_id) {
            // Deduct from inventory if applicable (all types except Others)
            if ($inventory_item && $order_type != 'Others') {
                $inventoryModel->removeStock(
                    $inventory_item['inventory_id'], 
                    $quantity, 
                    $created_by, 
                    "Order #" . $order_id . " - " . $order_type
                );
            }
            
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
