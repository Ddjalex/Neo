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
            
            <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>
            
            <div class="settings-container">
                <div class="settings-card">
                    <h2><i class="fab fa-whatsapp"></i> WhatsApp Configuration</h2>
                    <p class="settings-description">Configure the WhatsApp business number that will be used for service requests on the public website.</p>
                    
                    <form method="POST" action="/admin/settings<?php echo $sessionParam; ?>" class="settings-form">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                        
                        <div class="form-group">
                            <label for="whatsapp_number">
                                WhatsApp Number
                                <span class="label-hint">(Format: Country code + number, e.g., 251911234567 for +251 911 234 567)</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="fab fa-whatsapp"></i>
                                <input type="text" 
                                       id="whatsapp_number" 
                                       name="whatsapp_number" 
                                       value="<?php echo htmlspecialchars($whatsapp_number); ?>" 
                                       placeholder="251911234567"
                                       pattern="[0-9]{10,15}"
                                       required>
                            </div>
                            <small class="form-hint">Enter only numbers (10-15 digits). No spaces, dashes, or special characters.</small>
                        </div>
                        
                        <div class="form-preview">
                            <p><strong>Preview:</strong> +<?php echo htmlspecialchars($whatsapp_number); ?></p>
                            <p class="preview-note">This number will appear on all "Request via WhatsApp" buttons on the services page.</p>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </form>
                </div>
                
                <div class="settings-card">
                    <h2><i class="fas fa-info-circle"></i> Instructions</h2>
                    <div class="instructions">
                        <h3>How to get your WhatsApp Business number:</h3>
                        <ol>
                            <li>Use your business WhatsApp number</li>
                            <li>Include the country code (e.g., 251 for Ethiopia)</li>
                            <li>Remove all spaces, dashes, and the + sign</li>
                            <li>Enter only numbers (10-15 digits)</li>
                        </ol>
                        
                        <h3>Examples:</h3>
                        <ul>
                            <li>+251 911 234 567 → <strong>251911234567</strong></li>
                            <li>+1 (555) 123-4567 → <strong>15551234567</strong></li>
                            <li>+44 20 1234 5678 → <strong>442012345678</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
