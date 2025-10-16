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
    
    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    public function create($category, $title, $description, $order_position = 0, $image_path = null) {
        $slug = $this->generateSlug($title);
        $stmt = $this->db->prepare("INSERT INTO services (category, title, slug, description, order_position, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$category, $title, $slug, $description, $order_position, $image_path]);
    }
    
    public function update($id, $category, $title, $description, $order_position, $image_path = null) {
        $slug = $this->generateSlug($title, $id);
        
        if ($image_path !== null) {
            $stmt = $this->db->prepare("UPDATE services SET category = ?, title = ?, slug = ?, description = ?, order_position = ?, image_path = ? WHERE id = ?");
            return $stmt->execute([$category, $title, $slug, $description, $order_position, $image_path, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE services SET category = ?, title = ?, slug = ?, description = ?, order_position = ? WHERE id = ?");
            return $stmt->execute([$category, $title, $slug, $description, $order_position, $id]);
        }
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getCategories() {
        $stmt = $this->db->query("SELECT DISTINCT category FROM services ORDER BY category ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function generateSlug($title, $excludeId = null) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    private function slugExists($slug, $excludeId = null) {
        if ($excludeId !== null) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM services WHERE slug = ? AND id != ?");
            $stmt->execute([$slug, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM services WHERE slug = ?");
            $stmt->execute([$slug]);
        }
        return $stmt->fetchColumn() > 0;
    }
}
