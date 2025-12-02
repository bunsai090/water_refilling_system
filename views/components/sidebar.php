<?php
$current_page = basename($_SERVER['PHP_SELF']);
$base_path = dirname($_SERVER['PHP_SELF']) != '/' ? dirname($_SERVER['PHP_SELF']) : '';
?>
<aside class="sidebar">
    <nav class="sidebar-nav">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="<?php echo $base_path; ?>/dashboard/index.php" class="sidebar-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="<?php echo $base_path; ?>/dashboard/orders.php" class="sidebar-link <?php echo $current_page == 'orders.php' ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Orders</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="<?php echo $base_path; ?>/dashboard/payments.php" class="sidebar-link <?php echo $current_page == 'payments.php' ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span>Payments</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="<?php echo $base_path; ?>/dashboard/customers.php" class="sidebar-link <?php echo $current_page == 'customers.php' ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Customers</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="<?php echo $base_path; ?>/dashboard/inventory.php" class="sidebar-link <?php echo $current_page == 'inventory.php' ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Inventory</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="<?php echo $base_path; ?>/dashboard/reports.php" class="sidebar-link <?php echo $current_page == 'reports.php' ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Reports</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="<?php echo $base_path; ?>/dashboard/profile.php" class="sidebar-link <?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
