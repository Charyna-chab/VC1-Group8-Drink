<?php
namespace YourNamespace\Models;

require_once 'Database/database.php';
use YourNamespace\Database\Database;
use PDOException;
use PDO;

class ReceiptModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
        $this->checkAndCreateTables();
    }

    private function checkAndCreateTables()
    {
        try {
            // Check if receipts table exists
            $result = $this->pdo->query("SELECT 1 FROM receipts LIMIT 1");
        } catch (PDOException $e) {
            // Table doesn't exist, create it
            $this->createTables();
        }
    }

    private function createTables()
    {
        // Execute the SQL to create tables
        $sql = file_get_contents(__DIR__ . '/schema.sql');
        $this->pdo->exec($sql);
    }

    public function getReceiptsByUser($userId)
    {
        try {
            $query = "SELECT r.*, o.order_date, p.product_name, p.price 
                     FROM receipts r
                     JOIN orders o ON r.order_id = o.order_id
                     JOIN products p ON o.product_id = p.product_id
                     WHERE r.user_id = :user_id
                     ORDER BY r.receipt_id DESC";
                     
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting receipts: " . $e->getMessage());
            return [];
        }
    }

    public function getReceipt($id)
    {
        try {
            $query = "SELECT r.*, o.order_date, p.product_name, p.price, u.name, u.email, u.address, u.phone
                     FROM receipts r
                     JOIN orders o ON r.order_id = o.order_id
                     JOIN products p ON o.product_id = p.product_id
                     JOIN users u ON r.user_id = u.user_id
                     WHERE r.receipt_id = :receipt_id";
                     
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['receipt_id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting receipt: " . $e->getMessage());
            return null;
        }
    }

    // ... rest of your methods ...
}