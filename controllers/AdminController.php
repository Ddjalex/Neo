<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/AdminUser.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Portfolio.php';
require_once __DIR__ . '/../models/ContactLead.php';

class AdminController {
    
    private function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
    }
    
    public function login() {
        if (isset($_SESSION['admin_id'])) {
            header('Location: /admin/dashboard');
            exit;
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $adminModel = new AdminUser();
            $user = $adminModel->authenticate($username, $password);
            
            if ($user) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                header('Location: /admin/dashboard');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        }
        
        require __DIR__ . '/../views/admin/login.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: /admin/login');
        exit;
    }
    
    public function dashboard() {
        $this->checkAuth();
        
        $serviceModel = new Service();
        $portfolioModel = new Portfolio();
        $contactModel = new ContactLead();
        
        $total_services = count($serviceModel->getAll());
        $total_projects = count($portfolioModel->getAll());
        $total_leads = count($contactModel->getAll());
        
        require __DIR__ . '/../views/admin/dashboard.php';
    }
    
    public function services() {
        $this->checkAuth();
        
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        $categories = ['Advertising', 'Management', 'Creative', 'Tech', 'Outreach'];
        
        require __DIR__ . '/../views/admin/services.php';
    }
    
    public function serviceCreate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = $_POST['category'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $order_position = intval($_POST['order_position'] ?? 0);
            
            $serviceModel = new Service();
            $serviceModel->create($category, $title, $description, $order_position);
            
            header('Location: /admin/services');
            exit;
        }
    }
    
    public function serviceUpdate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $category = $_POST['category'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $order_position = intval($_POST['order_position'] ?? 0);
            
            $serviceModel = new Service();
            $serviceModel->update($id, $category, $title, $description, $order_position);
            
            header('Location: /admin/services');
            exit;
        }
    }
    
    public function serviceDelete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            
            $serviceModel = new Service();
            $serviceModel->delete($id);
            
            header('Location: /admin/services');
            exit;
        }
    }
    
    public function portfolio() {
        $this->checkAuth();
        
        $portfolioModel = new Portfolio();
        $projects = $portfolioModel->getAll();
        
        require __DIR__ . '/../views/admin/portfolio.php';
    }
    
    public function portfolioCreate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            
            header('Location: /admin/portfolio');
            exit;
        }
    }
    
    public function portfolioUpdate() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            
            header('Location: /admin/portfolio');
            exit;
        }
    }
    
    public function portfolioDelete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            
            $portfolioModel = new Portfolio();
            $portfolioModel->delete($id);
            
            header('Location: /admin/portfolio');
            exit;
        }
    }
    
    public function leads() {
        $this->checkAuth();
        
        $contactModel = new ContactLead();
        $leads = $contactModel->getAll();
        
        require __DIR__ . '/../views/admin/leads.php';
    }
    
    public function leadUpdateStatus() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $status = $_POST['status'] ?? 'new';
            
            $contactModel = new ContactLead();
            $contactModel->updateStatus($id, $status);
            
            header('Location: /admin/leads');
            exit;
        }
    }
    
    public function leadDelete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            
            $contactModel = new ContactLead();
            $contactModel->delete($id);
            
            header('Location: /admin/leads');
            exit;
        }
    }
}
