<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'drink_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage(), 3, __DIR__ . "/../logs/error.log");
            die("Database connection error. Check logs.");
        }

        return $this->conn;
    }
}
?>

