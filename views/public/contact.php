<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - NEO Printing and Advertising</title>
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
                <li><a href="/contact" class="active">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-header">
        <canvas id="matrix-canvas"></canvas>
        <div class="container">
            <h1>Contact Us</h1>
            <p>Let's discuss how we can help your business succeed</p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>
            
            <div class="contact-wrapper">
                <div class="contact-form-container">
                    <h2>Get In Touch</h2>
                    <form method="POST" action="/contact" class="contact-form">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
                
                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@neoprinting.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Phone</h4>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Location</h4>
                            <p>Your City, State</p>
                        </div>
                    </div>
                </div>
            </div>
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
