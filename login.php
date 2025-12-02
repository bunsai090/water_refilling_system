<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Water Refilling Station</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-header">
                <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                    <svg class="login-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h2 class="login-title">Welcome Back</h2>
                <p class="login-subtitle">Sign in to your account</p>
            </div>

            <form action="controllers/AuthController.php" method="POST" class="space-y-6">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input" 
                        placeholder="Enter your username" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password" 
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-full">
                    Sign In
                </button>
            </form>

            <p class="login-footer">
                Water Refilling Station Management System
            </p>
        </div>
    </div>
</body>
</html>
