<?php $sessionParam = '?ADMIN_SESSION=' . session_id(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leads - Admin</title>
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
                <a href="/admin/leads<?php echo $sessionParam; ?>" class="nav-item active">
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
                <h1>Contact Leads</h1>
            </div>
            
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td><?php echo date('M d, Y', strtotime($lead['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($lead['name']); ?></td>
                            <td><?php echo htmlspecialchars($lead['email']); ?></td>
                            <td><?php echo htmlspecialchars($lead['phone']); ?></td>
                            <td><?php echo htmlspecialchars(substr($lead['message'], 0, 50)); ?>...</td>
                            <td>
                                <span class="status-badge status-<?php echo $lead['status']; ?>">
                                    <?php echo ucfirst($lead['status']); ?>
                                </span>
                            </td>
                            <td class="actions">
                                <button class="btn-icon" onclick='viewLead(<?php echo json_encode($lead); ?>)'>
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form method="POST" action="/admin/leads/delete<?php echo $sessionParam; ?>" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $lead['id']; ?>">
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

    <div id="viewLeadModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('viewLeadModal')">&times;</span>
            <h2>Lead Details</h2>
            <div class="lead-details">
                <p><strong>Name:</strong> <span id="view_name"></span></p>
                <p><strong>Email:</strong> <span id="view_email"></span></p>
                <p><strong>Phone:</strong> <span id="view_phone"></span></p>
                <p><strong>Date:</strong> <span id="view_date"></span></p>
                <p><strong>Message:</strong></p>
                <p id="view_message" class="message-text"></p>
                
                <form method="POST" action="/admin/leads/update-status<?php echo $sessionParam; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    <input type="hidden" name="ADMIN_SESSION" value="<?php echo session_id(); ?>">
                    <input type="hidden" name="id" id="lead_id">
                    <div class="form-group">
                        <label>Update Status</label>
                        <select name="status" id="lead_status">
                            <option value="new">New</option>
                            <option value="contacted">Contacted</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
