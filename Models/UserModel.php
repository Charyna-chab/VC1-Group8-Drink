<?php
require_once 'Database/database.php';

class UserModel
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
    function getUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY user_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new user in the database.
     *
     * @param array $data An associative array containing user data.
     * @return int The ID of the newly created user.
     */
    function createUser($data)
    {
        $sql = "INSERT INTO users (name, phone, email, address) VALUES (:name, :phone, :email, :address)";
        $this->db->query($sql, [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address']
        ]);
        return $this->db->lastInsertId(); // Return the ID of the newly created user
    }

    /**
     * Get a user by their ID.
     *
     * @param int $id The ID of the user.
     * @return array|null An associative array containing the user data, or null if not found.
     */
    function getUser($id)
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE user_id = :user_id", ['user_id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a user in the database.
     *
     * @param int $id The ID of the user to update.
     * @param array $data An associative array containing the updated user data.
     * @return int The number of rows affected.
     */
    function updateUser($id, $data)
    {
        $sql = "UPDATE users SET name = :name, phone = :phone, email = :email, address = :address WHERE user_id = :user_id";
        $stmt = $this->db->query($sql, [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'],
            'user_id' => $id
        ]);
        return $stmt->rowCount(); // Return the number of rows affected
    }

    /**
     * Delete a user from the database.
     *
     * @param int $id The ID of the user to delete.
     * @return int The number of rows affected.
     */
    function deleteUser($id)
    {
        $stmt = $this->db->query("DELETE FROM users WHERE user_id = :user_id", ['user_id' => $id]);
        return $stmt->rowCount(); // Return the number of rows affected
    }
}