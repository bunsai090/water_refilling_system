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
                <div class="grid md:grid-cols-3 mb-8">
                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>Full Bottles</h3>
                                <p style="font-size: 1.875rem;">156</p>
                            </div>
                            <div class="stat-icon bg-green-50">
                                <svg style="width: 2rem; height: 2rem;" class="text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>Empty Bottles</h3>
                                <p style="font-size: 1.875rem;">42</p>
                            </div>
                            <div class="stat-icon bg-yellow-50">
                                <svg style="width: 2rem; height: 2rem;" class="text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-info">
                                <h3>Water Stock</h3>
                                <p style="font-size: 1.875rem;">2,450</p>
                                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">gallons</p>
                            </div>
                            <div class="stat-icon bg-sky-50">
                                <svg style="width: 2rem; height: 2rem;" class="text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inventory Actions</h3>
                    </div>
                    <div class="grid md:grid-cols-2">
                        <button class="btn btn-primary w-full">Add Stock</button>
                        <button class="btn btn-secondary w-full">Update Inventory</button>
                        <button class="btn btn-success w-full">Record Return</button>
                        <button class="btn btn-outline w-full">View History</button>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
