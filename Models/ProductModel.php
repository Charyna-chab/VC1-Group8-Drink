<?php
require_once 'Database/database.php';

class ProductModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new Database();
    }


    function getProducts()
    {
        $products = $this->pdo->query("SELECT * FROM products ORDER BY product_id DESC");
        return $products->fetchAll();
    }


    function createProduct($data)
    {
        try {
            $query = "INSERT INTO products (product_name, image, product_detail, price)
                      VALUES (:product_name, :image, :product_detail, :price)";

            // Use the query method from your Database class
            $result = $this->pdo->query($query, [
                'product_name' => $data['product_name'],
                'image' => $data['image'],
                'product_detail' => $data['product_detail'],
                'price' => $data['price'],

            ]);

            // Return success or the new ID if your Database class provides a method for it
        } catch (PDOException $e) {
            // Handle or log the error
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }


    function getProduct($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM products WHERE product_id = :product_id", ['product_id' => $id]);
        return $stmt->fetch();
    }


    // function updateProduct($id, $data)
    // {
    //     $stmt =  $this->pdo->query(
    //         "UPDATE products SET  product_name = :product_name, image = :image, product_detail = :product_detail, price = :price WHERE product_id = :product_id",
    //         [
    //             'product_name' => $data['product_name'],
    //             'image' => $data['image'],
    //             'product_detail' => $data['product_detail'],
    //             'price' => $data['price'],
    //             'product_id' => $id
    //         ]
    //     );
    //     $stmt = $this->pdo->query("UPDATE products SET product_name = :product_name, product_detail = :product_detail, price = :price WHERE product_id = :product_id",
    //         [
    //             'product_name' => $data['product_name'],
    //             'product_detail' => $data['product_detail'],
    //             'price' => $data['price'],
    //             'product_id' => $id
    //         ]);
    // }
    function updateProduct($id, $data)
    {
        try {
            // Check if an image was uploaded, otherwise keep the existing one
            $image = isset($data['image']) && !empty($data['image']) ? $data['image'] : $data['existing_image'];
    
            $stmt = $this->pdo->query(
                "UPDATE products SET product_name = :product_name, image = :image, product_detail = :product_detail, price = :price WHERE product_id = :product_id",
                [
                    'product_name' => $data['product_name'],
                    'image' => $image,
                    'product_detail' => $data['product_detail'],
                    'price' => $data['price'],
                    'product_id' => $id
                ]
            );
    
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }
    

    
    function deleteProduct($id) {
        try {
            // First, check if the product exists before deleting
            $stmt = $this->pdo->query("SELECT * FROM products WHERE product_id = :product_id", [
                'product_id' => $id
            ]);
    
            $product = $stmt->fetch();
            if (!$product) {
                return false; // Product does not exist
            }
    
            // Proceed with deletion
            $stmt = $this->pdo->query("DELETE FROM products WHERE product_id = :product_id", [
                'product_id' => $id
            ]);
    
            return $stmt->rowCount() > 0; // Return true if a row was deleted
        } catch (PDOException $e) {
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
    
    
}