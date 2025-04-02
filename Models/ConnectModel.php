<?php
require_once 'Database/database.php';

class ConnectModel {
    private $pdo;

    public function __construct() {
        $db = new Database(); // Ensure Database class properly returns PDO
        $this->pdo = $db->getConnection();
    }

    // Check if an order exists
    private function orderExists($orderId) {
        $stmt = $this->pdo->prepare("SELECT order_id FROM orders WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch() ? true : false;
    }

    // Add product to an order
    public function addProductToOrder($orderId, $productId, $size, $sugar, $ice, $quantity, $price, $toppings = []) {
        try {
            // Ensure order exists before inserting items
            if (!$this->orderExists($orderId)) {
                return ['success' => false, 'message' => 'Order does not exist'];
            }

            $query = "INSERT INTO order_items (order_id, product_id, size, sugar, ice, quantity, price, toppings) 
                      VALUES (:order_id, :product_id, :size, :sugar, :ice, :quantity, :price, :toppings)";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'order_id' => $orderId,
                'product_id' => $productId,
                'size' => $size,
                'sugar' => $sugar,
                'ice' => $ice,
                'quantity' => $quantity,
                'price' => $price,
                'toppings' => json_encode($toppings) // Store toppings as JSON string
            ]);

            return ['success' => true, 'order_item_id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log("Error adding product to order: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error'];
        }
    }

    // Get order details along with products
    public function getOrderWithProducts($orderId) {
        try {
            $query = "SELECT o.*, oi.product_id, p.product_name, oi.size, oi.sugar, oi.ice, oi.quantity, oi.price, oi.toppings
                      FROM orders o
                      JOIN order_items oi ON o.order_id = oi.order_id
                      JOIN products p ON oi.product_id = p.product_id
                      WHERE o.order_id = :order_id";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['order_id' => $orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching order with products: " . $e->getMessage());
            return false;
        }
    }

    // Delete a product from an order
    public function removeProductFromOrder($orderItemId) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM order_items WHERE id = :order_item_id");
            $stmt->execute(['order_item_id' => $orderItemId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error removing product from order: " . $e->getMessage());
            return false;
        }
    }

    // Get all products in a specific order
    public function getOrderProducts($orderId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
            $stmt->execute(['order_id' => $orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching order products: " . $e->getMessage());
            return false;
        }
    }
}


