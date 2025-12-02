<?php
require_once '../config/database.php';
require_once '../models/Order.php';
require_once '../models/Customer.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get database connection
$conn = getDBConnection();

// Create model instances
$orderModel = new Order($conn);
$customerModel = new Customer($conn);

// Get all orders and customers
$orders = $orderModel->getAll();
$customers = $customerModel->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Water Refilling Station</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../views/components/header.php'; ?>
        
        <div class="dashboard-main">
            <?php include '../views/components/sidebar.php'; ?>
            
            <main class="main-content">
                <div class="page-header mb-6">
                    <h1 class="page-title">Orders</h1>
                    <p class="page-description">Manage all customer orders</p>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div style="background:#d1fae5;padding:12px 20px;border-radius:6px;margin-bottom:20px;color:#065f46;">
                        ✅ Order created successfully!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div style="background:#fee2e2;padding:12px 20px;border-radius:6px;margin-bottom:20px;color:#991b1b;">
                        <?php if ($_GET['error'] == 'insufficient_stock'): ?>
                            ⚠️ Insufficient stock for <?php echo htmlspecialchars($_GET['type'] ?? 'item'); ?>! Only <?php echo $_GET['available'] ?? 0; ?> available.
                        <?php elseif ($_GET['error'] == 'no_inventory'): ?>
                            ⚠️ No "<?php echo htmlspecialchars($_GET['type'] ?? 'item'); ?>" found in inventory! Please add this item first.
                        <?php else: ?>
                            ❌ Failed to create order. Please try again.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <button class="btn btn-primary" onclick="openCreateOrderModal()">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create New Order
                        </button>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>CUSTOMER</th>
                                    <th>TYPE</th>
                                    <th>QUANTITY</th>
                                    <th>STATUS</th>
                                    <th>PAYMENT</th>
                                    <th>AMOUNT</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($orders) > 0): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order['order_code']); ?></td>
                                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                            <td><?php echo htmlspecialchars($order['order_type']); ?></td>
                                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $order['order_status'] == 'Pending' ? 'warning' : 
                                                         ($order['order_status'] == 'Completed' ? 'success' : 'info'); 
                                                ?>">
                                                    <?php echo htmlspecialchars($order['order_status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $order['payment_status'] == 'Unpaid' ? 'danger' : 
                                                         ($order['payment_status'] == 'Paid' ? 'success' : 'warning'); 
                                                ?>">
                                                    <?php echo htmlspecialchars($order['payment_status']); ?>
                                                </span>
                                            </td>
                                            <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                                            <td>
                                                <div class="table-actions">
                                                    <button class="action-btn" title="Update Status" onclick="openUpdateStatusModal(<?php echo $order['order_id']; ?>, '<?php echo $order['order_code']; ?>', '<?php echo $order['order_status']; ?>', '<?php echo $order['payment_status']; ?>')">
                                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                                            No orders yet. Click "Create New Order" to add your first order.
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

    <!-- Create Order Modal -->
    <div id="createOrderModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:500px; width:90%; max-height:90vh; overflow-y:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0; font-size:24px;">Create New Order</h2>
                <button onclick="closeCreateOrderModal()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#666;">&times;</button>
            </div>

            <form id="createOrderForm" method="POST" action="../controllers/OrderController.php">
                <input type="hidden" name="action" value="create">

                <?php
                // Get available stock and prices for all types
                require_once '../models/Inventory.php';
                $inventoryModel = new Inventory($conn);
                $all_inventory = $inventoryModel->getAll();
                
                // Build inventory data for JavaScript
                $inventory_data = [];
                foreach ($all_inventory as $item) {
                    $inventory_data[$item['item_type']] = [
                        'stock' => $item['quantity'],
                        'price' => $item['price']
                    ];
                }
                $inventory_json = json_encode($inventory_data);
                ?>

                <script>
                    const inventoryData = <?php echo $inventory_json; ?>;
                </script>

                <div style="background:#f0f9ff;padding:12px;border-radius:6px;margin-bottom:15px;border-left:4px solid #0ea5e9;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                        <strong>Available Stock:</strong>
                        <span id="displayStock">-</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <strong>Unit Price:</strong>
                        <span id="displayPrice">-</span>
                    </div>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Customer *</label>
                    <select name="customer_id" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer['customer_id']; ?>">
                                <?php echo htmlspecialchars($customer['full_name']); ?> (<?php echo htmlspecialchars($customer['customer_code']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Order Type *</label>
                    <select name="order_type" id="orderType" required onchange="updatePriceFromInventory()" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="">Select Type</option>
                        <option value="Full Bottle">Full Bottle (Refill/New)</option>
                        <option value="Small Gallon">Small Gallon</option>
                        <option value="Water Stock">Water Stock (Gallons)</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Quantity *</label>
                    <input type="number" name="quantity" id="orderQuantity" min="1" value="1" required onchange="calculateTotal()" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Unit Price (₱) *</label>
                    <input type="number" name="unit_price" id="unitPrice" min="0" step="0.01" value="0.00" required onchange="calculateTotal()" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="background:#f9fafb;padding:12px;border-radius:6px;margin-bottom:15px;">
                    <div style="display:flex;justify-content:space-between;font-size:16px;">
                        <strong>Total Amount:</strong>
                        <strong style="color:#0ea5e9;">₱<span id="totalAmount">0.00</span></strong>
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Notes</label>
                    <textarea name="notes" rows="3" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;" placeholder="Optional notes..."></textarea>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="closeCreateOrderModal()" style="padding:10px 20px; background:#e5e7eb; border:none; border-radius:6px; cursor:pointer;">
                        Cancel
                    </button>
                    <button type="submit" style="padding:10px 20px; background:#0ea5e9; color:white; border:none; border-radius:6px; cursor:pointer;">
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div id="updateStatusModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:400px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0; font-size:20px;">Update Order Status</h2>
                <button onclick="closeUpdateStatusModal()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#666;">&times;</button>
            </div>

            <form method="POST" action="../controllers/OrderController.php">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="order_id" id="updateOrderId">

                <div style="margin-bottom:15px; padding:10px; background:#f3f4f6; border-radius:6px;">
                    <strong>Order:</strong> <span id="updateOrderCode"></span>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Order Status *</label>
                    <select name="order_status" id="updateOrderStatus" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Payment Status *</label>
                    <select name="payment_status" id="updatePaymentStatus" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                        <option value="Unpaid">Unpaid</option>
                        <option value="Partial">Partial</option>
                        <option value="Paid">Paid</option>
                    </select>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="closeUpdateStatusModal()" style="padding:10px 20px; background:#e5e7eb; border:none; border-radius:6px; cursor:pointer;">
                        Cancel
                    </button>
                    <button type="submit" style="padding:10px 20px; background:#10b981; color:white; border:none; border-radius:6px; cursor:pointer;">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateOrderModal() {
            document.getElementById('createOrderModal').style.display = 'flex';
        }

        function closeCreateOrderModal() {
            document.getElementById('createOrderModal').style.display = 'none';
            // Reset form
            document.getElementById('createOrderForm').reset();
            document.getElementById('displayStock').textContent = '-';
            document.getElementById('displayPrice').textContent = '-';
            document.getElementById('totalAmount').textContent = '0.00';
        }

        function updatePriceFromInventory() {
            const orderType = document.getElementById('orderType').value;
            
            if (orderType && inventoryData[orderType]) {
                const item = inventoryData[orderType];
                
                // Update display
                document.getElementById('displayStock').textContent = item.stock + ' available';
                document.getElementById('displayPrice').textContent = '₱' + parseFloat(item.price).toFixed(2);
                
                // Auto-fill unit price
                document.getElementById('unitPrice').value = parseFloat(item.price).toFixed(2);
                
                // Calculate total
                calculateTotal();
            } else {
                document.getElementById('displayStock').textContent = '-';
                document.getElementById('displayPrice').textContent = '-';
                document.getElementById('unitPrice').value = '0.00';
                document.getElementById('totalAmount').textContent = '0.00';
            }
        }

        function calculateTotal() {
            const quantity = parseFloat(document.getElementById('orderQuantity').value) || 0;
            const unitPrice = parseFloat(document.getElementById('unitPrice').value) || 0;
            const total = quantity * unitPrice;
            
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }

        function openUpdateStatusModal(orderId, orderCode, orderStatus, paymentStatus) {
            document.getElementById('updateOrderId').value = orderId;
            document.getElementById('updateOrderCode').textContent = orderCode;
            document.getElementById('updateOrderStatus').value = orderStatus;
            document.getElementById('updatePaymentStatus').value = paymentStatus;
            document.getElementById('updateStatusModal').style.display = 'flex';
        }

        function closeUpdateStatusModal() {
            document.getElementById('updateStatusModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('createOrderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateOrderModal();
            }
        });

        document.getElementById('updateStatusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUpdateStatusModal();
            }
        });
    </script>
</body>
</html>
