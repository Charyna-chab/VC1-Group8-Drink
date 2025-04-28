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
    try {
        $query = "INSERT INTO products (product_name, product_detail, price, image, category,quantity)
                  VALUES (:product_name, :product_detail, :price, :image, :category,:quantity)";
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
                    quantity = :quantity,
                    image = :image
                WHERE product_id = :product_id";

        $data['product_id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }



    public function deleteProduct($id)
    {
        try {
            // Start transaction in case we need to rollback
            $this->pdo->beginTransaction();

            // First delete any related records (like in order_items table)
            // $this->pdo->prepare("DELETE FROM order_items WHERE product_id = ?")->execute([$id]);

            // Then delete the product
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE product_id = ?");
            $result = $stmt->execute([$id]);

            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Delete product error: " . $e->getMessage());
            return false;
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
