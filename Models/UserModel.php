<?php
namespace YourNamespace\Models;

use PDO;
use PDOException;
use Exception;

require_once './Database/database.php';

use YourNamespace\Database\Database;

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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        try {
            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                throw new Exception('Required fields are missing');
            }

            $query = "INSERT INTO users (image, name, phone, email, address, password, role)
                      VALUES (:image, :name, :phone, :email, :address, :password, :role)";

            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([
                'image' => $data['image'] ?? null,
                'name' => htmlspecialchars($data['name']),
                'phone' => htmlspecialchars($data['phone'] ?? ''),
                'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
                'address' => htmlspecialchars($data['address'] ?? ''),
                'password' => $data['password'],
                'role' => in_array($data['role'], ['admin', 'user']) ? $data['role'] : 'user'
            ]);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function getUser($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfileImage($userId, $imagePath)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET image = :image WHERE user_id = :user_id");
            return $stmt->execute([
                'image' => $imagePath,
                'user_id' => $userId
            ]);
        } catch (PDOException $e) {
            error_log("Error updating profile image: " . $e->getMessage());
            return false;
        }
    }

    public function updateAdminProfile($userId, $data)
    {
        try {
            $query = "UPDATE users SET 
                      name = :name, 
                      email = :email, 
                      updated_at = NOW()";
            
            $params = [
                'name' => htmlspecialchars($data['name']),
                'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
                'user_id' => $userId
            ];

            if (!empty($data['image'])) {
                $query .= ", image = :image";
                $params['image'] = $data['image'];
            }

            $query .= " WHERE user_id = :user_id AND role = 'admin'";

            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error updating admin profile: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
            return $stmt->execute(['user_id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function emailExists($email)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}