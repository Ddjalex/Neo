<?php
class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        $database_url = getenv('DATABASE_URL');
        
        if (!$database_url) {
            throw new Exception('DATABASE_URL environment variable not set');
        }
        
        $url = parse_url($database_url);
        
        $host = $url['host'];
        $port = $url['port'];
        $dbname = ltrim($url['path'], '/');
        $user = $url['user'];
        $password = $url['pass'];
        
        try {
            $this->conn = new PDO(
                "pgsql:host=$host;port=$port;dbname=$dbname",
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
