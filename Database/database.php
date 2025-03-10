<?php
class Database
{
    private $pdo;

    function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "drink_db";

        try {
            // Create a PDO connection
            $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set PDO to throw exceptions on errors
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle connection errors
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Execute a SQL query with optional parameters.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters to bind to the query.
     * @return PDOStatement The executed statement.
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Handle query execution errors
            die("Query failed: " . $e->getMessage());
        }
    }

    /**
     * Get the last inserted ID.
     *
     * @return string The last inserted ID.
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}