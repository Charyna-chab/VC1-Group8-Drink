<?php
class Database
{
    private $pdo;
    private static $instance = null;
    private $products = [];
    private $categories = [];
    private $users = [];
    private $orders = [];
    private $toppings = [];

    private function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "drink_db";

        try {
            // Create a PDO connection
            $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        // Initialize with fake data
        $this->initCategories();
        $this->initProducts();
        $this->initToppings();
        $this->initUsers();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function initCategories()
    {
        $this->categories = [
            ['id' => 1, 'name' => 'All', 'slug' => 'all'],
            ['id' => 2, 'name' => 'Milk Tea', 'slug' => 'milk-tea'],
            ['id' => 3, 'name' => 'Fruit Tea', 'slug' => 'fruit-tea'],
            ['id' => 4, 'name' => 'Smoothies', 'slug' => 'smoothies'],
            ['id' => 5, 'name' => 'Coffee', 'slug' => 'coffee'],
            ['id' => 6, 'name' => 'Snacks', 'slug' => 'snacks']
        ];
    }

    private function initProducts()
    {
        $this->products = [
            [
                'id' => 1,
                'name' => 'Taro Milk Tea',
                'description' => 'Creamy taro milk tea with chewy tapioca pearls',
                'price' => 4.50,
                'image' => '/assets/images/products/taro-milk-tea.jpg',
                'category' => 'milk-tea',
                'discount' => '10% OFF',
                'featured' => true
            ],
            // ...other products...
        ];
    }

    private function initToppings()
    {
        $this->toppings = [
            ['id' => 1, 'name' => 'Jelly', 'price' => 0.85],
            ['id' => 2, 'name' => 'Cream', 'price' => 0.85],
            ['id' => 3, 'name' => 'Cheese Foam', 'price' => 0.85],
            ['id' => 4, 'name' => 'Pearl', 'price' => 0.85],
            ['id' => 5, 'name' => 'Coconut Jelly', 'price' => 0.85],
            ['id' => 6, 'name' => 'Chocolate Chips', 'price' => 0.85],
            ['id' => 7, 'name' => 'Red Bean', 'price' => 0.85],
            ['id' => 8, 'name' => 'Whipped Cream', 'price' => 0.85],
            ['id' => 9, 'name' => 'Caramel Drizzle', 'price' => 0.85]
        ];
    }

    private function initUsers()
    {
        $this->users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'avatar' => '/assets/images/users/user1.jpg',
                'role' => 'user'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'avatar' => '/assets/images/users/user2.jpg',
                'role' => 'user'
            ],
            [
                'id' => 3,
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'avatar' => '/assets/images/users/admin.jpg',
                'role' => 'admin'
            ]
        ];

        // Initialize orders
        $this->orders = [
            [
                'id' => 1,
                'user_id' => 1,
                'product_id' => 1,
                'size' => 'medium',
                'sugar_level' => '50%',
                'toppings' => ['pearl', 'cream'],
                'price' => 5.35,
                'status' => 'completed',
                'created_at' => '2023-05-15 14:30:00'
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'product_id' => 2,
                'size' => 'large',
                'sugar_level' => '75%',
                'toppings' => ['pearl'],
                'price' => 6.85,
                'status' => 'processing',
                'created_at' => '2023-05-16 10:15:00'
            ]
        ];
    }

    // Product methods
    public function getAllProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    public function getProductsByCategory($category)
    {
        if ($category === 'all') {
            return $this->products;
        }

        $result = [];
        foreach ($this->products as $product) {
            if ($product['category'] == $category) {
                $result[] = $product;
            }
        }
        return $result;
    }

    public function getFeaturedProducts()
    {
        $result = [];
        foreach ($this->products as $product) {
            if ($product['featured']) {
                $result[] = $product;
            }
        }
        return $result;
    }

    // Category methods
    public function getAllCategories()
    {
        return $this->categories;
    }

    public function getCategoryById($id)
    {
        foreach ($this->categories as $category) {
            if ($category['id'] == $id) {
                return $category;
            }
        }
        return null;
    }

    // Topping methods
    public function getAllToppings()
    {
        return $this->toppings;
    }

    // User methods
    public function getUserById($id)
    {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    public function getUserByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user['username'] == $username) {
                return $user;
            }
        }
        return null;
    }

    // Order methods
    public function createOrder($data)
    {
        $orderId = uniqid('ORD');
        $data['id'] = $orderId;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'pending';

        $this->orders[] = $data;
        return $orderId;
    }

    public function getOrdersByUserId($userId)
    {
        $result = [];
        foreach ($this->orders as $order) {
            if ($order['user_id'] == $userId) {
                $result[] = $order;
            }
        }
        return $result;
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
            echo "Query failed: " . $e->getMessage();
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

