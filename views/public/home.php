<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEO Printing and Advertising - Digital Marketing Solutions</title>
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
                <li><a href="/" class="active">Home</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/portfolio">Portfolio</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/about">About</a></li>
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

    <?php if (!empty($about_content)): ?>
    <section class="about-preview">
        <div class="container">
            <h2 class="section-title"><?php echo htmlspecialchars($about_title); ?></h2>
            <p class="about-text"><?php echo htmlspecialchars(substr($about_content, 0, 300)) . (strlen($about_content) > 300 ? '...' : ''); ?></p>
            <a href="/about" class="btn btn-secondary">Learn More About Us</a>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($recent_posts)): ?>
    <section class="blog-preview">
        <div class="container">
            <h2 class="section-title">Latest Blog Posts</h2>
            <div class="blog-preview-grid">
                <?php foreach ($recent_posts as $post): ?>
                <article class="blog-preview-card">
                    <?php if ($post['featured_image']): ?>
                    <div class="blog-preview-image">
                        <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                             alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="blog-preview-content">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="blog-preview-excerpt">
                            <?php echo htmlspecialchars($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 100) . '...'); ?>
                        </p>
                        <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="read-more">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="/blog" class="btn btn-secondary">View All Posts</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="cta-section">
        <div class="container">
            <h2>Ready to Elevate Your Brand?</h2>
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
                        <a href="https://t.me/neoprinting" target="_blank" rel="noopener noreferrer" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                        <a href="https://wa.me/251911234567" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://facebook.com/neoprinting" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="https://instagram.com/neoprinting" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
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
