<?php
namespace YourNamespace\Models;

class OrderModel {
    private $db;
    
    public function __construct() {
        // Initialize database connection
        // Assuming you have a Database class that provides a connection
        $db = new \Database();  // Adjust if your DB connection is in a different class
        $this->db = $db->getConnection();
    }
    
    public function getOrders() {
        try {
            $stmt = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC");
            $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Fetch items for each order
            foreach ($orders as &$order) {
                $order['items'] = $this->getOrderItems($order['id']);
            }
            
            return $orders;
        } catch (\PDOException $e) {
            // Log error
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getOrder($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$id]);
            $order = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($order) {
                $order['items'] = $this->getOrderItems($id);
            }
            
            return $order;
        } catch (\PDOException $e) {
            // Log error
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
    private function getOrderItems($orderId) {
        try {
            $stmt = $this->db->prepare("SELECT oi.*, p.name as product_name 
                                        FROM order_items oi 
                                        JOIN products p ON oi.product_id = p.id 
                                        WHERE oi.order_id = ?");
            $stmt->execute([$orderId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log error
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
    
    public function updateOrderStatus($id, $status) {
        try {
            $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
            return $stmt->execute([$status, $id]);
        } catch (\PDOException $e) {
            // Log error
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteOrder($id) {
        try {
            // Start transaction to ensure all related records are deleted
            $this->db->beginTransaction();
            
            // Delete order items first (foreign key constraint)
            $stmt = $this->db->prepare("DELETE FROM order_items WHERE order_id = ?");
            $stmt->execute([$id]);
            
            // Delete the order
            $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
            $result = $stmt->execute([$id]);
            
            $this->db->commit();
            return $result;
        } catch (\PDOException $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            // Log error
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
