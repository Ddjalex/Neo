<?php
class Service {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM services ORDER BY order_position ASC");
        return $stmt->fetchAll();
    }
    
    public function getByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE category = ? ORDER BY order_position ASC");
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($category, $title, $description, $order_position = 0) {
        $stmt = $this->db->prepare("INSERT INTO services (category, title, description, order_position) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$category, $title, $description, $order_position]);
    }
    
    public function update($id, $category, $title, $description, $order_position) {
        $stmt = $this->db->prepare("UPDATE services SET category = ?, title = ?, description = ?, order_position = ? WHERE id = ?");
        return $stmt->execute([$category, $title, $description, $order_position, $id]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getCategories() {
        $stmt = $this->db->query("SELECT DISTINCT category FROM services ORDER BY category ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
