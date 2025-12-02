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
                    <p class="page-description">Welcome back! Here's your business overview.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid md:grid-cols-2 lg:grid-cols-4 mb-8">
                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>Total Sales Today</h3>
                                <p>₱12,450</p>
                            </div>
                            <div class="stat-icon bg-green-50">
                                <svg class="text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>Orders Pending</h3>
                                <p>8</p>
                            </div>
                            <div class="stat-icon bg-yellow-50">
                                <svg class="text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>Completed Orders</h3>
                                <p>24</p>
                            </div>
                            <div class="stat-icon bg-blue-50">
                                <svg class="text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>Inventory Status</h3>
                                <p>156 bottles</p>
                            </div>
                            <div class="stat-icon bg-sky-50">
                                <svg class="text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders and Quick Actions -->
                <div class="grid md:grid-cols-2">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Orders</h3>
                        </div>
                        <ul class="recent-list">
                            <li class="recent-item">
                                <div>
                                    <p class="recent-item-title">Order #1001</p>
                                    <p class="recent-item-subtitle">Customer 1</p>
                                </div>
                                <span class="badge badge-warning">Pending</span>
                            </li>
                            <li class="recent-item">
                                <div>
                                    <p class="recent-item-title">Order #1002</p>
                                    <p class="recent-item-subtitle">Customer 2</p>
                                </div>
                                <span class="badge badge-warning">Pending</span>
                            </li>
                            <li class="recent-item">
                                <div>
                                    <p class="recent-item-title">Order #1003</p>
                                    <p class="recent-item-subtitle">Customer 3</p>
                                </div>
                                <span class="badge badge-warning">Pending</span>
                            </li>
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div>
                            <button class="action-card action-card-primary">
                                <p>Create New Order</p>
                            </button>
                            <button class="action-card action-card-success">
                                <p>Record Payment</p>
                            </button>
                            <button class="action-card action-card-info">
                                <p>Update Inventory</p>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
