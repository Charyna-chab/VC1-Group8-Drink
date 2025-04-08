<?php
namespace YourNamespace\Models;

require_once './Database/database.php';

require_once __DIR__ . '/../Database/database.php';
use YourNamespace\Database\Database;
use PDOException;
class ToppingModel
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getToppings()
    {
        $stmt = $this->pdo->query("SELECT * FROM toppings ORDER BY topping_id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createTopping($data)
    {
        try {
            $query = "INSERT INTO toppings (topping_name, price)
                      VALUES (:topping_name,:price,)";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

    public function getTopping($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM toppings WHERE topping_id = :topping_id");
        $stmt->execute(['product_id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE toppings SET 
                    topping_name = :topping_name,
                    price = :price,
                WHERE topping_id = :id";
    
        $stmt = $this->pdo->prepare($sql); // <-- Use $this->pdo, not $this->db
        return $stmt->execute([
            ':topping_name' => $data['topping_name'],
            ':price' => $data['price'],
            ':id' => $id
        ]);
    }
    
    

    public function deleteTopping($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM toppings WHERE topping_id = :topping_id");
        return $stmt->execute(['topping_id' => $id]);
    }

    // public function getTotalPrice()
    // {
    //     try {
    //         $stmt = $this->pdo->query("SELECT SUM(price) AS total_price FROM products");
    //         $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    //         return $result['total_price'] ?? 0;
    //     } catch (PDOException $e) {
    //         // Handle exception
    //         return 0;
    //     }
    // }

    // public function getTotalProducts()
    // {
    //     try {
    //         $stmt = $this->pdo->query("SELECT COUNT(*) AS total_products FROM products");
    //         $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    //         return $result['total_products'] ?? 0;
    //     } catch (PDOException $e) {
    //         // Handle exception
    //         return 0;
    //     }
    // }
}