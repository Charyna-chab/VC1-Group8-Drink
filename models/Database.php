<?php

class Database {
    private static $instance = null;
    private $products = [];
    private $categories = [];
    private $users = [];
    private $orders = [];

    private function __construct() {
        $this->initializeData();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function initializeData() {
        // Initialize categories
        $this->categories = [
            ['id' => 1, 'name' => 'All', 'slug' => 'all'],
            ['id' => 2, 'name' => 'Milk Tea', 'slug' => 'milk-tea'],
            ['id' => 3, 'name' => 'Fruit Tea', 'slug' => 'fruit-tea'],
            ['id' => 4, 'name' => 'Smoothies', 'slug' => 'smoothies'],
            ['id' => 5, 'name' => 'Coffee', 'slug' => 'coffee'],
            ['id' => 6, 'name' => 'Snacks', 'slug' => 'snacks']
        ];

        // Initialize products with real images
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
            [
                'id' => 2,
                'name' => 'Brown Sugar Boba',
                'description' => 'Rich brown sugar syrup with fresh milk and tapioca pearls',
                'price' => 5.00,
                'image' => '/assets/images/products/brown-sugar-boba.jpg',
                'category' => 'milk-tea',
                'discount' => '',
                'featured' => true
            ],
            [
                'id' => 3,
                'name' => 'Matcha Latte',
                'description' => 'Premium Japanese matcha with creamy milk',
                'price' => 5.50,
                'image' => '/assets/images/products/matcha-latte.jpg',
                'category' => 'milk-tea',
                'discount' => '',
                'featured' => true
            ],
            [
                'id' => 4,
                'name' => 'Strawberry Milk Tea',
                'description' => 'Sweet strawberry flavor with creamy milk tea',
                'price' => 4.75,
                'image' => '/assets/images/products/strawberry-milk-tea.jpg',
                'category' => 'milk-tea',
                'discount' => '15% OFF',
                'featured' => true
            ],
            [
                'id' => 5,
                'name' => 'Classic Milk Tea',
                'description' => 'Traditional milk tea with tapioca pearls',
                'price' => 4.00,
                'image' => '/assets/images/products/classic-milk-tea.jpg',
                'category' => 'milk-tea',
                'discount' => '',
                'featured' => true
            ],
            [
                'id' => 6,
                'name' => 'Mango Smoothie',
                'description' => 'Refreshing mango smoothie with popping boba',
                'price' => 5.25,
                'image' => '/assets/images/products/mango-smoothie.jpg',
                'category' => 'smoothies',
                'discount' => '',
                'featured' => true
            ],
            [
                'id' => 7,
                'name' => 'Thai Tea',
                'description' => 'Authentic Thai tea with sweet condensed milk',
                'price' => 4.50,
                'image' => '/assets/images/products/thai-tea.jpg',
                'category' => 'milk-tea',
                'discount' => '',
                'featured' => true
            ],
            [
                'id' => 8,
                'name' => 'Jasmine Green Tea',
                'description' => 'Fragrant jasmine green tea with honey',
                'price' => 3.75,
                'image' => '/assets/images/products/jasmine-green-tea.jpg',
                'category' => 'fruit-tea',
                'discount' => '',
                'featured' => true
            ],
            [
                'id' => 9,
                'name' => 'Coffee Milk Tea',
                'description' => 'Bold coffee flavor with creamy milk tea',
                'price' => 4.75,
                'image' => '/assets/images/products/coffee-milk-tea.jpg',
                'category' => 'coffee',
                'discount' => '',
                'featured' => false
            ],
            [
                'id' => 10,
                'name' => 'Lychee Fruit Tea',
                'description' => 'Sweet lychee fruit tea with jelly',
                'price' => 4.25,
                'image' => '/assets/images/products/lychee-fruit-tea.jpg',
                'category' => 'fruit-tea',
                'discount' => '20% OFF',
                'featured' => false
            ],
            [
                'id' => 11,
                'name' => 'Passion Fruit Tea',
                'description' => 'Tangy passion fruit tea with aloe vera',
                'price' => 4.50,
                'image' => '/assets/images/products/passion-fruit-tea.jpg',
                'category' => 'fruit-tea',
                'discount' => '',
                'featured' => false
            ],
            [
                'id' => 12,
                'name' => 'Honey Lemon Tea',
                'description' => 'Soothing honey lemon tea, perfect for cold days',
                'price' => 3.95,
                'image' => '/assets/images/products/honey-lemon-tea.jpg',
                'category' => 'fruit-tea',
                'discount' => '',
                'featured' => false
            ]
        ];

        // Initialize users
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

    public function getCategories() {
        return $this->categories;
    }

    public function getAllProducts() {
        return $this->products;
    }

    public function getFeaturedProducts() {
        return array_filter($this->products, function($product) {
            return $product['featured'] === true;
        });
    }

    public function getProductsByCategory($category) {
        if ($category === 'all') {
            return $this->products;
        }
        
        return array_filter($this->products, function($product) use ($category) {
            return $product['category'] === $category;
        });
    }

    public function getProductById($id) {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    public function getUserByEmail($email) {
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }

    public function getUserById($id) {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    public function getOrdersByUserId($userId) {
        return array_filter($this->orders, function($order) use ($userId) {
            return $order['user_id'] == $userId;
        });
    }

    public function addUser($name, $email, $password) {
        $id = count($this->users) + 1;
        $user = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'avatar' => '/assets/images/users/user3.jpg', // Default avatar
            'role' => 'user'
        ];
        
        $this->users[] = $user;
        return $id;
    }

    public function addOrder($userId, $productId, $size, $sugarLevel, $toppings, $price) {
        $id = count($this->orders) + 1;
        $order = [
            'id' => $id,
            'user_id' => $userId,
            'product_id' => $productId,
            'size' => $size,
            'sugar_level' => $sugarLevel,
            'toppings' => $toppings,
            'price' => $price,
            'status' => 'processing',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->orders[] = $order;
        return $id;
    }
}

