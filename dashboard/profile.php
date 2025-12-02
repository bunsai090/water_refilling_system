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

                <!-- Profile Content -->
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 24px;">
                    <!-- Profile Avatar Card -->
                    <div class="card" style="padding: 40px 24px; text-align: center;">
                        <div style="width: 96px; height: 96px; background-color: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <svg style="width: 48px; height: 48px; color: #00bcd4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 600; color: #333; margin-bottom: 4px;">Admin User</h3>
                        <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Administrator</p>
                        <button class="btn btn-outline w-full">Change Photo</button>
                    </div>

                    <!-- Personal Information Card -->
                    <div class="card" style="padding: 24px;">
                        <h3 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 20px;">Personal Information</h3>
                        <form>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-input" value="Admin">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
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
                            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px;">
                                <button type="button" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Card -->
                <div class="card" style="padding: 24px;">
                    <h3 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 20px;">Change Password</h3>
                    <form style="max-width: 600px;">
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-input" placeholder="">
                        </div>
                        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px;">
                            <button type="button" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
