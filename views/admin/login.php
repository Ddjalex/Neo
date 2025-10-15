<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NEO Printing and Advertising</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="admin-login">
    <div class="login-container">
        <div class="login-box">
            <img src="/assets/images/logo.png" alt="NEO Logo" class="login-logo">
            <h2>Admin Login</h2>
            
            <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="/admin/login<?php echo isset($_GET['ADMIN_SESSION']) ? '?ADMIN_SESSION=' . htmlspecialchars($_GET['ADMIN_SESSION']) : ''; ?>">
                <?php if (isset($_GET['ADMIN_SESSION'])): ?>
                <input type="hidden" name="ADMIN_SESSION" value="<?php echo htmlspecialchars($_GET['ADMIN_SESSION']); ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            
            <p class="login-hint">Default credentials: admin / admin123</p>
        </div>
    </div>
    
    <script src="/assets/js/loader.js"></script>
</body>
</html>
