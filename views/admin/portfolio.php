<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Portfolio - Admin</title>
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
                <a href="/admin/dashboard" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="/admin/services" class="nav-item">
                    <i class="fas fa-briefcase"></i> Services
                </a>
                <a href="/admin/portfolio" class="nav-item active">
                    <i class="fas fa-images"></i> Portfolio
                </a>
                <a href="/admin/leads" class="nav-item">
                    <i class="fas fa-envelope"></i> Leads
                </a>
                <a href="/admin/logout" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>Manage Portfolio</h1>
                <button class="btn btn-primary" onclick="openModal('addProjectModal')">
                    <i class="fas fa-plus"></i> Add Project
                </button>
            </div>
            
            <div class="portfolio-admin-grid">
                <?php foreach ($projects as $project): ?>
                <div class="portfolio-admin-card">
                    <?php if ($project['image_path']): ?>
                    <img src="<?php echo htmlspecialchars($project['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                    <?php else: ?>
                    <div class="portfolio-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                    <?php endif; ?>
                    <div class="portfolio-admin-info">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($project['description'], 0, 80)); ?>...</p>
                        <div class="portfolio-actions">
                            <button class="btn-icon" onclick='editProject(<?php echo json_encode($project); ?>)'>
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" action="/admin/portfolio/delete" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                <button type="submit" class="btn-icon btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <div id="addProjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addProjectModal')">&times;</span>
            <h2>Add New Project</h2>
            <form method="POST" action="/admin/portfolio/create" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" placeholder="e.g., Branding, Web Design">
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Project</button>
            </form>
        </div>
    </div>

    <div id="editProjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editProjectModal')">&times;</span>
            <h2>Edit Project</h2>
            <form method="POST" action="/admin/portfolio/update" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="id" id="edit_project_id">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" id="edit_project_title" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_project_description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" id="edit_project_category">
                </div>
                <div class="form-group">
                    <label>Change Image (optional)</label>
                    <input type="file" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Update Project</button>
            </form>
        </div>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
