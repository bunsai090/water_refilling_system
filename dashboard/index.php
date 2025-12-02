<?php
require_once '../config/database.php';
require_once '../models/Order.php';
require_once '../models/Inventory.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get database connection
$conn = getDBConnection();

// Create model instances
$orderModel = new Order($conn);
$inventoryModel = new Inventory($conn);

// Get today's statistics
$stats = $orderModel->getTodayStats();
$inventorySummary = $inventoryModel->getSummary();

// Get recent orders
$recentOrders = $orderModel->getAll();
$recentOrders = array_slice($recentOrders, 0, 5); // Get only first 5 orders
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Water Refilling Station</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../views/components/header.php'; ?>
        
        <div class="dashboard-main">
            <?php include '../views/components/sidebar.php'; ?>
            
            <main class="main-content">
                <div class="page-header mb-6">
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-description">Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>! Here's your business overview.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-4 mb-8" style="grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <div class="card" style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 8px;">Total Sales Today</div>
                                <div style="font-size: 28px; font-weight: 600; color: #333;">₱<?php echo number_format($stats['total_sales'] ?? 0, 2); ?></div>
                            </div>
                            <div style="width: 40px; height: 40px; background-color: #e8f5e9; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: #4caf50;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 8px;">Orders Pending</div>
                                <div style="font-size: 28px; font-weight: 600; color: #333;"><?php echo $stats['pending_orders'] ?? 0; ?></div>
                            </div>
                            <div style="width: 40px; height: 40px; background-color: #fff3e0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: #ff9800;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 8px;">Completed Orders</div>
                                <div style="font-size: 28px; font-weight: 600; color: #333;"><?php echo $stats['completed_orders'] ?? 0; ?></div>
                            </div>
                            <div style="width: 40px; height: 40px; background-color: #e3f2fd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: #2196f3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 8px;">Inventory Status</div>
                                <div style="font-size: 28px; font-weight: 600; color: #333;"><?php echo number_format($inventorySummary['full_bottles'] ?? 0); ?> bottles</div>
                            </div>
                            <div style="width: 40px; height: 40px; background-color: #e0f7fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: #00bcd4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders and Quick Actions -->
                <div class="grid grid-cols-2" style="grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div class="card" style="padding: 24px;">
                        <h3 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 20px;">Recent Orders</h3>
                        <div>
                            <?php if (count($recentOrders) > 0): ?>
                                <?php foreach ($recentOrders as $order): ?>
                                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                                        <div>
                                            <div style="font-weight: 500; color: #333; margin-bottom: 4px;"><?php echo htmlspecialchars($order['order_code']); ?></div>
                                            <div style="font-size: 13px; color: #666;"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                                        </div>
                                        <span class="badge badge-<?php 
                                            echo $order['order_status'] == 'Pending' ? 'warning' : 
                                                 ($order['order_status'] == 'Completed' ? 'success' : 'info'); 
                                        ?>"><?php echo htmlspecialchars($order['order_status']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="text-align: center; color: #666; padding: 20px;">No orders yet</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card" style="padding: 24px;">
                        <h3 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 20px;">Quick Actions</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <a href="orders.php" style="width: 100%; padding: 14px; background-color: #e3f2fd; border: none; border-radius: 6px; color: #00bcd4; font-weight: 500; font-size: 14px; cursor: pointer; text-align: left; text-decoration: none; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#b3e5fc'" onmouseout="this.style.backgroundColor='#e3f2fd'">
                                Create New Order
                            </a>
                            <a href="payments.php" style="width: 100%; padding: 14px; background-color: #e8f5e9; border: none; border-radius: 6px; color: #4caf50; font-weight: 500; font-size: 14px; cursor: pointer; text-align: left; text-decoration: none; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#c8e6c9'" onmouseout="this.style.backgroundColor='#e8f5e9'">
                                Record Payment
                            </a>
                            <a href="inventory.php" style="width: 100%; padding: 14px; background-color: #e3f2fd; border: none; border-radius: 6px; color: #00bcd4; font-weight: 500; font-size: 14px; cursor: pointer; text-align: left; text-decoration: none; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#b3e5fc'" onmouseout="this.style.backgroundColor='#e3f2fd'">
                                Update Inventory
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
