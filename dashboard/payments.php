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
                                    <th>RECEIPT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>PAY-001</td>
                                    <td>ORD-1001</td>
                                    <td>Juan Dela Cruz</td>
                                    <td>Cash</td>
                                    <td>₱50</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="action-btn">
                                            <svg style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PAY-002</td>
                                    <td>ORD-1002</td>
                                    <td>Maria Santos</td>
                                    <td>GCash</td>
                                    <td>₱250</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="action-btn">
                                            <svg style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PAY-003</td>
                                    <td>ORD-1003</td>
                                    <td>Pedro Garcia</td>
                                    <td>Cash</td>
                                    <td>₱50</td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="action-btn">
                                            <svg style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
