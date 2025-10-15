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
            $this->redirect('/admin/login');
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
        $this->redirect('/admin/login');
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
            
            $serviceModel = new Service();
            $serviceModel->create($category, $title, $description, $order_position);
            
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
            
            $serviceModel = new Service();
            $serviceModel->update($id, $category, $title, $description, $order_position);
            
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
        $whatsapp_number = $settingsModel->get('whatsapp_number') ?: '251911234567';
        $csrf_token = $this->generateCSRFToken();
        $message = '';
        $message_type = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRFToken();
            
            $new_whatsapp = trim($_POST['whatsapp_number'] ?? '');
            
            if (empty($new_whatsapp)) {
                $message = 'WhatsApp number cannot be empty';
                $message_type = 'error';
            } elseif (!preg_match('/^[0-9]{10,15}$/', $new_whatsapp)) {
                $message = 'Please enter a valid WhatsApp number (10-15 digits, no spaces or special characters)';
                $message_type = 'error';
            } else {
                if ($settingsModel->set('whatsapp_number', $new_whatsapp)) {
                    $whatsapp_number = $new_whatsapp;
                    $message = 'WhatsApp number updated successfully!';
                    $message_type = 'success';
                } else {
                    $message = 'Failed to update WhatsApp number';
                    $message_type = 'error';
                }
            }
        }
        
        require __DIR__ . '/../views/admin/settings.php';
    }
}
