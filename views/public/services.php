<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - NEO Printing and Advertising</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <canvas id="matrix-canvas"></canvas>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <img src="/assets/images/logo.png" alt="NEO Printing and Advertising" class="logo">
            </div>
            <ul class="nav-menu">
                <li><a href="/">Home</a></li>
                <li><a href="/services" class="active">Services</a></li>
                <li><a href="/portfolio">Portfolio</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-header">
        <div class="container">
            <h1>Our Services</h1>
            <p>Comprehensive digital marketing and technology solutions for your business</p>
        </div>
    </section>

    <section class="services-detail">
        <div class="container">
            <?php foreach ($grouped_services as $category => $category_services): ?>
            <div class="service-category">
                <h2 class="category-title"><?php echo htmlspecialchars($category); ?></h2>
                <div class="service-list">
                    <?php foreach ($category_services as $service): ?>
                    <div class="service-item">
                        <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                        <p><?php echo htmlspecialchars($service['description']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Interested in Our Services?</h2>
            <p>Get in touch to discuss how we can help your business grow</p>
            <a href="/contact" class="btn btn-primary">Contact Us</a>
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
