<?php
// Configure session to work in iframe/proxy environments
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '0');
ini_set('session.use_trans_sid', '1');
ini_set('session.cookie_samesite', '');
session_name('ADMIN_SESSION');

if (isset($_GET['ADMIN_SESSION']) && !empty($_GET['ADMIN_SESSION'])) {
    session_id($_GET['ADMIN_SESSION']);
} elseif (isset($_POST['ADMIN_SESSION']) && !empty($_POST['ADMIN_SESSION'])) {
    session_id($_POST['ADMIN_SESSION']);
}

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/AdminUser.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Portfolio.php';
require_once __DIR__ . '/../models/ContactLead.php';
require_once __DIR__ . '/../models/SiteSettings.php';
require_once __DIR__ . '/../models/BlogPost.php';

class AdminController {
    
    private function redirect($url, $message = '', $type = 'success') {
        if (!empty($message)) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_type'] = $type;
        }
        $sessionId = session_id();
        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        $url = $url . $separator . 'ADMIN_SESSION=' . $sessionId;
        header('Location: ' . $url);
        exit;
    }
    
    private function getFlashMessage() {
        $message = $_SESSION['flash_message'] ?? '';
        $type = $_SESSION['flash_type'] ?? 'success';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    
    private function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('/admin');
        }
    }
    
    private function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    private function validateCSRFToken() {
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
            die('CSRF validation failed');
        }
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die('CSRF validation failed');
        }
    }
    
    private function uploadServiceImage($file) {
        if (!is_uploaded_file($file['tmp_name'])) {
            return ['error' => 'Invalid file upload.'];
        }
        
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $max_file_size = 5 * 1024 * 1024; // 5MB
        
        $file_mime = mime_content_type($file['tmp_name']);
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $file_size = $file['size'];
        
        if (!in_array($file_mime, $allowed_types)) {
            return ['error' => 'Invalid file type. Only images are allowed.'];
        }
        
        if (!in_array($file_extension, $allowed_extensions)) {
            return ['error' => 'Invalid file extension. Only jpg, jpeg, png, gif, webp are allowed.'];
        }
        
        if ($file_size > $max_file_size) {
            return ['error' => 'File size exceeds 5MB limit.'];
        }
        
        $upload_dir = __DIR__ . '/../public/uploads/services/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_name = uniqid('service_', true) . '.' . $file_extension;
        $upload_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            return ['success' => true, 'path' => '/uploads/services/' . $file_name];
        }
        
        return ['error' => 'Failed to upload image. Please try again.'];
    }
    
    public function login() {
        if (isset($_SESSION['admin_id'])) {
            $this->redirect('/admin/dashboard');
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $adminModel = new AdminUser();
            $user = $adminModel->authenticate($username, $password);
            
            if ($user) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $this->redirect('/admin/dashboard');
            } else {
                $error = 'Invalid username or password';
            }
        }
        
        require __DIR__ . '/../views/admin/login.php';
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/admin');
    }
    
    public function dashboard() {
        $this->checkAuth();
        
        $serviceModel = new Service();
        $portfolioModel = new Portfolio();
        $contactModel = new ContactLead();
        
        $total_services = count($serviceModel->getAll());
        $total_projects = count($portfolioModel->getAll());
        $total_leads = count($contactModel->getAll());
        
        $csrf_token = $this->generateCSRFToken();
        
        require __DIR__ . '/../views/admin/dashboard.php';
    }
    
    public function services() {
        $this->checkAuth();
        
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        $categories = ['Advertising', 'Management', 'Creative', 'Tech', 'Outreach'];
        $csrf_token = $this->generateCSRFToken();
        $flash = $this->getFlashMessage();
        
        require __DIR__ . '/../views/admin/services.php';
    }
    
    public function serviceCreate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $category = $_POST['category'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $order_position = intval($_POST['order_position'] ?? 0);
            
            $image_path = null;
            if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
                $upload_result = $this->uploadServiceImage($_FILES['service_image']);
                
                if (isset($upload_result['error'])) {
                    $this->redirect('/admin/services', $upload_result['error'], 'error');
                    return;
                }
                
                $image_path = $upload_result['path'];
            }
            
            $serviceModel = new Service();
            $serviceModel->create($category, $title, $description, $order_position, $image_path);
            
            $this->redirect('/admin/services', 'Service added successfully!', 'success');
        }
    }
    
    public function serviceUpdate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $id = intval($_POST['id'] ?? 0);
            $category = $_POST['category'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $order_position = intval($_POST['order_position'] ?? 0);
            
            $image_path = null;
            if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
                $upload_result = $this->uploadServiceImage($_FILES['service_image']);
                
                if (isset($upload_result['error'])) {
                    $this->redirect('/admin/services', $upload_result['error'], 'error');
                    return;
                }
                
                $image_path = $upload_result['path'];
            }
            
            $serviceModel = new Service();
            $serviceModel->update($id, $category, $title, $description, $order_position, $image_path);
            
            $this->redirect('/admin/services', 'Service updated successfully!', 'success');
        }
    }
    
    public function serviceDelete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $id = intval($_POST['id'] ?? 0);
            
            $serviceModel = new Service();
            $serviceModel->delete($id);
            
            $this->redirect('/admin/services', 'Service deleted successfully!', 'success');
        }
    }
    
    public function portfolio() {
        $this->checkAuth();
        
        $portfolioModel = new Portfolio();
        $projects = $portfolioModel->getAll();
        $csrf_token = $this->generateCSRFToken();
        $flash = $this->getFlashMessage();
        
        require __DIR__ . '/../views/admin/portfolio.php';
    }
    
    public function portfolioCreate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $category = $_POST['category'] ?? '';
            
            $image_path = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../public/assets/uploads/portfolio/';
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image_path = '/assets/uploads/portfolio/' . $file_name;
                }
            }
            
            $portfolioModel = new Portfolio();
            $portfolioModel->create($title, $description, $image_path, $category);
            
            $this->redirect('/admin/portfolio', 'Portfolio project added successfully!', 'success');
        }
    }
    
    public function portfolioUpdate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $id = intval($_POST['id'] ?? 0);
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $category = $_POST['category'] ?? '';
            
            $portfolioModel = new Portfolio();
            $project = $portfolioModel->getById($id);
            $image_path = $project['image_path'];
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../public/assets/uploads/portfolio/';
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    if ($image_path && file_exists(__DIR__ . '/../public' . $image_path)) {
                        unlink(__DIR__ . '/../public' . $image_path);
                    }
                    $image_path = '/assets/uploads/portfolio/' . $file_name;
                }
            }
            
            $portfolioModel->update($id, $title, $description, $image_path, $category);
            
            $this->redirect('/admin/portfolio', 'Portfolio project updated successfully!', 'success');
        }
    }
    
    public function portfolioDelete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $id = intval($_POST['id'] ?? 0);
            
            $portfolioModel = new Portfolio();
            $portfolioModel->delete($id);
            
            $this->redirect('/admin/portfolio', 'Portfolio project deleted successfully!', 'success');
        }
    }
    
    public function leads() {
        $this->checkAuth();
        
        $contactModel = new ContactLead();
        $leads = $contactModel->getAll();
        $csrf_token = $this->generateCSRFToken();
        $flash = $this->getFlashMessage();
        
        require __DIR__ . '/../views/admin/leads.php';
    }
    
    public function leadUpdateStatus() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $id = intval($_POST['id'] ?? 0);
            $status = $_POST['status'] ?? 'new';
            
            $contactModel = new ContactLead();
            $contactModel->updateStatus($id, $status);
            
            $this->redirect('/admin/leads', 'Lead status updated successfully!', 'success');
        }
    }
    
    public function leadDelete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $id = intval($_POST['id'] ?? 0);
            
            $contactModel = new ContactLead();
            $contactModel->delete($id);
            
            $this->redirect('/admin/leads', 'Lead deleted successfully!', 'success');
        }
    }
    
    public function settings() {
        $this->checkAuth();
        
        $settingsModel = new SiteSettings();
        $settings = $settingsModel->getAllAsArray();
        $csrf_token = $this->generateCSRFToken();
        $flash = $this->getFlashMessage();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $action = $_POST['action'] ?? '';
            
            if ($action === 'update_settings') {
                $updates = [
                    'whatsapp_number' => trim($_POST['whatsapp_number'] ?? ''),
                    'contact_email' => trim($_POST['contact_email'] ?? ''),
                    'contact_phone' => trim($_POST['contact_phone'] ?? ''),
                    'contact_address' => trim($_POST['contact_address'] ?? ''),
                    'company_name' => trim($_POST['company_name'] ?? '')
                ];
                
                if ($settingsModel->updateMultiple($updates)) {
                    $this->redirect('/admin/settings', 'Settings updated successfully!', 'success');
                } else {
                    $this->redirect('/admin/settings', 'Failed to update settings', 'error');
                }
            } elseif ($action === 'update_social') {
                $updates = [
                    'telegram_link' => trim($_POST['telegram_link'] ?? ''),
                    'facebook_link' => trim($_POST['facebook_link'] ?? ''),
                    'instagram_link' => trim($_POST['instagram_link'] ?? '')
                ];
                
                if ($settingsModel->updateMultiple($updates)) {
                    $this->redirect('/admin/settings', 'Social media links updated successfully!', 'success');
                } else {
                    $this->redirect('/admin/settings', 'Failed to update social media links', 'error');
                }
            } elseif ($action === 'change_password') {
                $current_password = $_POST['current_password'] ?? '';
                $new_password = $_POST['new_password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';
                
                if ($new_password !== $confirm_password) {
                    $this->redirect('/admin/settings', 'New passwords do not match', 'error');
                }
                
                $adminModel = new AdminUser();
                $user = $adminModel->getById($_SESSION['admin_id']);
                
                if (!password_verify($current_password, $user['password_hash'])) {
                    $this->redirect('/admin/settings', 'Current password is incorrect', 'error');
                }
                
                if ($adminModel->updatePassword($_SESSION['admin_id'], $new_password)) {
                    $this->redirect('/admin/settings', 'Password changed successfully!', 'success');
                } else {
                    $this->redirect('/admin/settings', 'Failed to change password', 'error');
                }
            }
        }
        
        require __DIR__ . '/../views/admin/settings.php';
    }
    
    public function blog() {
        $this->checkAuth();
        
        $blogModel = new BlogPost();
        $posts = $blogModel->getAll('all');
        $csrf_token = $this->generateCSRFToken();
        $flash = $this->getFlashMessage();
        
        require __DIR__ . '/../views/admin/blog.php';
    }
    
    public function blogCreate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrf_token = $this->generateCSRFToken();
            require __DIR__ . '/../views/admin/blog_form.php';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $excerpt = $_POST['excerpt'] ?? '';
            $status = $_POST['status'] ?? 'draft';
            $author = $_SESSION['admin_username'] ?? 'Admin';
            
            $blogModel = new BlogPost();
            $slug = $blogModel->generateSlug($title);
            
            $featured_image = '';
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../public/assets/uploads/blog/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                    $featured_image = '/assets/uploads/blog/' . $file_name;
                }
            }
            
            $data = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => $excerpt,
                'featured_image' => $featured_image,
                'author' => $author,
                'status' => $status
            ];
            
            $blogModel->create($data);
            $this->redirect('/admin/blog', 'Blog post created successfully!', 'success');
        }
    }
    
    public function blogEdit() {
        $this->checkAuth();
        
        $id = intval($_GET['id'] ?? 0);
        $blogModel = new BlogPost();
        $post = $blogModel->getById($id);
        
        if (!$post) {
            $this->redirect('/admin/blog', 'Blog post not found', 'error');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrf_token = $this->generateCSRFToken();
            require __DIR__ . '/../views/admin/blog_form.php';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $excerpt = $_POST['excerpt'] ?? '';
            $status = $_POST['status'] ?? 'draft';
            
            $slug = $blogModel->generateSlug($title);
            $featured_image = $post['featured_image'];
            
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../public/assets/uploads/blog/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                    if ($featured_image && file_exists(__DIR__ . '/../public' . $featured_image)) {
                        unlink(__DIR__ . '/../public' . $featured_image);
                    }
                    $featured_image = '/assets/uploads/blog/' . $file_name;
                }
            }
            
            $data = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'excerpt' => $excerpt,
                'featured_image' => $featured_image,
                'author' => $post['author'],
                'status' => $status,
                'published_at' => $post['published_at']
            ];
            
            $blogModel->update($id, $data);
            $this->redirect('/admin/blog', 'Blog post updated successfully!', 'success');
        }
    }
    
    public function blogDelete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $id = intval($_POST['id'] ?? 0);
            
            $blogModel = new BlogPost();
            $blogModel->delete($id);
            
            $this->redirect('/admin/blog', 'Blog post deleted successfully!', 'success');
        }
    }
    
    public function about() {
        $this->checkAuth();
        
        $settingsModel = new SiteSettings();
        $about_title = $settingsModel->get('about_title') ?: 'About Us';
        $about_content = $settingsModel->get('about_content') ?: '';
        $about_image = $settingsModel->get('about_image') ?: '';
        $csrf_token = $this->generateCSRFToken();
        $flash = $this->getFlashMessage();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $title = $_POST['about_title'] ?? '';
            $content = $_POST['about_content'] ?? '';
            $image_path = $about_image;
            
            if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../public/assets/uploads/about/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($_FILES['about_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['about_image']['tmp_name'], $upload_path)) {
                    if ($about_image && file_exists(__DIR__ . '/../public' . $about_image)) {
                        unlink(__DIR__ . '/../public' . $about_image);
                    }
                    $image_path = '/assets/uploads/about/' . $file_name;
                }
            }
            
            $settingsModel->set('about_title', $title);
            $settingsModel->set('about_content', $content);
            $settingsModel->set('about_image', $image_path);
            
            $this->redirect('/admin/about', 'About page updated successfully!', 'success');
        }
        
        require __DIR__ . '/../views/admin/about.php';
    }
}
