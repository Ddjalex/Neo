<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($service['title']); ?> - NEO Printing and Advertising</title>
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
            <h1><?php echo htmlspecialchars($service['title']); ?></h1>
            <p><?php echo htmlspecialchars($service['category']); ?> Service</p>
        </div>
    </section>

    <section class="service-detail-content">
        <div class="container">
            <div class="service-detail-wrapper">
                <div class="service-info">
                    <div class="service-category-badge">
                        <i class="fas fa-tag"></i> <?php echo htmlspecialchars($service['category']); ?>
                    </div>
                    
                    <h2>About This Service</h2>
                    <p class="service-description"><?php echo nl2br(htmlspecialchars($service['description'])); ?></p>
                    
                    <div class="service-actions">
                        <a href="<?php echo Settings::getWhatsAppLink($service['title']); ?>" 
                           class="btn btn-whatsapp" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fab fa-whatsapp"></i> Request via WhatsApp
                        </a>
                        <a href="/contact" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i> Contact Us
                        </a>
                    </div>
                    
                    <div class="service-back">
                        <a href="/services" class="back-link">
                            <i class="fas fa-arrow-left"></i> Back to All Services
                        </a>
                    </div>
                </div>
                
                <div class="related-services">
                    <h3>Related Services</h3>
                    <div class="related-services-list">
                        <?php foreach ($related_services as $related): ?>
                        <a href="/services/<?php echo htmlspecialchars($related['slug']); ?>" class="related-service-card">
                            <div class="related-service-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="related-service-info">
                                <h4><?php echo htmlspecialchars($related['title']); ?></h4>
                                <p><?php echo htmlspecialchars($related['category']); ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Ready to Get Started?</h2>
            <p>Contact us today to discuss your <?php echo htmlspecialchars($service['title']); ?> needs</p>
            <a href="<?php echo Settings::getWhatsAppLink($service['title']); ?>" 
               class="btn btn-primary" 
               target="_blank" 
               rel="noopener noreferrer">
                <i class="fab fa-whatsapp"></i> Chat on WhatsApp
            </a>
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
