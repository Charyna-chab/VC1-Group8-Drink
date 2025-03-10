<?php
class Database {
    private static $instance = null;
    private $products = [];
    private $categories = [];
    private $users = [];
    private $orders = [];
    private $toppings = [];
    
    private function __construct() {
        // Initialize with fake data
        $this->initCategories();
        $this->initProducts();
        $this->initToppings();
        $this->initUsers();
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    private function initCategories() {
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
    
    private function initProducts() {
        $this->products = [
            // Milk Tea Category
            [
                'id' => 'classic-milk-tea',
                'name' => 'Classic Milk Tea',
                'price' => 3.00,
                'image' => '/assets/images/products/classic-milk-tea.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '10% Off!',
                'description' => 'Our signature classic milk tea with a perfect balance of tea and creamy milk.',
                'is_featured' => true
            ],
            [
                'id' => 'black-milk-tea',
                'name' => 'Black Milk Tea',
                'price' => 3.25,
                'image' => '/assets/images/products/black-milk-tea.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '5% Off!',
                'description' => 'Strong black tea blended with creamy milk for a rich and satisfying flavor.',
                'is_featured' => true
            ],
            [
                'id' => 'chocolate-milk-tea',
                'name' => 'Chocolate Milk Tea',
                'price' => 3.50,
                'image' => '/assets/image/Chocolate-milk-tea.png',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '10% Off!',
                'description' => 'Rich and creamy chocolate milk tea, a perfect sweet treat!',
                'is_featured' => true
            ],
            [
                'id' => 'brown-sugar-milk-tea',
                'name' => 'Brown Sugar Milk Tea',
                'price' => 3.75,
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
            [
                'id' => 'purple-sweet-potato',
                'name' => 'Purple Sweet Potato Milk Tea',
                'price' => 3.75,
                'image' => '/assets/images/products/purple-sweet-potato.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '8% Off!',
                'description' => 'Creamy milk tea infused with the natural sweetness of purple sweet potato, creating a unique and delicious flavor profile.',
                'is_featured' => true
            ],
            [
                'id' => 'matcha-milk-tea',
                'name' => 'Matcha Milk Tea',
                'price' => 3.95,
                'image' => '/assets/images/products/matcha-milk-tea.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '5% Off!',
                'description' => 'Premium Japanese matcha powder blended with creamy milk for an authentic and refreshing experience.',
                'is_featured' => true
            ],
            [
                'id' => 'thai-tea',
                'name' => 'Thai Milk Tea',
                'price' => 3.50,
                'image' => '/assets/images/products/thai-tea.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '10% Off!',
                'description' => 'Traditional Thai tea with its distinctive orange color and rich, creamy taste with condensed milk.',
                'is_featured' => false
            ],
            [
                'id' => 'ovaltine-stick-lava',
                'name' => 'Ovaltine Stick Lava',
                'price' => 3.50,
                'image' => '/assets/images/products/ovaltine-stick-lava.jpg',
                'category_id' => 3,
                'category' => 'milk-tea',
                'discount' => '5% Off!',
                'description' => 'Indulge in the creamy richness of our Ovaltine Stick Lava, expertly blended with the natural sweetness of ovaltine. This delightful drink offers the perfect balance of smooth, velvety milk tea with a hint of sweet, malty flavor.',
                'is_featured' => false
            ],
    
            // Tea Category (Adding new tea options)
            [
                'id' => 'taiwan-tea',
                'name' => 'Taiwan Oolong Tea',
                'price' => 3.25,
                'image' => '/assets/images/products/taiwan-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '5% Off!',
                'description' => 'Authentic Taiwanese oolong tea with a delicate floral aroma and smooth finish.',
                'is_featured' => true
            ],
            [
                'id' => 'jasmine-tea',
                'name' => 'Jasmine Green Tea',
                'price' => 2.95,
                'image' => '/assets/images/products/jasmine-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '8% Off!',
                'description' => 'Fragrant jasmine-infused green tea with a delicate floral aroma.',
                'is_featured' => false
            ],
            [
                'id' => 'black-tea',
                'name' => 'Pure Black Tea',
                'price' => 2.75,
                'image' => '/assets/images/products/black-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '5% Off!',
                'description' => 'Bold and robust black tea, served hot or cold for a refreshing experience.',
                'is_featured' => false
            ],
            [
                'id' => 'honey-tea',
                'name' => 'Honey Green Tea',
                'price' => 3.25,
                'image' => '/assets/images/products/honey-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '10% Off!',
                'description' => 'Delicate green tea sweetened with natural honey for a soothing experience.',
                'is_featured' => true
            ],
            [
                'id' => 'oolong-tea',
                'name' => 'Oolong Tea',
                'price' => 3.00,
                'image' => '/assets/images/products/oolong-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '5% Off!',
                'description' => 'Semi-oxidized tea with a perfect balance between green and black tea, offering a complex flavor profile.',
                'is_featured' => false
            ],
            [
                'id' => 'earl-grey',
                'name' => 'Earl Grey Tea',
                'price' => 3.25,
                'image' => '/assets/images/products/earl-grey.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '8% Off!',
                'description' => 'Classic black tea infused with bergamot oil for a distinctive citrusy aroma and flavor.',
                'is_featured' => false
            ],
            [
                'id' => 'japan-tea',
                'name' => 'Japanese Sencha Tea',
                'price' => 3.50,
                'image' => '/assets/images/products/japan-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '5% Off!',
                'description' => 'Premium Japanese green tea with a refreshing taste and grassy notes.',
                'is_featured' => true
            ],
    
            // Seasonal Category
            [
                'id' => 'pumpkin-spice-latte',
                'name' => 'Pumpkin Spice Latte',
                'price' => 4.00,
                'image' => '/assets/images/products/pumpkin-spice-latte.jpg',
                'category_id' => 2,
                'category' => 'seasonal',
                'discount' => '10% Off!',
                'description' => 'A warm and comforting pumpkin spice drink for the fall.',
                'is_featured' => true
            ],
            [
                'id' => 'gingerbread-latte',
                'name' => 'Gingerbread Latte',
                'price' => 3.75,
                'image' => '/assets/images/products/gingerbread-latte.jpg',
                'category_id' => 2,
                'category' => 'seasonal',
                'discount' => '15% Off!',
                'description' => 'A festive latte with gingerbread flavor.',
                'is_featured' => false
            ],
    
            // Coffee Category
            [
                'id' => 'americano',
                'name' => 'Americano',
                'price' => 2.75,
                'image' => '/assets/images/products/americano.jpg',
                'category_id' => 4,
                'category' => 'coffee',
                'discount' => '5% Off!',
                'description' => 'Classic espresso diluted with hot water.',
                'is_featured' => true
            ],
            [
                'id' => 'latte',
                'name' => 'Latte',
                'price' => 3.50,
                'image' => '/assets/images/products/latte.jpg',
                'category_id' => 4,
                'category' => 'coffee',
                'discount' => '10% Off!',
                'description' => 'Espresso with steamed milk and a light layer of foam.',
                'is_featured' => true
            ],
    
            // Fruit Tea Category
            [
                'id' => 'peach-tea',
                'name' => 'Peach Tea',
                'price' => 3.00,
                'image' => '/assets/images/products/peach-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '10% Off!',
                'description' => 'Refreshing tea with sweet peach flavor.',
                'is_featured' => true
            ],
            [
                'id' => 'lychee-tea',
                'name' => 'Lychee Tea',
                'price' => 3.25,
                'image' => '/assets/images/products/lychee-tea.jpg',
                'category_id' => 7,
                'category' => 'fruit-tea',
                'discount' => '8% Off!',
                'description' => 'Fragrant tea with exotic lychee flavor.',
                'is_featured' => false
            ],
    
            // Bread Category
            [
                'id' => 'croissant',
                'name' => 'Croissant',
                'price' => 2.50,
                'image' => '/assets/images/products/croissant.jpg',
                'category_id' => 6,
                'category' => 'bread',
                'discount' => '10% Off!',
                'description' => 'Flaky and buttery French-style croissant.',
                'is_featured' => true
            ],
            [
                'id' => 'chocolate-croissant',
                'name' => 'Chocolate Croissant',
                'price' => 2.75,
                'image' => '/assets/images/products/chocolate-croissant.jpg',
                'category_id' => 6,
                'category' => 'bread',
                'discount' => '15% Off!',
                'description' => 'Buttery croissant filled with rich chocolate.',
                'is_featured' => false
            ],
    
            // Smoothie Category
            [
                'id' => 'mango-smoothie',
                'name' => 'Mango Smoothie',
                'price' => 4.00,
                'image' => '/assets/images/products/mango-smoothie.jpg',
                'category_id' => 8,
                'category' => 'smoothie',
                'discount' => '10% Off!',
                'description' => 'Tropical mango smoothie with creamy texture.',
                'is_featured' => true
            ],
            [
                'id' => 'berry-smoothie',
                'name' => 'Berry Smoothie',
                'price' => 3.75,
                'image' => '/assets/images/products/berry-smoothie.jpg',
                'category_id' => 8,
                'category' => 'smoothie',
                'discount' => '12% Off!',
                'description' => 'A blend of fresh berries for a refreshing drink.',
                'is_featured' => false
            ],
    
            // Lemon Drink Category
            [
                'id' => 'lemonade',
                'name' => 'Lemonade',
                'price' => 2.50,
                'image' => '/assets/images/products/lemonade.jpg',
                'category_id' => 5,
                'category' => 'lemon-drink',
                'discount' => '10% Off!',
                'description' => 'Freshly squeezed lemonade with a tangy twist.',
                'is_featured' => true
            ],
            [
                'id' => 'pink-lemonade',
                'name' => 'Pink Lemonade',
                'price' => 2.75,
                'image' => '/assets/images/products/pink-lemonade.jpg',
                'category_id' => 5,
                'category' => 'lemon-drink',
                'discount' => '8% Off!',
                'description' => 'Sweet and tangy pink lemonade.',
                'is_featured' => false
            ],
    
            // Pastry Category
            [
                'id' => 'cheesecake',
                'name' => 'Cheesecake',
                'price' => 3.50,
                'image' => '/assets/images/products/cheesecake.jpg',
                'category_id' => 9,
                'category' => 'pastry',
                'discount' => '10% Off!',
                'description' => 'Creamy cheesecake with a graham cracker crust.',
                'is_featured' => true
            ],
            [
                'id' => 'chocolate-cake',
                'name' => 'Chocolate Cake',
                'price' => 3.75,
                'image' => '/assets/images/products/chocolate-cake.jpg',
                'category_id' => 9,
                'category' => 'pastry',
                'discount' => '15% Off!',
                'description' => 'Rich chocolate cake with a velvety texture.',
                'is_featured' => false
            ]
        ];
    }
    
    
    private function initToppings() {
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
    
    private function initUsers() {
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
    public function getAllProducts() {
        return $this->products;
    }
    
    public function getProductById($id) {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }
    
    public function getProductsByCategory($category) {
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
    
    public function getFeaturedProducts() {
        $result = [];
        foreach ($this->products as $product) {
            if ($product['is_featured']) {
                $result[] = $product;
            }
        }
        return $result;
    }
    
    // Category methods
    public function getAllCategories() {
        return $this->categories;
    }
    
    public function getCategoryById($id) {
        foreach ($this->categories as $category) {
            if ($category['id'] == $id) {
                return $category;
            }
        }
        return null;
    }
    
    // Topping methods
    public function getAllToppings() {
        return $this->toppings;
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
    
    public function getUserByUsername($username) {
        foreach ($this->users as $user) {
            if ($user['username'] == $username) {
                return $user;
            }
        }
        return null;
    }
    
    // Order methods
    public function createOrder($data) {
        $orderId = uniqid('ORD');
        $data['id'] = $orderId;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status'] = 'pending';
        
        $this->orders[] = $data;
        return $orderId;
    }
    
    public function getOrdersByUserId($userId) {
        $result = [];
        foreach ($this->orders as $order) {
            if ($order['user_id'] == $userId) {
                $result[] = $order;
            }
        }
        return $result;
    }
}
?>