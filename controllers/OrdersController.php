<?php
class OrderController extends BaseController {
    public function index() {
        // In a real application, you would fetch products from the database
        // For now, we'll create sample data
        $products = [
            [
                'id' => 1,
                'name' => 'Classic Milk Tea',
                'description' => 'Our signature milk tea with premium black tea and creamy milk.',
                'price' => 4.50,
                'image' => '/assets/images/products/classic-milk-tea.jpg',
                'category' => 'milk-tea'
            ],
            [
                'id' => 2,
                'name' => 'Taro Milk Tea',
                'description' => 'Creamy taro flavor blended with our premium milk tea.',
                'price' => 5.00,
                'image' => '/assets/images/products/taro-milk-tea.jpg',
                'category' => 'milk-tea'
            ],
            [
                'id' => 3,
                'name' => 'Matcha Latte',
                'description' => 'Premium Japanese matcha powder with fresh milk.',
                'price' => 5.50,
                'image' => 'assets/image/products/Macha-drink-milk-tea.png',
                'category' => 'milk-tea'
            ],
            [
                'id' => 4,
                'name' => 'Brown Sugar Boba Milk',
                'description' => 'Fresh milk with brown sugar syrup and chewy boba pearls.',
                'price' => 5.75,
                'image' => '/assets/images/products/brown-sugar-boba.jpg',
                'category' => 'milk-tea'
            ],
            [
                'id' => 5,
                'name' => 'Strawberry Fruit Tea',
                'description' => 'Refreshing tea with fresh strawberry puree and fruit bits.',
                'price' => 4.75,
                'image' => '/assets/images/products/strawberry-tea.jpg',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 6,
                'name' => 'Mango Fruit Tea',
                'description' => 'Tropical mango flavor blended with our premium tea.',
                'price' => 4.75,
                'image' => '/assets/images/products/mango-tea.jpg',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 7,
                'name' => 'Lychee Fruit Tea',
                'description' => 'Sweet lychee flavor with our premium tea and fruit bits.',
                'price' => 4.75,
                'image' => '/assets/images/products/lychee-tea.jpg',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 8,
                'name' => 'Passion Fruit Tea',
                'description' => 'Tangy passion fruit with our premium tea and fruit bits.',
                'price' => 4.75,
                'image' => '/assets/images/products/passion-fruit-tea.jpg',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 9,
                'name' => 'Strawberry Smoothie',
                'description' => 'Creamy smoothie with fresh strawberries and milk.',
                'price' => 5.50,
                'image' => '/assets/images/products/strawberry-smoothie.jpg',
                'category' => 'smoothie'
            ],
            [
                'id' => 10,
                'name' => 'Mango Smoothie',
                'description' => 'Tropical mango smoothie with fresh mango puree and milk.',
                'price' => 5.50,
                'image' => '/assets/images/products/mango-smoothie.jpg',
                'category' => 'smoothie'
            ],
            [
                'id' => 11,
                'name' => 'Avocado Smoothie',
                'description' => 'Creamy avocado smoothie with fresh avocado and milk.',
                'price' => 6.00,
                'image' => '/assets/images/products/avocado-smoothie.jpg',
                'category' => 'smoothie'
            ],
            [
                'id' => 12,
                'name' => 'Blueberry Smoothie',
                'description' => 'Antioxidant-rich blueberry smoothie with fresh blueberries and milk.',
                'price' => 5.75,
                'image' => '/assets/images/products/blueberry-smoothie.jpg',
                'category' => 'smoothie'
            ],
            [
                'id' => 13,
                'name' => 'Americano',
                'description' => 'Classic espresso diluted with hot water.',
                'price' => 3.50,
                'image' => '/assets/images/products/americano.jpg',
                'category' => 'coffee'
            ],
            [
                'id' => 14,
                'name' => 'Caramel Macchiato',
                'description' => 'Espresso with steamed milk and caramel syrup.',
                'price' => 4.75,
                'image' => '/assets/images/products/caramel-macchiato.jpg',
                'category' => 'coffee'
            ],
            [
                'id' => 15,
                'name' => 'Mocha',
                'description' => 'Espresso with chocolate syrup and steamed milk.',
                'price' => 4.50,
                'image' => '/assets/images/products/mocha.jpg',
                'category' => 'coffee'
            ],
            [
                'id' => 16,
                'name' => 'Vanilla Latte',
                'description' => 'Espresso with vanilla syrup and steamed milk.',
                'price' => 4.50,
                'image' => '/assets/images/products/vanilla-latte.jpg',
                'category' => 'coffee'
            ],
            [
                'id' => 17,
                'name' => 'Egg Waffles',
                'description' => 'Crispy on the outside, fluffy on the inside Hong Kong style egg waffles.',
                'price' => 4.00,
                'image' => '/assets/images/products/egg-waffles.jpg',
                'category' => 'snacks'
            ],
            [
                'id' => 18,
                'name' => 'Popcorn Chicken',
                'description' => 'Crispy Taiwanese-style popcorn chicken with special seasoning.',
                'price' => 5.50,
                'image' => '/assets/images/products/popcorn-chicken.jpg',
                'category' => 'snacks'
            ],
            [
                'id' => 19,
                'name' => 'Sweet Potato Fries',
                'description' => 'Crispy sweet potato fries with special seasoning.',
                'price' => 4.00,
                'image' => '/assets/images/products/sweet-potato-fries.jpg',
                'category' => 'snacks'
            ],
            [
                'id' => 20,
                'name' => 'Cheese Foam Cake',
                'description' => 'Soft sponge cake topped with our signature cheese foam.',
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
            // For now, we'll use sample data
            $favorites = [1, 4, 9]; // Sample favorite product IDs
        }
        
        $this->view('order', [
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
                'name' => 'Classic Milk Tea',
                'description' => 'Our signature milk tea with premium black tea and creamy milk.',
                'price' => 4.50,
                'image' => '/assets/images/products/classic-milk-tea.jpg',
                'category' => 'milk-tea'
            ],
            2 => [
                'id' => 2,
                'name' => 'Taro Milk Tea',
                'description' => 'Creamy taro flavor blended with our premium milk tea.',
                'price' => 5.00,
                'image' => '/assets/images/products/taro-milk-tea.jpg',
                'category' => 'milk-tea'
            ],
            3 => [
                'id' => 3,
                'name' => 'Matcha Latte',
                'description' => 'Premium Japanese matcha powder with fresh milk.',
                'price' => 5.50,
                'image' => '/assets/images/products/matcha-latte.jpg',
                'category' => 'milk-tea'
            ],
            4 => [
                'id' => 4,
                'name' => 'Brown Sugar Boba Milk',
                'description' => 'Fresh milk with brown sugar syrup and chewy boba pearls.',
                'price' => 5.75,
                'image' => '/assets/images/products/brown-sugar-boba.jpg',
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
        
        $this->view('order_details', [
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
        
        // For now, we'll just return success
        echo json_encode([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => isset($_SESSION['cart']) ? count($_SESSION['cart']) + 1 : 1
        ]);
        exit;
    }
    
    public function cart() {
        // In a real application, you would fetch the cart items from the database
        // For now, we'll create sample data
        $cartItems = [
            [
                'id' => 1,
                'product_id' => 1,
                'product_name' => 'Classic Milk Tea',
                'size' => 'medium',
                'sugar' => '50%',
                'ice' => '100%',
                'toppings' => ['Boba Pearls', 'Pudding'],
                'quantity' => 1,
                'price' => 6.00,
                'image' => '/assets/images/products/classic-milk-tea.jpg'
            ],
            [
                'id' => 2,
                'product_id' => 9,
                'product_name' => 'Strawberry Smoothie',
                'size' => 'large',
                'sugar' => '70%',
                'ice' => '30%',
                'toppings' => ['Fresh Fruit'],
                'quantity' => 2,
                'price' => 13.00,
                'image' => '/assets/images/products/strawberry-smoothie.jpg'
            ]
        ];
        
        $this->view('cart', [
            'title' => 'Your Cart',
            'cartItems' => $cartItems,
            'subtotal' => 19.00,
            'tax' => 1.52,
            'total' => 20.52
        ]);
    }
}

