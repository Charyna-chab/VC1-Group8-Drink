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

    // Get all orders for the list
    public function getAllOrders()
    {
        $stmt = $this->pdo->query("SELECT * FROM orders ORDER BY order_id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Get orders based on status (for example)
    public function getOrdersByStatus($status)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE status = :status ORDER BY order_id DESC");
        $stmt->execute(['status' => $status]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Get orders in a specific date range
    public function getOrdersByDateRange($startDate, $endDate)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_date BETWEEN :startDate AND :endDate ORDER BY order_id DESC");
        $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Pagination for orders (if needed)
    public function getOrdersWithPagination($limit, $offset)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders ORDER BY order_id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
