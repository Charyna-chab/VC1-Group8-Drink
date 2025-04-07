<?php
namespace YourNamespace\Models;

require_once './Database/database.php';

require_once __DIR__ . '/../Database/database.php';
use YourNamespace\Database\Database;
use PDOException;
class ProductModel
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY product_id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createProduct($data)
    {
        $query = "INSERT INTO products (product_name, product_detail, price, image)
                  VALUES (:product_name, :product_detail, :price, :image)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function getProduct($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateProduct($id, $data)
    {
        $query = "UPDATE products SET product_name = :product_name, product_detail = :product_detail, price = :price, image = :image WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($query);
        $data['product_id'] = $id;
        return $stmt->execute($data);
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
}