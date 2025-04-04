<?php
require_once 'Database/database.php';

class ReceiptModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    function getReceiptsByUser($userId)
    {
        $query = "SELECT r.*, o.order_date, p.product_name, p.price 
                 FROM receipts r
                 JOIN orders o ON r.order_id = o.order_id
                 JOIN products p ON o.product_id = p.product_id
                 WHERE r.user_id = :user_id
                 ORDER BY r.receipt_id DESC";
                 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getReceipt($id)
    {
        $query = "SELECT r.*, o.order_date, p.product_name, p.price, u.name, u.email, u.address, u.phone
                 FROM receipts r
                 JOIN orders o ON r.order_id = o.order_id
                 JOIN products p ON o.product_id = p.product_id
                 JOIN users u ON r.user_id = u.user_id
                 WHERE r.receipt_id = :receipt_id";
                 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['receipt_id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function deleteReceipt($id)
    {
        try {
            $query = "DELETE FROM receipts WHERE receipt_id = :receipt_id";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute(['receipt_id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting receipt: " . $e->getMessage());
            return false;
        }
    }
}