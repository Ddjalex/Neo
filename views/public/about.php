<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($about_title); ?> - NEO Printing and Advertising</title>
    
    <meta name="description" content="<?php echo Settings::createMetaDescription($about_content); ?>">
    <meta name="keywords" content="About NEO Printing, NEO Advertising Ethiopia, Digital Marketing Company, Printing Services Ethiopia, About Us, Company Profile">
    <meta name="author" content="NEO Printing and Advertising">
    
    <meta property="og:title" content="<?php echo htmlspecialchars($about_title); ?> - NEO Printing and Advertising">
    <meta property="og:description" content="<?php echo Settings::createMetaDescription($about_content); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo Settings::getBaseUrl(); ?>/about">
    <meta property="og:site_name" content="NEO Printing and Advertising">
    <meta property="og:image" content="<?php echo Settings::getBaseUrl() . ($about_image ? htmlspecialchars($about_image) : Settings::getDefaultOGImage()); ?>">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($about_title); ?> - NEO Printing and Advertising">
    <meta name="twitter:description" content="<?php echo Settings::createMetaDescription($about_content); ?>">
    <meta name="twitter:image" content="<?php echo Settings::getBaseUrl() . ($about_image ? htmlspecialchars($about_image) : Settings::getDefaultOGImage()); ?>">
    
    <link rel="canonical" href="<?php echo Settings::getBaseUrl(); ?>/about">
    
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
                <li><a href="/services">Services</a></li>
                <li><a href="/portfolio">Portfolio</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/about" class="active">About</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-header">
        <div class="container">
            <h1><?php echo htmlspecialchars($about_title); ?></h1>
        </div>
    </section>

    <section class="about-content-section">
        <div class="container">
            <?php if ($about_image): ?>
            <div class="about-image-wrapper">
                <img src="<?php echo htmlspecialchars($about_image); ?>" alt="<?php echo htmlspecialchars($about_title); ?>" class="about-image">
            </div>
            <?php endif; ?>
            <div class="about-content">
                <?php echo nl2br(htmlspecialchars($about_content)); ?>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Ready to Work With Us?</h2>
            <p>Let's create something amazing together</p>
            <a href="/contact" class="btn btn-primary">Contact Us Today</a>
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
    <script src="/assets/js/navbar.js"></script>
</body>
</html>
