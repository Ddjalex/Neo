<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - NEO Printing and Advertising</title>
    
    <meta name="description" content="<?php echo Settings::createMetaDescription($post['content']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($post['title']); ?>, NEO Printing, Advertising Blog, <?php echo htmlspecialchars($post['author']); ?>, Digital Marketing Ethiopia, Printing News">
    <meta name="author" content="<?php echo htmlspecialchars($post['author']); ?>">
    
    <meta property="og:title" content="<?php echo htmlspecialchars($post['title']); ?>">
    <meta property="og:description" content="<?php echo Settings::createMetaDescription($post['content']); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo Settings::getBaseUrl(); ?>/blog/<?php echo htmlspecialchars($post['slug']); ?>">
    <meta property="og:site_name" content="NEO Printing and Advertising">
    <meta property="og:image" content="<?php echo Settings::getBaseUrl() . ($post['featured_image'] ? htmlspecialchars($post['featured_image']) : Settings::getDefaultOGImage()); ?>">
    <meta property="article:published_time" content="<?php echo date('c', strtotime($post['published_at'])); ?>">
    <meta property="article:author" content="<?php echo htmlspecialchars($post['author']); ?>">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($post['title']); ?>">
    <meta name="twitter:description" content="<?php echo Settings::createMetaDescription($post['content']); ?>">
    <meta name="twitter:image" content="<?php echo Settings::getBaseUrl() . ($post['featured_image'] ? htmlspecialchars($post['featured_image']) : Settings::getDefaultOGImage()); ?>">
    
    <link rel="canonical" href="<?php echo Settings::getBaseUrl(); ?>/blog/<?php echo htmlspecialchars($post['slug']); ?>">
    
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
                <li><a href="/blog" class="active">Blog</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <article class="blog-post-single">
        <div class="container">
            <div class="post-header">
                <a href="/blog" class="back-link"><i class="fas fa-arrow-left"></i> Back to Blog</a>
                <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                <div class="post-meta">
                    <span class="post-author"><i class="fas fa-user"></i> <?php echo htmlspecialchars($post['author']); ?></span>
                    <span class="post-date"><i class="fas fa-calendar"></i> <?php echo date('F d, Y', strtotime($post['published_at'])); ?></span>
                </div>
            </div>

            <?php if ($post['featured_image']): ?>
            <div class="post-featured-image">
                <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                     alt="<?php echo htmlspecialchars($post['title']); ?>">
            </div>
            <?php endif; ?>

            <div class="post-content">
                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
            </div>

            <div class="post-footer">
                <a href="/blog" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to All Posts</a>
            </div>
        </div>
    </article>

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
