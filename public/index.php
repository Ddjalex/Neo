<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . '/../controllers/PublicController.php';
require_once __DIR__ . '/../controllers/AdminController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_path = parse_url($request_uri, PHP_URL_PATH);

$publicController = new PublicController();
$adminController = new AdminController();

switch ($request_path) {
    case '/':
    case '/home':
        $publicController->home();
        break;
        
    case '/services':
        $publicController->services();
        break;
        
    case '/portfolio':
        $publicController->portfolio();
        break;
        
    case '/contact':
        $publicController->contact();
        break;
        
    case '/admin/login':
        $adminController->login();
        break;
        
    case '/admin/logout':
        $adminController->logout();
        break;
        
    case '/admin':
    case '/admin/dashboard':
        $adminController->dashboard();
        break;
        
    case '/admin/services':
        $adminController->services();
        break;
        
    case '/admin/services/create':
        $adminController->serviceCreate();
        break;
        
    case '/admin/services/update':
        $adminController->serviceUpdate();
        break;
        
    case '/admin/services/delete':
        $adminController->serviceDelete();
        break;
        
    case '/admin/portfolio':
        $adminController->portfolio();
        break;
        
    case '/admin/portfolio/create':
        $adminController->portfolioCreate();
        break;
        
    case '/admin/portfolio/update':
        $adminController->portfolioUpdate();
        break;
        
    case '/admin/portfolio/delete':
        $adminController->portfolioDelete();
        break;
        
    case '/admin/leads':
        $adminController->leads();
        break;
        
    case '/admin/leads/update-status':
        $adminController->leadUpdateStatus();
        break;
        
    case '/admin/leads/delete':
        $adminController->leadDelete();
        break;
        
    default:
        http_response_code(404);
        echo '404 - Page Not Found';
        break;
}
