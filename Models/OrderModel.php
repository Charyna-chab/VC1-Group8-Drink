<?php
// File: models/OrderModel.php

namespace YourNamespace\Models;

use YourNamespace\Database\Database;
use PDOException;

class OrderModel
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // Save order into the database
    public function saveOrder($userId, $cartItems)
    {
        try {
            $this->pdo->beginTransaction();

            foreach ($cartItems as $item) {
                $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, product_id, drink_size) VALUES (:user_id, :product_id, :drink_size)");
                $stmt->execute([
                    'user_id' => $userId,
                    'product_id' => $item['product_id'],
                    'drink_size' => $item['size'],
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Order Save Failed: " . $e->getMessage());
            return false;
        }
    }

    // Get all orders
    public function getAllOrders()
    {
        try {
            $stmt = $this->pdo->query("SELECT o.*, p.product_name, u.name as user_name 
                                      FROM orders o
                                      LEFT JOIN products p ON o.product_id = p.product_id
                                      LEFT JOIN users u ON o.user_id = u.user_id
                                      ORDER BY o.order_id DESC");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get All Orders Failed: " . $e->getMessage());
            return [];
        }
    }

    // Get order by ID
    public function getOrderById($orderId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT o.*, p.product_name, u.name as user_name 
                                        FROM orders o
                                        LEFT JOIN products p ON o.product_id = p.product_id
                                        LEFT JOIN users u ON o.user_id = u.user_id
                                        WHERE o.order_id = :order_id");
            $stmt->execute(['order_id' => $orderId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Order By ID Failed: " . $e->getMessage());
            return null;
        }
    }

    // Get orders by status
    public function getOrdersByStatus($status)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE status = :status ORDER BY order_id DESC");
            $stmt->execute(['status' => $status]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Orders By Status Failed: " . $e->getMessage());
            return [];
        }
    }

    // Get orders by date range
    public function getOrdersByDateRange($startDate, $endDate)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT o.*, p.product_name, u.name as user_name 
                                        FROM orders o
                                        LEFT JOIN products p ON o.product_id = p.product_id
                                        LEFT JOIN users u ON o.user_id = u.user_id
                                        WHERE o.order_date BETWEEN :startDate AND :endDate 
                                        ORDER BY o.order_id DESC");
            $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Orders By Date Range Failed: " . $e->getMessage());
            return [];
        }
    }

    // Pagination for orders
    public function getOrdersWithPagination($limit, $offset)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT o.*, p.product_name, u.name as user_name 
                                        FROM orders o
                                        LEFT JOIN products p ON o.product_id = p.product_id
                                        LEFT JOIN users u ON o.user_id = u.user_id
                                        ORDER BY o.order_id DESC 
                                        LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Orders With Pagination Failed: " . $e->getMessage());
            return [];
        }
    }

    // Count total orders (for pagination)
    public function countTotalOrders()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM orders");
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Count Total Orders Failed: " . $e->getMessage());
            return 0;
        }
    }

    // Update order
    public function updateOrder($orderId, $userId, $productId, $drinkSize)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE orders 
                                        SET user_id = :user_id, 
                                            product_id = :product_id, 
                                            drink_size = :drink_size 
                                        WHERE order_id = :order_id");
            $stmt->execute([
                'user_id' => $userId,
                'product_id' => $productId,
                'drink_size' => $drinkSize,
                'order_id' => $orderId
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Update Order Failed: " . $e->getMessage());
            return false;
        }
    }

    // Delete order
    public function deleteOrder($orderId)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
            $stmt->execute(['order_id' => $orderId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Delete Order Failed: " . $e->getMessage());
            return false;
        }
    }

    // Get user orders
    public function getUserOrders($userId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT o.*, p.product_name, p.price, p.image
                                        FROM orders o
                                        LEFT JOIN products p ON o.product_id = p.product_id
                                        WHERE o.user_id = :user_id
                                        ORDER BY o.order_date DESC");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get User Orders Failed: " . $e->getMessage());
            return [];
        }
    }

    // Get recent orders (for dashboard)
    public function getRecentOrders($limit = 5)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT o.*, p.product_name, u.name as user_name
                                        FROM orders o
                                        LEFT JOIN products p ON o.product_id = p.product_id
                                        LEFT JOIN users u ON o.user_id = u.user_id
                                        ORDER BY o.order_date DESC
                                        LIMIT :limit");
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Recent Orders Failed: " . $e->getMessage());
            return [];
        }
    }

    // Get order statistics (for dashboard)
    public function getOrderStatistics()
    {
        try {
            // Total orders
            $totalStmt = $this->pdo->query("SELECT COUNT(*) as total FROM orders");
            $total = $totalStmt->fetch(\PDO::FETCH_ASSOC)['total'];

            // Today's orders
            $todayStmt = $this->pdo->query("SELECT COUNT(*) as today FROM orders WHERE DATE(order_date) = CURDATE()");
            $today = $todayStmt->fetch(\PDO::FETCH_ASSOC)['today'];

            // This week's orders
            $weekStmt = $this->pdo->query("SELECT COUNT(*) as week FROM orders WHERE YEARWEEK(order_date) = YEARWEEK(CURDATE())");
            $week = $weekStmt->fetch(\PDO::FETCH_ASSOC)['week'];

            // This month's orders
            $monthStmt = $this->pdo->query("SELECT COUNT(*) as month FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())");
            $month = $monthStmt->fetch(\PDO::FETCH_ASSOC)['month'];

            return [
                'total' => $total,
                'today' => $today,
                'week' => $week,
                'month' => $month
            ];
        } catch (PDOException $e) {
            error_log("Get Order Statistics Failed: " . $e->getMessage());
            return [
                'total' => 0,
                'today' => 0,
                'week' => 0,
                'month' => 0
            ];
        }
    }
}