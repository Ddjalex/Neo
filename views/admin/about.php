<?php $sessionParam = '?ADMIN_SESSION=' . session_id(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page - Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="/assets/images/logo.png" alt="NEO Logo">
            </div>
            <nav class="sidebar-nav">
                <a href="/admin/dashboard<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="/admin/services<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-briefcase"></i> Services
                </a>
                <a href="/admin/portfolio<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-images"></i> Portfolio
                </a>
                <a href="/admin/blog<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-blog"></i> Blog
                </a>
                <a href="/admin/about<?php echo $sessionParam; ?>" class="nav-item active">
                    <i class="fas fa-info-circle"></i> About
                </a>
                <a href="/admin/leads<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-envelope"></i> Leads
                </a>
                <a href="/admin/settings<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="/admin/logout<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>About Page Management</h1>
            </div>
            
            <?php if (!empty($flash['message'])): ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
            <?php endif; ?>
            
            <div class="about-editor">
                <form method="POST" action="/admin/about<?php echo $sessionParam; ?>" class="admin-form">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                    
                    <div class="form-group">
                        <label for="about_title">Page Title</label>
                        <input type="text" id="about_title" name="about_title" 
                               value="<?php echo htmlspecialchars($about_title); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="about_content">About Content</label>
                        <textarea id="about_content" name="about_content" rows="15" required><?php echo htmlspecialchars($about_content); ?></textarea>
                        <small>This content will be displayed on the About page of your website.</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save About Page
                        </button>
                        <a href="/" target="_blank" class="btn btn-secondary">
                            <i class="fas fa-eye"></i> Preview Website
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
