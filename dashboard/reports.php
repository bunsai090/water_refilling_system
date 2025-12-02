<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Water Refilling Station</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../views/components/header.php'; ?>
        
        <div class="dashboard-main">
            <?php include '../views/components/sidebar.php'; ?>
            
            <main class="main-content">
                <div class="page-header mb-6">
                    <h1 class="page-title">Reports</h1>
                    <p class="page-description">Generate and download business reports</p>
                </div>

                <!-- Report Types -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 mb-6">
                    <div class="card report-card">
                        <div class="report-icon bg-green-50">
                            <svg class="text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="report-title">Daily Sales Report</h3>
                        <p class="report-description">View sales performance for today</p>
                        <button class="btn btn-outline w-full">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Report
                        </button>
                    </div>

                    <div class="card report-card">
                        <div class="report-icon bg-blue-50">
                            <svg class="text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="report-title">Order Summary Report</h3>
                        <p class="report-description">Complete order history and analytics</p>
                        <button class="btn btn-outline w-full">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Report
                        </button>
                    </div>

                    <div class="card report-card">
                        <div class="report-icon bg-sky-50">
                            <svg class="text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="report-title">Inventory Report</h3>
                        <p class="report-description">Stock levels and movement tracking</p>
                        <button class="btn btn-outline w-full">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Report
                        </button>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Reports</h3>
                    </div>
                    <ul class="space-y-3">
                        <li style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p style="font-weight: 500; color: #1f2937;">Sales Report - Jan 1, 2024</p>
                                    <p style="font-size: 0.875rem; color: #6b7280;">Generated 2 hours ago</p>
                                </div>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                        </li>
                        <li style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p style="font-weight: 500; color: #1f2937;">Sales Report - Jan 2, 2024</p>
                                    <p style="font-size: 0.875rem; color: #6b7280;">Generated 2 hours ago</p>
                                </div>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                        </li>
                        <li style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p style="font-weight: 500; color: #1f2937;">Sales Report - Jan 3, 2024</p>
                                    <p style="font-size: 0.875rem; color: #6b7280;">Generated 2 hours ago</p>
                                </div>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
