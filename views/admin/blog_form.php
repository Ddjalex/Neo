<?php 
$sessionParam = '?ADMIN_SESSION=' . session_id();
$isEdit = isset($post);
$pageTitle = $isEdit ? 'Edit Post' : 'New Post';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Admin</title>
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
                <a href="/admin/blog<?php echo $sessionParam; ?>" class="nav-item active">
                    <i class="fas fa-blog"></i> Blog
                </a>
                <a href="/admin/about<?php echo $sessionParam; ?>" class="nav-item">
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
                <h1><?php echo $pageTitle; ?></h1>
                <a href="/admin/blog<?php echo $sessionParam; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Blog
                </a>
            </div>
            
            <form method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                
                <div class="form-group">
                    <label for="title">Post Title *</label>
                    <input type="text" id="title" name="title" 
                           value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="excerpt">Excerpt (Short Description)</label>
                    <textarea id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="content">Content *</label>
                    <textarea id="content" name="content" rows="15" required><?php echo htmlspecialchars($post['content'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="featured_image">Featured Image</label>
                    <?php if ($isEdit && $post['featured_image']): ?>
                    <div class="current-image">
                        <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="Current featured image" style="max-width: 300px; margin-bottom: 10px;">
                    </div>
                    <?php endif; ?>
                    <input type="file" id="featured_image" name="featured_image" accept="image/*">
                </div>
                
                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="draft" <?php echo (!$isEdit || $post['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                        <option value="published" <?php echo ($isEdit && $post['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $isEdit ? 'Update' : 'Create'; ?> Post
                    </button>
                    <a href="/admin/blog<?php echo $sessionParam; ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </main>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
