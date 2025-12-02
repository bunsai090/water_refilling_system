<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Water Refilling Station</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../views/components/header.php'; ?>
        
        <div class="dashboard-main">
            <?php include '../views/components/sidebar.php'; ?>
            
            <main class="main-content">
                <div class="page-header mb-6">
                    <h1 class="page-title">Profile</h1>
                    <p class="page-description">Manage your account settings</p>
                </div>

                <div class="grid lg:grid-cols-3">
                    <!-- Profile Card -->
                    <div class="card" style="grid-column: span 1;">
                        <div class="text-center">
                            <div class="profile-avatar-large">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="profile-name">Admin User</h3>
                            <p class="profile-role">Administrator</p>
                            <button class="btn btn-outline w-full mt-4">Change Photo</button>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="card" style="grid-column: span 2;">
                        <div class="card-header">
                            <h3 class="card-title">Personal Information</h3>
                        </div>
                        <form class="space-y-4">
                            <div class="grid md:grid-cols-2">
                                <div class="form-group">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-input" value="Admin">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-input" value="User">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" value="admin@waterstation.com">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-input" value="0917-123-4567">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-input" value="123 Main Street, Manila">
                            </div>
                            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; padding-top: 1rem;">
                                <button type="button" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="card" style="grid-column: span 3;">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <form class="space-y-4" style="max-width: 48rem;">
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-input">
                            </div>
                            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; padding-top: 1rem;">
                                <button type="button" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
