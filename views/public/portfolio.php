<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - NEO Printing and Advertising</title>
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
                <li><a href="/portfolio" class="active">Portfolio</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-header">
        <canvas id="matrix-canvas"></canvas>
        <div class="container">
            <h1>Our Portfolio</h1>
            <p>Showcasing our latest projects and success stories</p>
        </div>
    </section>

    <section class="portfolio-gallery">
        <div class="container">
            <?php if (empty($projects)): ?>
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p>No portfolio projects yet. Check back soon!</p>
            </div>
            <?php else: ?>
            <div class="portfolio-grid">
                <?php foreach ($projects as $project): ?>
                <div class="portfolio-item">
                    <?php if ($project['image_path']): ?>
                    <img src="<?php echo htmlspecialchars($project['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                    <?php else: ?>
                    <div class="portfolio-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                    <?php endif; ?>
                    <div class="portfolio-info">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p><?php echo htmlspecialchars($project['description']); ?></p>
                        <?php if ($project['category']): ?>
                        <span class="portfolio-category"><?php echo htmlspecialchars($project['category']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
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
