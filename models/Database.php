<?php
class Database {
    private static $instance = null;
    private $products = [];
    private $categories = [];
    private $users = [];
    private $orders = [];
    private $toppings = [];
    private $bookings = [];
    private $favorites = [];

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
            ['id' => 2, 'name' => 'Milk Tea', 'slug' => 'milk_tea'],
            ['id' => 3, 'name' => 'Fruit Tea', 'slug' => 'fruit_tea'],
            ['id' => 4, 'name' => 'Smoothies', 'slug' => 'smoothies'],
            ['id' => 5, 'name' => 'Coffee', 'slug' => 'coffee'],
            ['id' => 6, 'name' => 'Snacks', 'slug' => 'snacks']
        ];

        // Initialize products
        $this->products = [
            [
                'id' => 1,
                'name' => 'Classic Milk Tea',
                'description' => 'Traditional milk tea with tapioca pearls',
                'price' => 4.00,
                'image' => '/assets/image/products/classic-milk-tea.jpg',
                'category' => 'milk_tea',
                'popular' => true
            ],
            [
                'id' => 2,
                'name' => 'Taro Milk Tea',
                'description' => 'Creamy taro milk tea with chewy tapioca pearls',
                'price' => 4.50,
                'image' => '/assets/image/products/taro-milk-tea.jpg',
                'category' => 'milk_tea',
                'popular' => true
            ],
            [
                'id' => 3,
                'name' => 'Brown Sugar Boba',
                'description' => 'Rich brown sugar syrup with fresh milk and tapioca pearls',
                'price' => 5.00,
                'image' => '/assets/image/products/brown-sugar-boba.jpg',
                'category' => 'milk_tea',
                'popular' => true
            ],
            [
                'id' => 4,
                'name' => 'Matcha Latte',
                'description' => 'Premium Japanese matcha with creamy milk',
                'price' => 5.50,
                'image' => '/assets/image/products/matcha-latte.jpg',
                'category' => 'milk_tea',
                'popular' => false
            ],
            [
                'id' => 5,
                'name' => 'Strawberry Milk Tea',
                'description' => 'Sweet strawberry flavor with creamy milk tea',
                'price' => 4.75,
                'image' => '/assets/image/products/strawberry-milk-tea.jpg',
                'category' => 'milk_tea',
                'popular' => false
            ],
            [
                'id' => 6,
                'name' => 'Mango Smoothie',
                'description' => 'Refreshing mango smoothie with popping boba',
                'price' => 5.25,
                'image' => '/assets/image/products/mango-smoothie.jpg',
                'category' => 'smoothies',
                'popular' => true
            ],
            [
                'id' => 7,
                'name' => 'Thai Tea',
                'description' => 'Authentic Thai tea with sweet condensed milk',
                'price' => 4.50,
                'image' => '/assets/image/products/thai-tea.jpg',
                'category' => 'milk_tea',
                'popular' => false
            ],
            [
                'id' => 8,
                'name' => 'Jasmine Green Tea',
                'description' => 'Fragrant jasmine green tea with honey',
                'price' => 3.75,
                'image' => '/assets/image/products/jasmine-tea.jpg',
                'category' => 'fruit_tea',
                'popular' => false
            ],
            [
                'id' => 9,
                'name' => 'Coffee Milk Tea',
                'description' => 'Bold coffee flavor with creamy milk tea',
                'price' => 4.75,
                'image' => '/assets/image/products/coffee-milk-tea.jpg',
                'category' => 'coffee',
                'popular' => false
            ],
            [
                'id' => 10,
                'name' => 'Lychee Fruit Tea',
                'description' => 'Sweet lychee fruit tea with jelly',
                'price' => 4.25,
                'image' => '/assets/image/products/lychee-tea.jpg',
                'category' => 'fruit_tea',
                'popular' => false
            ],
            [
                'id' => 11,
                'name' => 'Passion Fruit Tea',
                'description' => 'Tangy passion fruit tea with aloe vera',
                'price' => 4.50,
                'image' => '/assets/image/products/passion-fruit-tea.jpg',
                'category' => 'fruit_tea',
                'popular' => false
            ],
            [
                'id' => 12,
                'name' => 'Honey Lemon Tea',
                'description' => 'Soothing honey lemon tea, perfect for cold days',
                'price' => 3.95,
                'image' => '/assets/image/products/honey-lemon-tea.jpg',
                'category' => 'fruit_tea',
                'popular' => false
            ]
        ];

        // Initialize toppings
        $this->toppings = [
            ['id' => 1, 'name' => 'Pearl', 'price' => 0.85],
            ['id' => 2, 'name' => 'Jelly', 'price' => 0.85],
            ['id' => 3, 'name' => 'Cream', 'price' => 0.85],
            ['id' => 4, 'name' => 'Cheese Foam', 'price' => 0.85],
            ['id' => 5, 'name' => 'Coconut Jelly', 'price' => 0.85],
            ['id' => 6, 'name' => 'Red Bean', 'price' => 0.85]
        ];
        
        // Initialize users
        $this->users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'avatar' => '/assets/image/users/user1.jpg',
                'role' => 'user'
            ],
            [
                'id' => 2,
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'avatar' => '/assets/image/users/admin.jpg',
                'role' => 'admin'
            ]
        ];
        
        // Initialize orders
        $this->orders = [
            [
                'id' => 1,
                'user_id' => 1,
                'items' => [
                    [
                        'product_id' => 1,
                        'name' => 'Classic Milk Tea',
                        'price' => 4.00,
                        'size' => 'medium',
                        'sugar' => '50%',
                        'toppings' => ['Pearl'],
                        'quantity' => 1
                    ]
                ],
                'total' => 4.85,
                'status' => 'completed',
                'created_at' => '2023-03-15 14:30:00'
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'items' => [
                    [
                        'product_id' => 3,
                        'name' => 'Brown Sugar Boba',
                        'price' => 5.00,
                        'size' => 'large',
                        'sugar' => '70%',
                        'toppings' => ['Pearl', 'Cream'],
                        'quantity' => 1
                    ],
                    [
                        'product_id' => 6,
                        'name' => 'Mango Smoothie',
                        'price' => 5.25,
                        'size' => 'medium',
                        'sugar' => '30%',
                        'toppings' => ['Jelly'],
                        'quantity' => 1
                    ]
                ],
                'total' => 12.95,
                'status' => 'processing',
                'created_at' => '2023-03-16 10:15:00'
            ]
        ];
        
        // Initialize bookings
        $this->bookings = [
            [
                'id' => 1,
                'user_id' => 1,
                'date' => '2023-03-20',
                'time' => '14:00:00',
                'guests' => 2,
                'status' => 'confirmed',
                'notes' => 'Window seat preferred',
                'created_at' => '2023-03-15 09:30:00'
            ]
        ];
        
        // Initialize favorites
        $this->favorites = [
            [
                'id' => 1,
                'user_id' => 1,
                'product_id' => 3,
                'created_at' => '2023-03-10 15:45:00'
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'product_id' => 6,
                'created_at' => '2023-03-12 11:20:00'
            ]
        ];
    }

    // Product methods
    public function getCategories() {
        return $this->categories;
    }

    public function getAllProducts() {
        return $this->products;
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

    public function getFeaturedProducts() {
        return array_filter($this->products, function($product) {
            return isset($product['popular']) && $product['popular'] === true;
        });
    }
    
    public function searchProducts($query) {
        return array_filter($this->products, function($product) use ($query) {
            return stripos($product['name'], $query) !== false || 
                   stripos($product['description'], $query) !== false;
        });
    }

    // Topping methods
    public function getAllToppings() {
        return $this->toppings;
    }
    
    public function getToppingById($id) {
        foreach ($this->toppings as $topping) {
            if ($topping['id'] == $id) {
                return $topping;
            }
        }
        return null;
    }
    
    // User methods
    public function getUserById($id) {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) {
                return $user;
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
    
    public function createUser($name, $email, $password) {
        $id = count($this->users) + 1;
        $this->users[] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'avatar' => '/assets/image/users/default.jpg',
            'role' => 'user'
        ];
        return $id;
    }
    
    public function updateUserProfile($id, $name, $email, $phone) {
        foreach ($this->users as &$user) {
            if ($user['id'] == $id) {
                $user['name'] = $name;
                $user['email'] = $email;
                $user['phone'] = $phone;
                return true;
            }
        }
        return false;
    }
    
    public function updateUserPassword($id, $password) {
        foreach ($this->users as &$user) {
            if ($user['id'] == $id) {
                $user['password'] = $password;
                return true;
            }
        }
        return false;
    }
    
    // Order methods
    public function getOrdersByUserId($userId) {
        return array_filter($this->orders, function($order) use ($userId) {
            return $order['user_id'] == $userId;
        });
    }
    
    public function getRecentOrdersByUserId($userId, $limit = 5) {
        $userOrders = $this->getOrdersByUserId($userId);
        usort($userOrders, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return array_slice($userOrders, 0, $limit);
    }
    
    public function getOrderById($id) {
        foreach ($this->orders as $order) {
            if ($order['id'] == $id) {
                return $order;
            }
        }
        return null;
    }
    
    // Booking methods
    public function getBookingsByUserId($userId) {
        return array_filter($this->bookings, function($booking) use ($userId) {
            return $booking['user_id'] == $userId;
        });
    }
    
    public function getBookingById($id) {
        foreach ($this->bookings as $booking) {
            if ($booking['id'] == $id) {
                return $booking;
            }
        }
        return null;
    }
    
    // Favorite methods
    public function getFavoritesByUserId($userId) {
        $favorites = array_filter($this->favorites, function($favorite) use ($userId) {
            return $favorite['user_id'] == $userId;
        });
        
        // Add product details to favorites
        foreach ($favorites as &$favorite) {
            $favorite['product'] = $this->getProductById($favorite['product_id']);
        }
        
        return $favorites;
    }
    
    public function getFavoriteProductsByUserId($userId) {
        $favorites = $this->getFavoritesByUserId($userId);
        $products = [];
        
        foreach ($favorites as $favorite) {
            $products[] = $this->getProductById($favorite['product_id']);
        }
        
        return $products;
    }
    
    public function addFavorite($userId, $productId) {
        // Check if already in favorites
        foreach ($this->favorites as $favorite) {
            if ($favorite['user_id'] == $userId && $favorite['product_id'] == $productId) {
                return true; // Already a favorite
            }
        }
        
        $id = count($this->favorites) + 1;
        $this->favorites[] = [
            'id' => $id,
            'user_id' => $userId,
            'product_id' => $productId,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return true;
    }
    
    public function removeFavorite($userId, $favoriteId) {
        foreach ($this->favorites as $key => $favorite) {
            if ($favorite['id'] == $favoriteId && $favorite['user_id'] == $userId) {
                unset($this->favorites[$key]);
                return true;
            }
        }
        
        return false;
    }
    
    // Remember token methods
    public function saveRememberToken($userId, $token, $expires) {
        // In a real app, you would save this to a database
        // For this demo, we'll just return true
        return true;
    }
    
    // Feedback methods
    public function saveFeedback($name, $email, $subject, $message) {
        // In a real app, you would save this to a database
        // For this demo, we'll just return true
        return true;
    }
}

