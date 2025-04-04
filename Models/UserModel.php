<?php
namespace YourNamespace\Models;

require_once __DIR__ . '/../Database/database.php';
use YourNamespace\Database\Database;
use PDOException;
class UserModel
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY user_id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $query = "INSERT INTO users (name, phone, email, address, role, password)
                  VALUES (:name, :phone, :email, :address, :role, :password)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function getUser($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data)
    {
        $query = "UPDATE users SET name = :name, phone = :phone, email = :email, address = :address, role = :role WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $data['user_id'] = $id;
        return $stmt->execute($data);
    }

    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        return $stmt->execute(['user_id' => $id]);
    }

    public function emailExists($email, $excludeId = null)
    {
        $query = "SELECT user_id FROM users WHERE email = :email";
        $params = ['email' => $email];

        if ($excludeId) {
            $query .= " AND user_id != :user_id";
            $params['user_id'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }
}
