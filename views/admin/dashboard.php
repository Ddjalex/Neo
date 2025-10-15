<?php $sessionParam = '?ADMIN_SESSION=' . session_id(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NEO Printing and Advertising</title>
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
                <a href="/admin/dashboard<?php echo $sessionParam; ?>" class="nav-item active">
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
                <a href="/admin/logout<?php echo $sessionParam; ?>" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-briefcase stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo $total_services; ?></h3>
                        <p>Total Services</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-images stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo $total_projects; ?></h3>
                        <p>Portfolio Projects</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-envelope stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo $total_leads; ?></h3>
                        <p>Contact Leads</p>
                    </div>
                </div>
            </div>
            
            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="/admin/services" class="btn btn-primary">Manage Services</a>
                    <a href="/admin/portfolio" class="btn btn-primary">Manage Portfolio</a>
                    <a href="/admin/leads" class="btn btn-primary">View Leads</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
