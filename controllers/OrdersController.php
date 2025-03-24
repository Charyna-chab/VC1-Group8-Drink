<?php
class OrdersController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in - redirect to login if not
        if (!isset($_SESSION['user_id']) && $this->requiresAuth()) {
            $this->redirect('/login');
        }
    }
    
    // Method to determine if authentication is required
    protected function requiresAuth() {
        // Public pages like menu browsing don't require auth
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $publicActions = ['index', 'details'];
        
        return !in_array($action, $publicActions);
    }
    
    public function index() {
        // In a real application, you would fetch products from the database
        // For now, we'll create sample data
        $products = [
            [
                'id' => 1,
                'name' => 'Taiwan Milk Tea',
                'description' => 'A classic Taiwanese milk tea with a perfect blend of black tea and creamy milk, offering a smooth and rich taste.',
                'price' => 1.75,
                'image' => '/assets/image/products/1.png',
                'category' => 'milk-tea'
            ],
            [
                'id' => 2,
                'name' => 'Thai Tea Brown Sugar Red Bean',
                'description' => 'A rich and creamy Thai tea with brown sugar syrup, complemented by sweet red beans for an added texture and flavor.',
                'price' => 2.50,
                'image' => '/assets/image/products/2.png',
                'category' => 'milk-tea'
            ],
            [
                'id' => 3,
                'name' => 'Oolong Passion',
                'description' => 'A refreshing blend of passion fruit flavor and our premium milk tea.',
                'price' => 2.00,
                'image' => 'assets/image/products/3.png',
                'category' => 'milk-tea'
            ],
            [
                'id' => 4,
                'name' => 'No Name Jewels',
                'description' => 'A creamy milk tea topped with chewy boba pearls and brown sugar syrup.',
                'price' => 2.75,
                'image' => '/assets/image/products/4.png',
                'category' => 'milk-tea'
            ],
            [
                'id' => 5,
                'name' => 'Chocolate Cream',
                'description' => 'Refreshing chocolate cream tea blended with fresh strawberry puree and fruit bits.',
                'price' => 1.75,
                'image' => '/assets/image/products/5.png',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 6,
                'name' => 'No Name White Jewels',
                'description' => 'Tropical mango flavor blended with our premium tea, creating a refreshing experience.',
                'price' => 2.75,
                'image' => '/assets/image/products/6.png',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 7,
                'name' => 'True Milk Tea',
                'description' => 'A sweet lychee flavor mixed with premium tea and fruit bits for a delightful treat.',
                'price' => 4.75,
                'image' => '/assets/image/products/7.png',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 8,
                'name' => 'Caramel Late Cream',
                'description' => 'Tangy passion fruit flavor blended with our premium tea, topped with a creamy finish.',
                'price' => 1.75,
                'image' => '/assets/image/products/coffee-cream.png',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 9,
                'name' => 'Avocado Fresh milk',
                'description' => 'A creamy and refreshing blend of ripe avocado and fresh milk, offering a smooth and nutritious drink.',
                'price' => 2.50,
                'image' => '/assets/image/products/milk-tea-macha.png',
                'category' => 'smoothie'
            ],
            [
                'id' => 10,
                'name' => 'Ovaltine Stick Lava',
                'description' => 'A tropical mango smoothie made with fresh mango puree and creamy milk, topped with Ovaltine.',
                'price' => 2.50,
                'image' => '/assets/image/products/Ovaltine-stick-lava.png',
                'category' => 'smoothie'
            ],
            [
                'id' => 11,
                'name' => 'Xin Fu Cha Strawberry Fresh Milk',
                'description' => 'A creamy smoothie made with fresh strawberries and milk for a rich, sweet taste.',
                'price' => 2.00,
                'image' => '/assets/image/products/strawberry.png',
                'category' => 'smoothie'
            ],
            [
                'id' => 12,
                'name' => 'Vanilla Strawberry',
                'description' => 'A delightful smoothie made with sweet strawberries and creamy vanilla, blended to perfection for a deliciously smooth treat.',
                'price' => 5.75,
                'image' => '/assets/image/products/Vanilla Strawberry.png',
                'category' => 'smoothie'
            ],
            [
                'id' => 13,
                'name' => 'Trolach Machhiato',
                'description' => 'A rich and creamy coffee drink made with a shot of espresso, topped with frothy milk for a balanced, bold flavor.',
                'price' => 3.50,
                'image' => '/assets/image/products/Trolach Machhiato.png',
                'category' => 'coffee'
            ],
            [
                'id' => 14,
                'name' => 'Japan Yuzu',
                'description' => 'Espresso combined with steamed milk and rich caramel syrup, creating a sweet, creamy coffee experience.',
                'price' => 4.75,
                'image' => '/assets/image/products/japan Yuzu.png',
                'category' => 'coffee'
            ],
            [
                'id' => 15,
                'name' => 'Mocha',
                'description' => 'A delightful espresso drink with chocolate syrup and steamed milk for a sweet and smooth taste.',
                'price' => 4.50,
                'image' => '/assets/images/products/mocha.jpg',
                'category' => 'coffee'
            ],
            [
                'id' => 16,
                'name' => 'Vanilla Latte',
                'description' => 'Espresso combined with vanilla syrup and steamed milk for a sweet, comforting coffee.',
                'price' => 4.50,
                'image' => '/assets/images/products/vanilla-latte.jpg',
                'category' => 'coffee'
            ],
            [
                'id' => 17,
                'name' => 'Egg Waffles',
                'description' => 'Hong Kong-style egg waffles, crispy on the outside and fluffy on the inside, served fresh.',
                'price' => 4.00,
                'image' => '/assets/images/products/egg-waffles.jpg',
                'category' => 'snacks'
            ],
            [
                'id' => 18,
                'name' => 'Popcorn Chicken',
                'description' => 'Crispy Taiwanese-style popcorn chicken, seasoned with special spices for a savory snack.',
                'price' => 5.50,
                'image' => '/assets/images/products/popcorn-chicken.jpg',
                'category' => 'snacks'
            ],
            [
                'id' => 19,
                'name' => 'Sweet Potato Fries',
                'description' => 'Crispy and delicious sweet potato fries, seasoned with a special blend of spices.',
                'price' => 4.00,
                'image' => '/assets/images/products/sweet-potato-fries.jpg',
                'category' => 'snacks'
            ],
            [
                'id' => 20,
                'name' => 'Cheese Foam Cake',
                'description' => 'A soft sponge cake topped with our signature cheese foam, creating a creamy and sweet experience.',
                'price' => 4.50,
                'image' => '/assets/images/products/cheese-foam-cake.jpg',
                'category' => 'snacks'
            ]
            
        ];
        
        
        $toppings = [
            [
                'id' => 1,
                'name' => 'Boba Pearls',
                'price' => 0.75
            ],
            [
                'id' => 2,
                'name' => 'Grass Jelly',
                'price' => 0.75
            ],
            [
                'id' => 3,
                'name' => 'Pudding',
                'price' => 0.75
            ],
            [
                'id' => 4,
                'name' => 'Aloe Vera',
                'price' => 0.75
            ],
            [
                'id' => 5,
                'name' => 'Cheese Foam',
                'price' => 1.00
            ],
            [
                'id' => 6,
                'name' => 'Fresh Fruit',
                'price' => 1.00
            ],
            [
                'id' => 7,
                'name' => 'Red Bean',
                'price' => 0.75
            ],
            [
                'id' => 8,
                'name' => 'Coconut Jelly',
                'price' => 0.75
            ]
        ];
        
        // Get user favorites if logged in
        $favorites = [];
        if (isset($_SESSION['user_id'])) {
            // In a real app, you would fetch favorites from the database
            // For now, we'll get from localStorage via JavaScript
            // This is just a fallback for server-side rendering
            $favorites = isset($_SESSION['favorites']) ? $_SESSION['favorites'] : [];
        }
        
        $this->views('order', [
            'title' => 'Order Drinks',
            'products' => $products,
            'toppings' => $toppings,
            'favorites' => $favorites
        ]);
    }
    
    public function details($id) {
        // In a real application, you would fetch the product from the database
        // For now, we'll create a lookup array with all products
        $products = [
            1 => [
                'id' => 1,
                'name' => 'Taiwan Milk Tea',
                'description' => 'A classic Taiwanese milk tea with a perfect blend of black tea and creamy milk, offering a smooth and rich taste.',
                'price' => 1.75,
                'image' => '/assets/image/products/1.png',
                'category' => 'milk-tea'
            ],
            2 => [
                'id' => 2,
                'name' => 'Thai Tea Brown Sugar Red Bean',
                'description' => 'A rich and creamy Thai tea with brown sugar syrup, complemented by sweet red beans for an added texture and flavor.',
                'price' => 2.50,
                'image' => '/assets/image/products/2.png',
                'category' => 'milk-tea'
            ],
            // Add more products as needed
        ];
        
        $toppings = [
            [
                'id' => 1,
                'name' => 'Boba Pearls',
                'price' => 0.75
            ],
            [
                'id' => 2,
                'name' => 'Grass Jelly',
                'price' => 0.75
            ],
            [
                'id' => 3,
                'name' => 'Pudding',
                'price' => 0.75
            ],
            [
                'id' => 4,
                'name' => 'Aloe Vera',
                'price' => 0.75
            ],
            [
                'id' => 5,
                'name' => 'Cheese Foam',
                'price' => 1.00
            ],
            [
                'id' => 6,
                'name' => 'Fresh Fruit',
                'price' => 1.00
            ],
            [
                'id' => 7,
                'name' => 'Red Bean',
                'price' => 0.75
            ],
            [
                'id' => 8,
                'name' => 'Coconut Jelly',
                'price' => 0.75
            ]
        ];
        
        $product = isset($products[$id]) ? $products[$id] : null;
        
        if (!$product) {
            // Handle product not found
            $_SESSION['error'] = 'Product not found';
            header('Location: /order');
            exit;
        }
        
        $this->views('order_details', [
            'title' => 'Customize Your Drink',
            'product' => $product,
            'toppings' => $toppings
        ]);
    }
    
    public function addToCart() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get JSON data from request body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid request data']);
            exit;
        }
        
        // Validate required fields
        $requiredFields = ['product_id', 'size', 'sugar', 'ice', 'quantity'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
                exit;
            }
        }
        
        // In a real application, you would:
        // 1. Validate the product exists
        // 2. Calculate the correct price
        // 3. Add the item to the user's cart in the database
        
        // For now, we'll just store in session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Generate a unique ID for the cart item
        $cartItemId = uniqid();
        
        // Add to cart
        $_SESSION['cart'][] = [
            'id' => $cartItemId,
            'product_id' => $data['product_id'],
            'size' => $data['size'],
            'sugar' => $data['sugar'],
            'ice' => $data['ice'],
            'toppings' => isset($data['toppings']) ? $data['toppings'] : [],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'total_price' => $data['price'] * $data['quantity'],
            'added_at' => date('Y-m-d H:i:s')
        ];
        
        echo json_encode([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => count($_SESSION['cart'])
        ]);
        exit;
    }
    
    public function cart() {
        // In a real application, you would fetch the cart items from the database
        // For now, we'll use session data
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['total_price'];
        }
        
        $tax = $subtotal * 0.08; // 8% tax
        $total = $subtotal + $tax;
        
        $this->views('cart', [
            'title' => 'Your Cart',
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);
    }
    
    public function checkout() {
        // Check if cart is empty
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION['error'] = 'Your cart is empty';
            header('Location: /order');
            exit;
        }

        $_SESSION['success'] = 'Your order has been placed successfully';
        
        // Clear the cart
        $_SESSION['cart'] = [];
        
        header('Location: /booking');
        exit;
    }
    
    public function booking() {
        // In a real application, you would fetch the user's orders from the database
        // For now, we'll create sample data
        $orders = [
            [
                'id' => 'ORD123456',
                'date' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'items' => [
                    [
                        'name' => 'Taiwan Milk Tea',
                        'size' => 'Medium',
                        'sugar' => '50%',
                        'ice' => 'Normal',
                        'toppings' => ['Boba Pearls', 'Pudding'],
                        'quantity' => 2,
                        'price' => 5.50
                    ],
                    [
                        'name' => 'Thai Tea Brown Sugar Red Bean',
                        'size' => 'Large',
                        'sugar' => '70%',
                        'ice' => 'Less',
                        'toppings' => ['Red Bean'],
                        'quantity' => 1,
                        'price' => 3.50
                    ]
                ],
                'subtotal' => 14.50,
                'tax' => 1.16,
                'total' => 15.66,
                'status' => 'completed'
            ],
            [
                'id' => 'ORD123457',
                'date' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'items' => [
                    [
                        'name' => 'Oolong Passion',
                        'size' => 'Large',
                        'sugar' => '30%',
                        'ice' => 'Normal',
                        'toppings' => ['Aloe Vera'],
                        'quantity' => 1,
                        'price' => 3.00
                    ]
                ],
                'subtotal' => 3.00,
                'tax' => 0.24,
                'total' => 3.24,
                'status' => 'processing'
            ]
        ];
        
        $this->views('booking', [
            'title' => 'Your Orders',
            'orders' => $orders
        ]);
    }
}

