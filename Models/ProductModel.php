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
        $database = new \Database();
        $this->pdo = $database->getConnection();
    }

    public function getProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY product_id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createProduct($data)
    {
        try {
            $query = "INSERT INTO products (product_name, image, product_detail, price)
                      VALUES (:product_name, :image, :product_detail, :price)";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'product_name' => $data['product_name'],
                'image' => $data['image'],
                'product_detail' => $data['product_detail'],
                'price' => $data['price'],
            ]);

            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error creating product: " . $e->getMessage());
            return false;
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
        try {
            $query = "UPDATE products SET 
                      product_name = :product_name, 
                      image = :image, 
                      product_detail = :product_detail, 
                      price = :price 
                      WHERE product_id = :product_id";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'product_name' => $data['product_name'],
                'image' => $data['image'],
                'product_detail' => $data['product_detail'],
                'price' => $data['price'],
                'product_id' => $id,
            ]);

            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
            $stmt->execute(['product_id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
}