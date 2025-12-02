<?php
require_once '../config/database.php';
require_once '../models/Customer.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get database connection
$conn = getDBConnection();
$customerModel = new Customer($conn);

// Get all customers
$customers = $customerModel->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Water Refilling Station</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../views/components/header.php'; ?>
        
        <div class="dashboard-main">
            <?php include '../views/components/sidebar.php'; ?>
            
            <main class="main-content">
                <div class="page-header mb-6">
                    <h1 class="page-title">Customers</h1>
                    <p class="page-description">Manage your customer database</p>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div style="background:#d1fae5;padding:12px 20px;border-radius:6px;margin-bottom:20px;color:#065f46;">
                        ✅ <?php echo $_GET['success'] == 'created' ? 'Customer created successfully!' : 'Customer updated successfully!'; ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <button class="btn btn-primary" onclick="openAddCustomerModal()">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Customer
                        </button>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>CUSTOMER ID</th>
                                    <th>NAME</th>
                                    <th>ADDRESS</th>
                                    <th>CONTACT</th>
                                    <th>TOTAL ORDERS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($customers) > 0): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($customer['customer_code']); ?></td>
                                            <td><?php echo htmlspecialchars($customer['full_name']); ?></td>
                                            <td><?php echo htmlspecialchars($customer['address'] ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($customer['phone'] ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($customer['total_orders']); ?></td>
                                            <td>
                                                <div class="table-actions">
                                                    <button class="action-btn" title="View">
                                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>
                                                    <button class="action-btn" title="Edit">
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
                                        <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                                            No customers yet. Click "Add Customer" to add your first customer.
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

    <!-- Add Customer Modal -->
    <div id="addCustomerModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:500px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0;">Add New Customer</h2>
                <button onclick="closeAddCustomerModal()" style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
            </div>

            <form method="POST" action="../controllers/CustomerController.php">
                <input type="hidden" name="action" value="create">

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Full Name *</label>
                    <input type="text" name="full_name" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Address</label>
                    <textarea name="address" rows="2" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;"></textarea>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Phone</label>
                    <input type="text" name="phone" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;" placeholder="0917-123-4567">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Email</label>
                    <input type="email" name="email" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="closeAddCustomerModal()" style="padding:10px 20px; background:#e5e7eb; border:none; border-radius:6px; cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:10px 20px; background:#0ea5e9; color:white; border:none; border-radius:6px; cursor:pointer;">Add Customer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddCustomerModal() {
            document.getElementById('addCustomerModal').style.display = 'flex';
        }
        function closeAddCustomerModal() {
            document.getElementById('addCustomerModal').style.display = 'none';
        }
        document.getElementById('addCustomerModal').addEventListener('click', function(e) {
            if (e.target === this) closeAddCustomerModal();
        });
    </script>
</body>
</html>
