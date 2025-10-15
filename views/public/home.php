<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEO Printing and Advertising - Digital Marketing Solutions</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <img src="/assets/images/logo.png" alt="NEO Printing and Advertising" class="logo">
            </div>
            <ul class="nav-menu">
                <li><a href="/" class="active">Home</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/portfolio">Portfolio</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <canvas id="matrix-canvas"></canvas>
        <div class="container">
            <div class="hero-content">
                <h1>Transform Your Brand with <span class="highlight">Digital Excellence</span></h1>
                <p>NEO Printing and Advertising delivers cutting-edge digital marketing, creative design, and technology solutions to elevate your business.</p>
                <div class="hero-buttons">
                    <a href="/services" class="btn btn-primary">Explore Services</a>
                    <a href="/contact" class="btn btn-secondary">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <section class="services-overview">
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <?php
                $service_icons = [
                    'Advertising' => 'fa-bullhorn',
                    'Management' => 'fa-chart-line',
                    'Creative' => 'fa-palette',
                    'Tech' => 'fa-laptop-code',
                    'Outreach' => 'fa-envelope'
                ];
                
                foreach ($categories as $category):
                    $icon = $service_icons[$category] ?? 'fa-star';
                    $category_services = array_filter($services, function($s) use ($category) {
                        return $s['category'] === $category;
                    });
                ?>
                <div class="service-card">
                    <i class="fas <?php echo $icon; ?> service-icon"></i>
                    <h3><?php echo htmlspecialchars($category); ?></h3>
                    <ul>
                        <?php foreach (array_slice($category_services, 0, 3) as $service): ?>
                        <li><?php echo htmlspecialchars($service['title']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="/services" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Ready to Elevate Your Brand?</h2>
            <p>Let's create something amazing together</p>
            <a href="/contact" class="btn btn-primary">Contact Us Today</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> NEO Printing and Advertising. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="/assets/js/matrix.js"></script>
    <script src="/assets/js/loader.js"></script>
</body>
</html>
