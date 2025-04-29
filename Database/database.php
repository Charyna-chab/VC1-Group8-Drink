<?php

namespace YourNamespace\Database;

use PDO;
use PDOException;

class Database
{
    private $host = '127.0.0.1';
    private $db_name = 'drink_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }

    public function insertOrder($pdo, $data)
    {
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, product_id, drink_size, quantity, order_date)
            VALUES (:user_id, :product_id, :drink_size, :quantity, NOW())
        ");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':product_id' => $data['product_id'],
            ':drink_size' => $data['drink_size'] ?? null,
            ':quantity' => $data['quantity']
        ]);
    }
}