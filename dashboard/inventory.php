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

// Get inventory summary and all items
$summary = $inventoryModel->getSummary();
$inventory_items = $inventoryModel->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Water Refilling Station</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../views/components/header.php'; ?>
        
        <div class="dashboard-main">
            <?php include '../views/components/sidebar.php'; ?>
            
            <main class="main-content">
                <div class="page-header mb-6">
                    <h1 class="page-title">Inventory</h1>
                    <p class="page-description">Monitor your stock levels</p>
                </div>

                <!-- Inventory Stats -->
                <div class="grid grid-cols-3 mb-8">
                    <div class="inventory-stat">
                        <div class="stat-label">Full Bottles</div>
                        <div class="stat-value">
                            <span><?php echo number_format($summary['full_bottles'] ?? 0); ?></span>
                            <svg class="stat-icon icon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>

                    <div class="inventory-stat">
                        <div class="stat-label">Empty Bottles</div>
                        <div class="stat-value">
                            <span><?php echo number_format($summary['empty_bottles'] ?? 0); ?></span>
                            <svg class="stat-icon icon-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>

                    <div class="inventory-stat">
                        <div class="stat-label">Water Stock</div>
                        <div class="stat-value">
                            <span><?php echo number_format($summary['water_stock'] ?? 0); ?> gallons</span>
                            <svg class="stat-icon icon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Inventory Table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Items</h3>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ITEM NAME</th>
                                    <th>TYPE</th>
                                    <th>QUANTITY</th>
                                    <th>UNIT</th>
                                    <th>PRICE</th>
                                    <th>STATUS</th>
                                    <th>LAST UPDATED</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($inventory_items) > 0): ?>
                                    <?php foreach ($inventory_items as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['item_type']); ?></td>
                                            <td><strong><?php echo number_format($item['quantity']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($item['unit']); ?></td>
                                            <td>₱<?php echo number_format($item['price'], 2); ?></td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $item['status'] == 'In Stock' ? 'success' : 
                                                         ($item['status'] == 'Low Stock' ? 'warning' : 'danger'); 
                                                ?>">
                                                    <?php echo htmlspecialchars($item['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($item['last_updated'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                            No inventory items found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
