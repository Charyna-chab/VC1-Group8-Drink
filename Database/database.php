<?php
namespace YourNamespace\Database;

use PDO;
use PDOException;
use Exception;

class Database
{
    private $pdo;

    public function __construct()
    {
        // Configure your database connection
        $dsn = 'mysql:host=localhost;dbname=drink_db;charset=utf8';
        $username = 'root';
        $password = '';
        
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Helper method to execute queries with parameters
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}

