<?php
require_once 'Database/database.php';

class UserModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new Database();
    }

   
    function getUsers()
    {
        $users = $this->pdo->query("SELECT * FROM users ORDER BY user_id DESC");
        return $users->fetchAll();
    }

   
    function createUser($data)
{
    try {
        $query = "INSERT INTO users (image, name, phone, address, email, password, role)
                  VALUES (:image, :name, :phone, :address, :email, :password, :role)";
        
        // Use the query method from your Database class
        $result = $this->pdo->query($query, [
            'image' => $data['image'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            
        ]);
        
        // Return success or the new ID if your Database class provides a method for it
    } catch (PDOException $e) {
        // Handle or log the error
        error_log("Error creating user: " . $e->getMessage());
        return false;
    }
}

  
    function getUser($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE user_id = :user_id", ['user_id' => $id]);
        return $stmt->fetch();
    }

  
    function updateUser($id, $data)
    {
        $stmt = $this->pdo->query( "UPDATE users SET name = :name, email = :email, password = :password, address = :address WHERE user_id = :user_id",
        [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'address' => $data['address'],
            'user_id' => $id
        ]);
    }

   
    function deleteUser($id)
    {
        $stmt = $this->pdo->query("DELETE FROM users WHERE user_id = :user_id", ['user_id' => $id]);
      
    }
}