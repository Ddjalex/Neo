<?php
class Portfolio {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM portfolio ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM portfolio WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($title, $description, $image_path, $category) {
        $stmt = $this->db->prepare("INSERT INTO portfolio (title, description, image_path, category) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $image_path, $category]);
    }
    
    public function update($id, $title, $description, $image_path, $category) {
        $stmt = $this->db->prepare("UPDATE portfolio SET title = ?, description = ?, image_path = ?, category = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $image_path, $category, $id]);
    }
    
    public function delete($id) {
        $project = $this->getById($id);
        if ($project && $project['image_path']) {
            $file_path = __DIR__ . '/../public' . $project['image_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $stmt = $this->db->prepare("DELETE FROM portfolio WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
