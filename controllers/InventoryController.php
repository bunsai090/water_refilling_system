<?php
require_once '../config/database.php';
require_once '../models/Inventory.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$conn = getDBConnection();
$inventoryModel = new Inventory($conn);

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        // Create new inventory item
        $item_name = $_POST['item_name'];
        $item_type = $_POST['item_type'];
        $quantity = $_POST['quantity'];
        $unit = $_POST['unit'];
        $price = $_POST['price'];
        $reorder_level = $_POST['reorder_level'] ?? 10;
        
        if ($inventoryModel->create($item_name, $item_type, $quantity, $unit, $price, $reorder_level)) {
            header('Location: ../dashboard/inventory.php?success=created');
        } else {
            header('Location: ../dashboard/inventory.php?error=create_failed');
        }
        exit();
        break;
        
    case 'add_stock':
        // Add stock
        $inventory_id = $_POST['inventory_id'];
        $quantity = $_POST['quantity'];
        $notes = $_POST['notes'] ?? null;
        $updated_by = $_SESSION['user_id'];
        
        if ($inventoryModel->addStock($inventory_id, $quantity, $updated_by, $notes)) {
            header('Location: ../dashboard/inventory.php?success=stock_added');
        } else {
            header('Location: ../dashboard/inventory.php?error=stock_failed');
        }
        exit();
        break;
        
    case 'remove_stock':
        // Remove stock
        $inventory_id = $_POST['inventory_id'];
        $quantity = $_POST['quantity'];
        $notes = $_POST['notes'] ?? null;
        $updated_by = $_SESSION['user_id'];
        
        if ($inventoryModel->removeStock($inventory_id, $quantity, $updated_by, $notes)) {
            header('Location: ../dashboard/inventory.php?success=stock_removed');
        } else {
            header('Location: ../dashboard/inventory.php?error=stock_failed');
        }
        exit();
        break;
        
    default:
        header('Location: ../dashboard/inventory.php');
        exit();
}
?>
