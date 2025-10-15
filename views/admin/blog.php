<?php $sessionParam = '?ADMIN_SESSION=' . session_id(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts - Admin</title>
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
                <h1>Blog Posts</h1>
                <a href="/admin/blog/create<?php echo $sessionParam; ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Post
                </a>
            </div>
            
            <?php if (!empty($flash['message'])): ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
            <?php endif; ?>
            
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                <?php if ($post['excerpt']): ?>
                                <br><small><?php echo htmlspecialchars(substr($post['excerpt'], 0, 100)); ?>...</small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($post['author']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $post['status'] === 'published' ? 'success' : 'warning'; ?>">
                                    <?php echo ucfirst($post['status']); ?>
                                </span>
                            </td>
                            <td><?php echo $post['published_at'] ? date('M d, Y', strtotime($post['published_at'])) : 'Not published'; ?></td>
                            <td class="actions">
                                <a href="/admin/blog/edit<?php echo $sessionParam; ?>&id=<?php echo $post['id']; ?>" class="btn-icon btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="/admin/blog/delete<?php echo $sessionParam; ?>" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                    <button type="submit" class="btn-icon btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($posts)): ?>
                        <tr>
                            <td colspan="5" class="text-center">No blog posts yet. Create your first post!</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
