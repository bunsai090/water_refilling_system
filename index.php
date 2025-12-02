<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Refilling Station - Home</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="landing">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div style="max-width: 64rem; margin: 0 auto;">
                    <div style="display: flex; justify-content: center; margin-bottom: 1.5rem;">
                        <svg class="hero-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>

                    <h1 class="hero-title">Pure Water, Delivered Fresh</h1>

                    <p class="hero-description">
                        Your trusted water refilling station management system. Streamline
                        orders, track inventory, and manage customers with ease.
                    </p>

                    <div class="hero-buttons">
                        <a href="dashboard/index.php" class="btn btn-primary btn-lg">Order Now</a>
                        <a href="login.php" class="btn btn-outline btn-lg">Login</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <div class="features-grid">
                    <div class="feature-card">
                        <svg class="feature-icon" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="feature-title">Quality Assured</h3>
                        <p class="feature-description">
                            Premium filtered water that meets the highest quality standards
                        </p>
                    </div>

                    <div class="feature-card">
                        <svg class="feature-icon" style="color: #0ea5e9;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="feature-title">Fast Service</h3>
                        <p class="feature-description">
                            Quick refilling and delivery to keep your business running smoothly
                        </p>
                    </div>

                    <div class="feature-card">
                        <svg class="feature-icon" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h3 class="feature-title">Safe & Clean</h3>
                        <p class="feature-description">
                            Sanitized bottles and hygienic handling for your peace of mind
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <?php include 'views/components/footer.php'; ?>
    </div>
</body>
</html>
