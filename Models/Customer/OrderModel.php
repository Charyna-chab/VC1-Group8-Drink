<?php
namespace YourNamespace\Models;

require_once './Database/database.php';

// require_once __DIR__ . '/../Database/database.php';
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

    public function getOrders()
    {
        try {
            $stmt = $this->pdo->query("
                SELECT 
                    o.order_id, 
                    o.order_date, 
                    o.drink_size, 
                    u.name AS customer_name, 
                    p.product_name
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                JOIN products p ON o.product_id = p.product_id
                ORDER BY o.order_date DESC
            ");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching orders: " . $e->getMessage());
            return [];
        }
    }

    public function createOrder($data)
    {
        try {
            $query = "INSERT INTO products (product_name, product_detail, price, image)
                      VALUES (:product_name, :product_detail, :price, :image)";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

    public function getProduct($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE products SET 
                    product_name = :product_name,
                    product_detail = :product_detail,
                    price = :price,
                    category = :category,
                    image = :image
                WHERE product_id = :id";
    
        $stmt = $this->pdo->prepare($sql); // <-- Use $this->pdo, not $this->db
        return $stmt->execute([
            ':product_name' => $data['product_name'],
            ':product_detail' => $data['product_detail'],
            ':price' => $data['price'],
            ':category' => $data['category'],
            ':image' => $data['image'],
            ':id' => $id
        ]);
    }
    
    

    public function deleteProduct($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
        return $stmt->execute(['product_id' => $id]);
    }

    public function getTotalPrice()
    {
        try {
            $stmt = $this->pdo->query("SELECT SUM(price) AS total_price FROM products");
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total_price'] ?? 0;
        } catch (PDOException $e) {
            // Handle exception
            return 0;
        }
    }

    public function getTotalProducts()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) AS total_products FROM products");
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total_products'] ?? 0;
        } catch (PDOException $e) {
            // Handle exception
            return 0;
        }
    }

    public function getUserOrders($userId)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    o.order_id, 
                    o.order_date, 
                    o.drink_size, 
                    u.name AS customer_name, 
                    p.product_name
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                JOIN products p ON o.product_id = p.product_id
                WHERE o.user_id = :user_id
                ORDER BY o.order_date DESC
            ");
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching user orders: " . $e->getMessage());
            return [];
        }
    }
}