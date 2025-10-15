<?php
require_once __DIR__ . '/../config/database.php';

class BlogPost {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll($status = 'published') {
        if ($status === 'all') {
            $stmt = $this->db->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
        } else {
            $stmt = $this->db->prepare("SELECT * FROM blog_posts WHERE status = ? ORDER BY published_at DESC, created_at DESC");
            $stmt->execute([$status]);
        }
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO blog_posts (title, slug, content, excerpt, featured_image, author, status, published_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        $published_at = $data['status'] === 'published' ? date('Y-m-d H:i:s') : null;
        
        return $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'],
            $data['featured_image'] ?? null,
            $data['author'],
            $data['status'],
            $published_at
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE blog_posts 
             SET title = ?, slug = ?, content = ?, excerpt = ?, featured_image = ?, 
                 author = ?, status = ?, published_at = ?, updated_at = CURRENT_TIMESTAMP 
             WHERE id = ?"
        );
        
        $published_at = $data['status'] === 'published' && empty($data['published_at']) 
            ? date('Y-m-d H:i:s') 
            : $data['published_at'];
        
        return $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'],
            $data['featured_image'] ?? null,
            $data['author'],
            $data['status'],
            $published_at,
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM blog_posts WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function generateSlug($title) {
        // Convert to lowercase and replace spaces with hyphens
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
}
