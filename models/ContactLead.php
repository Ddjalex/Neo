<?php
class ContactLead {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM contact_leads ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM contact_leads WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($name, $email, $phone, $message) {
        $stmt = $this->db->prepare("INSERT INTO contact_leads (name, email, phone, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $message]);
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE contact_leads SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM contact_leads WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
