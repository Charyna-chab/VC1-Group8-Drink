<?php
// Database connection
class ReceiptModel {
    public $db;
    
    public function __construct() {
        // Database credentials - REPLACE THESE WITH YOUR ACTUAL CREDENTIALS
        $host = 'localhost';
        $dbname = 'drink_db'; // Replace with your actual database name
        $username = 'root';   // Replace with your actual username
        $password = '';       // Replace with your actual password
        
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
        $stmt->execute($params);
        return $stmt;
    }
    
    public function execute($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function getAllReceipts() {
        // Check if receipts table exists
        try {
            $query = "SELECT r.*, o.order_date, p.name as product_name, u.name as username, u.email 
                     FROM receipts r
                     JOIN orders o ON r.order_id = o.order_id
                     JOIN products p ON o.product_id = p.product_id
                     JOIN users u ON r.user_id = u.user_id
                     ORDER BY r.receipt_id DESC";
            
            return $this->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If table doesn't exist, return empty array
            return [];
        }
    }
    
    public function getReceiptsByUser($userId) {
        try {
            $query = "SELECT r.*, o.order_date, p.name as product_name 
                     FROM receipts r
                     JOIN orders o ON r.order_id = o.order_id
                     JOIN products p ON o.product_id = p.product_id
                     WHERE r.user_id = :user_id
                     ORDER BY r.receipt_id DESC";
            
            $params = [':user_id' => $userId];
            
            return $this->query($query, $params)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If table doesn't exist, return empty array
            return [];
        }
    }
    
    public function getReceipt($id) {
        try {
            $query = "SELECT r.*, o.order_date, p.name as product_name, u.name as username, u.email
                     FROM receipts r
                     JOIN orders o ON r.order_id = o.order_id
                     JOIN products p ON o.product_id = p.product_id
                     JOIN users u ON r.user_id = u.user_id
                     WHERE r.receipt_id = :id";
            
            $params = [':id' => $id];
            
            return $this->query($query, $params)->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If error, return null
            return null;
        }
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
    
    // Check if receipts table exists, if not create it
    public function createReceiptsTableIfNotExists() {
        $query = "CREATE TABLE IF NOT EXISTS `receipts` (
            `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
            `order_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `amount` decimal(10,2) NOT NULL,
            `payment_method` varchar(50) NOT NULL,
            `payment_status` varchar(50) NOT NULL,
            `transaction_id` varchar(100) DEFAULT NULL,
            `created_at` datetime DEFAULT current_timestamp(),
            PRIMARY KEY (`receipt_id`),
            KEY `order_id` (`order_id`),
            KEY `user_id` (`user_id`),
            CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
            CONSTRAINT `receipts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        
        return $this->execute($query);
    }
}