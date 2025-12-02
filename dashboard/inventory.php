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
                        <button class="btn btn-primary" onclick="openAddItemModal()">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Item
                        </button>
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
                                    <th>ACTIONS</th>
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
                                            <td>
                                                <div class="table-actions">
                                                    <button class="action-btn" title="Update Stock" onclick="openUpdateStockModal(<?php echo $item['inventory_id']; ?>, '<?php echo htmlspecialchars($item['item_name']); ?>', <?php echo $item['quantity']; ?>)">
                                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                                            No inventory items found. Click "Add Item" to add your first inventory item.
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

    <!-- Add Item Modal -->
    <div id="addItemModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:500px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0;">Add Inventory Item</h2>
                <button onclick="closeAddItemModal()" style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
            </div>

            <form method="POST" action="../controllers/InventoryController.php">
                <input type="hidden" name="action" value="create">

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Item Name *</label>
                    <input type="text" name="item_name" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Item Type *</label>
                    <select name="item_type" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="Full Bottle">Full Bottle</option>
                        <option value="Small Gallon">Small Gallon</option>
                        <option value="Water Stock">Water Stock</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Quantity *</label>
                    <input type="number" name="quantity" min="0" value="0" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Unit *</label>
                    <input type="text" name="unit" placeholder="e.g. pcs, gallons, liters" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Price (₱) *</label>
                    <input type="number" name="price" min="0" step="0.01" value="0.00" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Reorder Level</label>
                    <input type="number" name="reorder_level" min="0" value="10" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="closeAddItemModal()" style="padding:10px 20px; background:#e5e7eb; border:none; border-radius:6px; cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:10px 20px; background:#0ea5e9; color:white; border:none; border-radius:6px; cursor:pointer;">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Stock Modal -->
    <div id="updateStockModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:400px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0; font-size:20px;">Update Stock</h2>
                <button onclick="closeUpdateStockModal()" style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
            </div>

            <form method="POST" action="../controllers/InventoryController.php">
                <input type="hidden" name="inventory_id" id="stockItemId">

                <div style="margin-bottom:15px; padding:10px; background:#f3f4f6; border-radius:6px;">
                    <strong>Item:</strong> <span id="stockItemName"></span><br>
                    <strong>Current Stock:</strong> <span id="currentStock"></span>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Action *</label>
                    <select name="action" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="add_stock">Add Stock (+)</option>
                        <option value="remove_stock">Remove Stock (-)</option>
                    </select>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Quantity *</label>
                    <input type="number" name="quantity" min="1" value="1" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Notes</label>
                    <textarea name="notes" rows="2" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;" placeholder="Reason for stock change..."></textarea>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="closeUpdateStockModal()" style="padding:10px 20px; background:#e5e7eb; border:none; border-radius:6px; cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:10px 20px; background:#10b981; color:white; border:none; border-radius:6px; cursor:pointer;">Update Stock</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddItemModal() {
            document.getElementById('addItemModal').style.display = 'flex';
        }
        function closeAddItemModal() {
            document.getElementById('addItemModal').style.display = 'none';
        }
        function openUpdateStockModal(itemId, itemName, currentQty) {
            document.getElementById('stockItemId').value = itemId;
            document.getElementById('stockItemName').textContent = itemName;
            document.getElementById('currentStock').textContent = currentQty;
            document.getElementById('updateStockModal').style.display = 'flex';
        }
        function closeUpdateStockModal() {
            document.getElementById('updateStockModal').style.display = 'none';
        }
        document.getElementById('addItemModal').addEventListener('click', function(e) {
            if (e.target === this) closeAddItemModal();
        });
        document.getElementById('updateStockModal').addEventListener('click', function(e) {
            if (e.target === this) closeUpdateStockModal();
        });
    </script>
</body>
</html>
