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
                            <span>156</span>
                            <svg class="stat-icon icon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>

                    <div class="inventory-stat">
                        <div class="stat-label">Empty Bottles</div>
                        <div class="stat-value">
                            <span>42</span>
                            <svg class="stat-icon icon-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>

                    <div class="inventory-stat">
                        <div class="stat-label">Water Stock</div>
                        <div class="stat-value">
                            <span>2,450 gallons</span>
                            <svg class="stat-icon icon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Inventory Actions -->
                <div class="card">
                    <h3 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 16px;">Inventory Actions</h3>
                    <div class="actions-grid">
                        <button class="action-button action-button-primary">Add Stock</button>
                        <button class="action-button action-button-secondary">Update Inventory</button>
                        <button class="action-button action-button-success">Record Return</button>
                        <button class="action-button action-button-secondary">View History</button>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
