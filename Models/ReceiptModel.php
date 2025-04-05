<?php
// Database connection
class ReceiptModel {
    public $db;
    
    public function __construct() {
        // Database credentials - REPLACE THESE WITH YOUR ACTUAL CREDENTIALS
        $host = 'localhost';
        $dbname = 'drink_db'; // Replace with your actual database name
        $username = 'root';       // Replace with your actual username
        $password = '';           // Replace with your actual password
        
        try {
            $this->db = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        return $stmt;
    }
    
    public function execute($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function getAllReceipts() {
        $query = "SELECT r.*, o.order_date, p.name as product_name, u.username 
                 FROM receipts r
                 JOIN orders o ON r.order_id = o.order_id
                 JOIN products p ON o.product_id = p.product_id
                 JOIN users u ON r.user_id = u.user_id
                 ORDER BY r.receipt_id DESC";
        
        return $this->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getReceiptsByUser($userId) {
        $query = "SELECT r.*, o.order_date, p.name as product_name 
                 FROM receipts r
                 JOIN orders o ON r.order_id = o.order_id
                 JOIN products p ON o.product_id = p.product_id
                 WHERE r.user_id = :user_id
                 ORDER BY r.receipt_id DESC";
        
        $params = [':user_id' => $userId];
        
        return $this->query($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getReceipt($id) {
        $query = "SELECT r.*, o.order_date, p.name as product_name, u.username, u.email
                 FROM receipts r
                 JOIN orders o ON r.order_id = o.order_id
                 JOIN products p ON o.product_id = p.product_id
                 JOIN users u ON r.user_id = u.user_id
                 WHERE r.receipt_id = :id";
        
        $params = [':id' => $id];
        
        return $this->query($query, $params)->fetch(PDO::FETCH_ASSOC);
    }
    
    public function deleteReceipt($id) {
        $query = "DELETE FROM receipts WHERE receipt_id = :id";
        $params = [':id' => $id];
        
        return $this->execute($query, $params);
    }
    
    public function createReceipt($data) {
        $query = "INSERT INTO receipts (order_id, user_id, amount, payment_method, payment_status, transaction_id, created_at)
                 VALUES (:order_id, :user_id, :amount, :payment_method, :payment_status, :transaction_id, NOW())";
        
        $params = [
            ':order_id' => $data['order_id'],
            ':user_id' => $data['user_id'],
            ':amount' => $data['amount'],
            ':payment_method' => $data['payment_method'],
            ':payment_status' => $data['payment_status'],
            ':transaction_id' => $data['transaction_id']
        ];
        
        return $this->execute($query, $params);
    }
}