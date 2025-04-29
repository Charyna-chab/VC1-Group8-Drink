<?php
namespace YourNamespace\Models;

require_once './Database/database.php';

require_once __DIR__ . '/../Database/database.php';
use YourNamespace\Database\Database;
use PDOException;

class OrderListModel
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getAllOrders()
    {
        try {
            $stmt = $this->pdo->query("
                SELECT 
                    o.order_id, 
                    o.order_date, 
                    o.drink_size, 
                    u.name AS customer_name, 
                    u.email AS customer_email, 
                    p.product_name, 
                    p.price AS product_price
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.user_id
                LEFT JOIN products p ON o.product_id = p.product_id
                ORDER BY o.order_date DESC
            ");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching orders: " . $e->getMessage());
            return [];
        }
    }
   

    public function getOrderById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching order by ID: " . $e->getMessage());
            return null;
        }
    }

    public function deleteOrder($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM orders WHERE order_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting order: " . $e->getMessage());
            return false;
        }
    }
}