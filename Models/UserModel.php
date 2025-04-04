<?php

namespace YourNamespace\Models;

require_once '../Database/database.php';

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $database = new \Database();
        $this->pdo = $database->getConnection();
    }

    public function getUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY user_id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        try {
            // Debug output
            error_log("Model creating user with role: " . $data['role']);
            
            $query = "INSERT INTO users (image, name, phone, email, address, password, role)
                      VALUES (:image, :name, :phone, :email, :address, :password, :role)";
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([
                'image' => $data['image'] ?? null,
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'],
                'address' => $data['address'] ?? null,
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role' => $data['role'] // Make sure this is coming through
            ]);
            
            // Debug output
            error_log("User creation result: " . ($result ? "Success" : "Failure"));
            if (!$result) {
                error_log("PDO error info: " . print_r($stmt->errorInfo(), true));
            }
            
            return $result;
        } catch (\PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function getUser($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data)
    {
        try {
            $query = "UPDATE users SET 
                      name = :name, 
                      phone = :phone, 
                      email = :email, 
                      address = :address, 
                      role = :role";

            $params = [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
                'role' => $data['role'] ?? 'user',
                'user_id' => $id
            ];

            if (!empty($data['image'])) {
                $query .= ", image = :image";
                $params['image'] = $data['image'];
            }

            $query .= " WHERE user_id = :user_id";

            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
            return $stmt->execute(['user_id' => $id]);
        } catch (\PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
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
