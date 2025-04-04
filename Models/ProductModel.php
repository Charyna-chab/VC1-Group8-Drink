<?php
namespace YourNamespace\Models;

require_once __DIR__ . '/../Database/database.php';
use YourNamespace\Database\Database;
use PDOException;
class ProductModel
{
    private $pdo;

    function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection(); // Use the PDO connection
    }

    function getProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY product_id DESC"); // Use PDO's query method
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all products as an associative array
    }

    function createProduct($data)
    {
        try {
            $query = "INSERT INTO products (product_name, image, product_detail, price)
                      VALUES (:product_name, :image, :product_detail, :price)";

            $stmt = $this->pdo->prepare($query); // Use PDO's prepare method
            $stmt->execute([
                'product_name' => $data['product_name'],
                'image' => $data['image'],
                'product_detail' => $data['product_detail'],
                'price' => $data['price'],
            ]);

            return $stmt->rowCount() > 0; // Return true if the product was created successfully
        } catch (PDOException $e) {
            error_log("Error creating product: " . $e->getMessage());
            return false;
        }
    }

    function getProduct($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single product as an associative array
    }

    function updateProduct($id, $data)
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

            return $stmt->rowCount() > 0; // Return true if the product was updated successfully
        } catch (PDOException $e) {
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    function deleteProduct($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
            $stmt->execute(['product_id' => $id]);
            return $stmt->rowCount() > 0; // Return true if the product was deleted successfully
        } catch (PDOException $e) {
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
}