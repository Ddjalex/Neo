<?php
class AdminUser {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM admin_users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
