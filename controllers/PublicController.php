<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Portfolio.php';
require_once __DIR__ . '/../models/ContactLead.php';
require_once __DIR__ . '/../models/BlogPost.php';
require_once __DIR__ . '/../models/SiteSettings.php';

class PublicController {
    
    public function home() {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        $categories = $serviceModel->getCategories();
        
        require __DIR__ . '/../views/public/home.php';
    }
    
    public function services() {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        $categories = $serviceModel->getCategories();
        
        $grouped_services = [];
        foreach ($services as $service) {
            $grouped_services[$service['category']][] = $service;
        }
        
        require __DIR__ . '/../views/public/services.php';
    }
    
    public function portfolio() {
        $portfolioModel = new Portfolio();
        $projects = $portfolioModel->getAll();
        
        require __DIR__ . '/../views/public/portfolio.php';
    }
    
    public function contact() {
        $message = '';
        $message_type = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars(trim($_POST['name'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
            $msg = htmlspecialchars(trim($_POST['message'] ?? ''));
            
            if (empty($name) || empty($email) || empty($msg)) {
                $message = 'Please fill in all required fields.';
                $message_type = 'error';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Please enter a valid email address.';
                $message_type = 'error';
            } else {
                $contactModel = new ContactLead();
                if ($contactModel->create($name, $email, $phone, $msg)) {
                    $message = 'Thank you for contacting us! We will get back to you soon.';
                    $message_type = 'success';
                } else {
                    $message = 'Sorry, there was an error submitting your message. Please try again.';
                    $message_type = 'error';
                }
            }
        }
        
        require __DIR__ . '/../views/public/contact.php';
    }
    
    public function blog() {
        $blogModel = new BlogPost();
        $posts = $blogModel->getAll('published');
        
        require __DIR__ . '/../views/public/blog.php';
    }
    
    public function blogPost($slug) {
        $blogModel = new BlogPost();
        $post = $blogModel->getBySlug($slug);
        
        if (!$post) {
            header("HTTP/1.0 404 Not Found");
            echo "Blog post not found";
            exit;
        }
        
        require __DIR__ . '/../views/public/blog_post.php';
    }
    
    public function about() {
        $settingsModel = new SiteSettings();
        $about_title = $settingsModel->get('about_title') ?: 'About Us';
        $about_content = $settingsModel->get('about_content') ?: '';
        
        require __DIR__ . '/../views/public/about.php';
    }
}
