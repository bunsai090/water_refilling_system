<?php
require_once '../config/database.php';
require_once '../models/Payment.php';
require_once '../models/Order.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$conn = getDBConnection();
$paymentModel = new Payment($conn);
$orderModel = new Order($conn);

// Get all payments and unpaid orders
$payments = $paymentModel->getAll();
$orders = $orderModel->getAll();
$unpaid_orders = array_filter($orders, function($order) {
    return $order['payment_status'] != 'Paid';
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Water Refilling Station</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../views/components/header.php'; ?>
        
        <div class="dashboard-main">
            <?php include '../views/components/sidebar.php'; ?>
            
            <main class="main-content">
                <div class="page-header mb-6">
                    <h1 class="page-title">Payments</h1>
                    <p class="page-description">Track all payment transactions</p>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div style="background:#d1fae5;padding:12px 20px;border-radius:6px;margin-bottom:20px;color:#065f46;">
                        ✅ Payment recorded successfully!
                    </div>
                <?php endif; ?>

                <div style="margin-bottom:20px;">
                    <button class="btn btn-primary" onclick="openRecordPaymentModal()">
                        <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Record Payment
                    </button>
                </div>

                <div class="card">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>PAYMENT ID</th>
                                    <th>ORDER ID</th>
                                    <th>CUSTOMER</th>
                                    <th>METHOD</th>
                                    <th>AMOUNT</th>
                                    <th>STATUS</th>
                                    <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($payments) > 0): ?>
                                    <?php foreach ($payments as $payment): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($payment['payment_code']); ?></td>
                                            <td><?php echo htmlspecialchars($payment['order_code']); ?></td>
                                            <td><?php echo htmlspecialchars($payment['customer_name']); ?></td>
                                            <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                                            <td>₱<?php echo number_format($payment['amount'], 2); ?></td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $payment['payment_status'] == 'Completed' ? 'success' : 'warning'; 
                                                ?>">
                                                    <?php echo htmlspecialchars($payment['payment_status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('Y-m-d', strtotime($payment['payment_date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                            No payments recorded yet.
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

    <!-- Record Payment Modal -->
    <div id="recordPaymentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:500px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0;">Record Payment</h2>
                <button onclick="closeRecordPaymentModal()" style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
            </div>

            <form method="POST" action="../controllers/PaymentController.php">
                <input type="hidden" name="action" value="create">

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Select Order *</label>
                    <select name="order_id" id="orderSelect" required onchange="updateOrderDetails()" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="">Choose an order...</option>
                        <?php foreach ($unpaid_orders as $order): ?>
                            <option value="<?php echo $order['order_id']; ?>" 
                                    data-customer="<?php echo $order['customer_id']; ?>"
                                    data-amount="<?php echo $order['total_amount']; ?>">
                                <?php echo $order['order_code']; ?> - <?php echo $order['customer_name']; ?> (₱<?php echo number_format($order['total_amount'], 2); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" name="customer_id" id="customerId">

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Amount (₱) *</label>
                    <input type="number" name="amount" id="paymentAmount" min="0" step="0.01" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Payment Method *</label>
                    <select name="payment_method" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="Cash">Cash</option>
                        <option value="GCash">GCash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Credit Card">Credit Card</option>
                    </select>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Reference Number</label>
                    <input type="text" name="reference_number" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;" placeholder="Optional">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Notes</label>
                    <textarea name="notes" rows="2" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;"></textarea>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="closeRecordPaymentModal()" style="padding:10px 20px; background:#e5e7eb; border:none; border-radius:6px; cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:10px 20px; background:#0ea5e9; color:white; border:none; border-radius:6px; cursor:pointer;">Record Payment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRecordPaymentModal() {
            document.getElementById('recordPaymentModal').style.display = 'flex';
        }
        function closeRecordPaymentModal() {
            document.getElementById('recordPaymentModal').style.display = 'none';
        }
        function updateOrderDetails() {
            const select = document.getElementById('orderSelect');
            const option = select.options[select.selectedIndex];
            if (option.value) {
                document.getElementById('customerId').value = option.dataset.customer;
                document.getElementById('paymentAmount').value = option.dataset.amount;
            }
        }
        document.getElementById('recordPaymentModal').addEventListener('click', function(e) {
            if (e.target === this) closeRecordPaymentModal();
        });
    </script>
</body>
</html>
