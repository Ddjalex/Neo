<?php $sessionParam = '?ADMIN_SESSION=' . session_id(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin</title>
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
                <a href="/admin/about<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-info-circle"></i> About
                </a>
                <a href="/admin/leads<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-envelope"></i> Leads
                </a>
                <a href="/admin/settings<?php echo $sessionParam; ?>" class="nav-item active">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="/admin/logout<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>Site Settings</h1>
            </div>
            
            <?php if (!empty($flash['message'])): ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
            <?php endif; ?>
            
            <div class="settings-container">
                <div class="settings-card">
                    <h2><i class="fas fa-address-book"></i> Contact Information</h2>
                    <form method="POST" action="/admin/settings<?php echo $sessionParam; ?>" class="settings-form">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                        <input type="hidden" name="action" value="update_settings">
                        
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" id="company_name" name="company_name" 
                                   value="<?php echo htmlspecialchars($settings['company_name'] ?? 'NEO Printing and Advertising'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_email">Email Address</label>
                            <input type="email" id="contact_email" name="contact_email" 
                                   value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_phone">Phone Number</label>
                            <input type="text" id="contact_phone" name="contact_phone" 
                                   value="<?php echo htmlspecialchars($settings['contact_phone'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_address">Address</label>
                            <textarea id="contact_address" name="contact_address" rows="3" required><?php echo htmlspecialchars($settings['contact_address'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="whatsapp_number">WhatsApp Number (numbers only, e.g., 251911234567)</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" 
                                   value="<?php echo htmlspecialchars($settings['whatsapp_number'] ?? ''); ?>" 
                                   pattern="[0-9]{10,15}" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Contact Settings
                        </button>
                    </form>
                </div>
                
                <div class="settings-card">
                    <h2><i class="fas fa-share-alt"></i> Social Media Links</h2>
                    <form method="POST" action="/admin/settings<?php echo $sessionParam; ?>" class="settings-form">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                        <input type="hidden" name="action" value="update_social">
                        
                        <div class="form-group">
                            <label for="telegram_link"><i class="fab fa-telegram"></i> Telegram Link</label>
                            <input type="url" id="telegram_link" name="telegram_link" 
                                   value="<?php echo htmlspecialchars($settings['telegram_link'] ?? ''); ?>" 
                                   placeholder="https://t.me/neoprinting">
                            <small>Example: https://t.me/neoprinting</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="facebook_link"><i class="fab fa-facebook"></i> Facebook Link</label>
                            <input type="url" id="facebook_link" name="facebook_link" 
                                   value="<?php echo htmlspecialchars($settings['facebook_link'] ?? ''); ?>" 
                                   placeholder="https://facebook.com/neoprinting">
                            <small>Example: https://facebook.com/neoprinting</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="instagram_link"><i class="fab fa-instagram"></i> Instagram Link</label>
                            <input type="url" id="instagram_link" name="instagram_link" 
                                   value="<?php echo htmlspecialchars($settings['instagram_link'] ?? ''); ?>" 
                                   placeholder="https://instagram.com/neoprinting">
                            <small>Example: https://instagram.com/neoprinting</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Social Media Links
                        </button>
                    </form>
                </div>
                
                <div class="settings-card">
                    <h2><i class="fas fa-lock"></i> Change Password</h2>
                    <form method="POST" action="/admin/settings<?php echo $sessionParam; ?>" class="settings-form">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                        <input type="hidden" name="action" value="change_password">
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" required minlength="6">
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
