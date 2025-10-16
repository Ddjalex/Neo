<?php $sessionParam = '?ADMIN_SESSION=' . session_id(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - Admin</title>
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
                <a href="/admin/services<?php echo $sessionParam; ?>" class="nav-item active">
                    <i class="fas fa-briefcase"></i> Services
                </a>
                <a href="/admin/portfolio<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-images"></i> Portfolio
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
                <h1>Manage Services</h1>
                <button class="btn btn-primary" onclick="openModal('addServiceModal')">
                    <i class="fas fa-plus"></i> Add Service
                </button>
            </div>
            
            <?php if (!empty($flash['message'])): ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
            <?php endif; ?>
            
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($service['category']); ?></td>
                            <td><?php echo htmlspecialchars($service['title']); ?></td>
                            <td><?php echo htmlspecialchars(substr($service['description'], 0, 60)); ?>...</td>
                            <td><?php echo $service['order_position']; ?></td>
                            <td class="actions">
                                <button class="btn-icon" onclick='editService(<?php echo json_encode($service); ?>)'>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="/admin/services/delete<?php echo $sessionParam; ?>" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                                    <button type="submit" class="btn-icon btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="addServiceModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addServiceModal')">&times;</span>
            <h2>Add New Service</h2>
            <form method="POST" action="/admin/services/create<?php echo $sessionParam; ?>" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Service Image</label>
                    <input type="file" name="service_image" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Order Position</label>
                    <input type="number" name="order_position" value="0">
                </div>
                <button type="submit" class="btn btn-primary">Add Service</button>
            </form>
        </div>
    </div>

    <div id="editServiceModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editServiceModal')">&times;</span>
            <h2>Edit Service</h2>
            <form method="POST" action="/admin/services/update<?php echo $sessionParam; ?>" id="editServiceForm" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="current_image" id="edit_current_image">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" id="edit_category" required>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" id="edit_title" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Service Image</label>
                    <div id="edit_current_image_preview" style="margin-bottom: 10px;"></div>
                    <input type="file" name="service_image" accept="image/*">
                    <small>Leave empty to keep current image</small>
                </div>
                <div class="form-group">
                    <label>Order Position</label>
                    <input type="number" name="order_position" id="edit_order_position">
                </div>
                <button type="submit" class="btn btn-primary">Update Service</button>
            </form>
        </div>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
