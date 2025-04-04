<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class DashboardController extends BaseController {
    private $conn;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize database connection
        $database = new \Database();
        $this->conn = $database->getConnection();
        
        $this->checkAdminAuth();
    }
    
    private function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/admin-login');
        }
    }
    
    public function index() {
        try {
            // Get statistics for dashboard
            $userCount = $this->getUserCount();
            $productCount = $this->getProductCount();
            $totalSales = $this->getTotalSales();
            $monthlySales = $this->getMonthlySales();
            
            $this->views('admin/dashboard', [
                'title' => 'Admin Dashboard - XING FU CHA',
                'user' => $_SESSION['user'],
                'userCount' => $userCount,
                'productCount' => $productCount,
                'totalSales' => $totalSales,
                'monthlySales' => $monthlySales
            ]);
        } catch (\PDOException $e) {
            $this->views('admin/dashboard', [
                'title' => 'Admin Dashboard - XING FU CHA',
                'user' => $_SESSION['user'],
                'error' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    
    private function getUserCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    
    private function getProductCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM products");
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    
    private function getTotalSales() {
        $stmt = $this->conn->prepare("SELECT SUM(total_price) as total FROM orders");
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    
    private function getMonthlySales() {
        $stmt = $this->conn->prepare(
            "SELECT MONTH(created_at) as month, SUM(total_price) as total 
             FROM orders 
             WHERE YEAR(created_at) = YEAR(CURRENT_DATE) 
             GROUP BY MONTH(created_at) 
             ORDER BY month"
        );
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}