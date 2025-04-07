<?php
namespace YourNamespace\Models;

class OrderModel
{
    private $db;
    
    public function __construct()
    {
        // Initialize database connection
        $this->db = new \PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASS,
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]
        );
    }
    
    /**
     * Get all orders
     * 
     * @return array
     */
    public function getAllOrders()
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.name as customer_name, 
                   (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) as item_count
            FROM orders o
            JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get order by ID
     * 
     * @param int $id Order ID
     * @return array|false
     */
    public function getOrderById($id)
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.name as customer_name, u.email, u.phone
            FROM orders o
            JOIN users u ON o.user_id = u.id
            WHERE o.id = :id
        ");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Get order items
     * 
     * @param int $orderId Order ID
     * @return array
     */
    public function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name, p.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
        ");
        $stmt->bindParam(':order_id', $orderId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Update order status
     * 
     * @param int $orderId Order ID
     * @param string $status New status
     * @return bool
     */
    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET status = :status, updated_at = NOW()
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $orderId, \PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        
        return $stmt->execute();
    }
}