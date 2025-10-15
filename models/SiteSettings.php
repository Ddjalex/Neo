<?php
class SiteSettings {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function get($key) {
        $stmt = $this->db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : null;
    }
    
    public function set($key, $value) {
        $stmt = $this->db->prepare("
            INSERT INTO site_settings (setting_key, setting_value, updated_at) 
            VALUES (?, ?, CURRENT_TIMESTAMP)
            ON CONFLICT (setting_key) 
            DO UPDATE SET setting_value = EXCLUDED.setting_value, updated_at = CURRENT_TIMESTAMP
        ");
        return $stmt->execute([$key, $value]);
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM site_settings ORDER BY setting_key");
        return $stmt->fetchAll();
    }
    
    public function getAllAsArray() {
        $stmt = $this->db->query("SELECT * FROM site_settings ORDER BY setting_key ASC");
        $results = $stmt->fetchAll();
        
        // Convert to associative array
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }
    
    public function updateMultiple($settings) {
        $this->db->beginTransaction();
        try {
            foreach ($settings as $key => $value) {
                $this->set($key, $value);
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
