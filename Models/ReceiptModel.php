<?php
require_once 'Database/database.php';

class ReceiptModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new Database();
    }

    function getReceiptsByUser($userId)
    {
        $query = "SELECT r.*, o.order_date, p.product_name, p.price 
                 FROM receipts r
                 JOIN orders o ON r.order_id = o.order_id
                 JOIN products p ON o.product_id = p.product_id
                 WHERE r.user_id = :user_id
                 ORDER BY r.receipt_id DESC";
                 
        $stmt = $this->pdo->query($query, ['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    function getReceipt($id)
    {
        $query = "SELECT r.*, o.order_date, p.product_name, p.price, u.name, u.email, u.address, u.phone
                 FROM receipts r
                 JOIN orders o ON r.order_id = o.order_id
                 JOIN products p ON o.product_id = p.product_id
                 JOIN users u ON r.user_id = u.user_id
                 WHERE r.receipt_id = :receipt_id";
                 
        $stmt = $this->pdo->query($query, ['receipt_id' => $id]);
        return $stmt->fetch();
    }

    function createReceipt($data)
    {
        try {
            $query = "INSERT INTO receipts (user_id, order_id, amount, payment_method, payment_status, transaction_id)
                      VALUES (:user_id, :order_id, :amount, :payment_method, :payment_status, :transaction_id)";

            $result = $this->pdo->query($query, [
                'user_id' => $data['user_id'],
                'order_id' => $data['order_id'],
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_status'],
                'transaction_id' => $data['transaction_id']
            ]);

            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating receipt: " . $e->getMessage());
            return false;
        }
    }
}