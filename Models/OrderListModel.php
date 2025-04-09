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
            $stmt = $this->pdo->query("SELECT * FROM orders");
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