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
            ['id' => 1, 'name' => 'All Items', 'slug' => 'all'],
            ['id' => 2, 'name' => 'Seasonal', 'slug' => 'seasonal'],
            ['id' => 3, 'name' => 'Milk Tea', 'slug' => 'milk-tea'],
            ['id' => 4, 'name' => 'Coffee', 'slug' => 'coffee'],
            ['id' => 5, 'name' => 'Lemon Drink', 'slug' => 'lemon-drink'],
            ['id' => 6, 'name' => 'Bread', 'slug' => 'bread'],
            ['id' => 7, 'name' => 'Fruit Tea', 'slug' => 'fruit-tea'],
            ['id' => 8, 'name' => 'Smoothie', 'slug' => 'smoothie'],
            ['id' => 9, 'name' => 'Pastry', 'slug' => 'pastry']
        ];
    }

    private function initProducts()
    {
        $this->products = [
            // Milk Tea Category
            [
                'id' => 'classic-milk-tea',
                'name' => 'Classic Milk Tea',
                'price' => 2.50,
                'image' => '/assets/images/products/classic-milk-tea.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '10% Off!',
                'description' => 'Traditional milk tea with a perfect balance of tea and milk.',
                'is_featured' => true
            ],
            [
                'id' => 'brown-sugar-milk-tea',
                'name' => 'Brown Sugar Milk Tea',
                'price' => 3.25,
                'image' => '/assets/images/products/brown-sugar-milk-tea.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '15% Off!',
                'description' => 'Rich milk tea with caramelized brown sugar syrup.',
                'is_featured' => true
            ],
            [
                'id' => 'taro-milk-tea',
                'name' => 'Taro Milk Tea',
                'price' => 3.50,
                'image' => '/assets/images/products/taro-milk-tea.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '5% Off!',
                'description' => 'Creamy milk tea with sweet taro flavor.',
                'is_featured' => false
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
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'name' => 'John Doe',
                'profile_image' => '/assets/images/users/john.jpg',
                'membership' => 'Premium',
                'created_at' => '2023-01-15 10:30:00'
            ]
        ];
    }

    // Product methods
    public function getAllProducts()
    {
        return $this->products;
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
            if ($product['is_featured']) {
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
?>

