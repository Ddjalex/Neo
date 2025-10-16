<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - NEO Printing and Advertising</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;700&display=swap" rel="stylesheet">
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
                <li><a href="/">Home</a></li>
                <li><a href="/services" class="active">Services</a></li>
                <li><a href="/portfolio">Portfolio</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-header">
        <canvas id="matrix-canvas"></canvas>
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
                        <?php if (!empty($service['image_path'])): ?>
                        <div class="service-image">
                            <img src="<?php echo htmlspecialchars($service['image_path']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
                        </div>
                        <?php endif; ?>
                        <div class="service-content">
                            <h3>
                                <a href="/services/<?php echo htmlspecialchars($service['slug']); ?>">
                                    <?php echo htmlspecialchars($service['title']); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                            <div class="service-item-actions">
                                <a href="/services/<?php echo htmlspecialchars($service['slug']); ?>" class="btn btn-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="footer">
        <canvas id="footer-matrix-canvas"></canvas>
        <div class="container">
            <div class="footer-content">
                <div class="footer-social">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="<?php echo htmlspecialchars(Settings::getTelegramLink()); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                        <a href="<?php echo htmlspecialchars(Settings::getWhatsAppSocialLink()); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="<?php echo htmlspecialchars(Settings::getFacebookLink()); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="<?php echo htmlspecialchars(Settings::getInstagramLink()); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> NEO Printing and Advertising. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="/assets/js/matrix.js"></script>
    <script src="/assets/js/loader.js"></script>
    <script src="/assets/js/navbar.js"></script>
</body>
</html>
