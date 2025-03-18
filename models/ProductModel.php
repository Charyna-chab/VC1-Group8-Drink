<?php
require_once 'Database/database.php';

class ProductModel
{
    private $db;

    function __construct()
    {
        // Initialize the Database class
        $this->db = new Database();
    }

    /**
     * Get all users from the database.
     *
     * @return array An array of users.
     */
    function getProducts()
    {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY product_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new user in the database.
     *
     * @param array $data An associative array containing user data.
     * @return int The ID of the newly created user.
     */
    function createProduct($data)
    {
        $sql = "INSERT INTO products (product_name, image, product_detail, price) VALUES (:product_name, :image, :product_detail, :price)";
        $this->db->query($sql, [
            'product_name' => $data['product_name'],
            'image' => $data['image'],
            'product_detail' => $data['product_detail'],
            'price' => $data['price']
        ]);
       
        return $this->db->lastInsertId(); // Return the ID of the newly created user
    }

    /**
     * Get a user by their ID.
     *
     * @param int $id The ID of the user.
     * @return array|null An associative array containing the user data, or null if not found.
     */
    function getProduct($id)
    {
        $stmt = $this->db->query("SELECT * FROM products WHERE product_id = :product_id", ['product_id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a user in the database.
     *
     * @param int $id The ID of the user to update.
     * @param array $data An associative array containing the updated user data.
     * @return int The number of rows affected.
     */
    function updateProduct($id, $data)
    {
        $sql = "UPDATE products SET  product_name = :product_name, image = :image, product_detail = :product_detail, price = :price WHERE product_id = :product_id";
        $stmt = $this->db->query($sql, [
            'product_name' => $data['product_name'],
            'image' => $data['image'],
            'product_detail' => $data['product_detail'],
            'price' => $data['price'],
            'product_id' => $id
        ]);
        return $stmt->rowCount(); // Return the number of rows affected
    }

    /**
     * Delete a user from the database.
     *
     * @param int $id The ID of the user to delete.
     * @return int The number of rows affected.
     */
    function deleteProduct($id)
    {
        $stmt = $this->db->query("DELETE FROM products WHERE product_id = :product_id", ['product_id' => $id]);
    }



    
}