<?php

namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class OrdersController extends BaseController
{
    private $productModel;
    public function __construct()
    {
        // Initialize the product model if needed
        $this->productModel = new \YourNamespace\Models\ProductModel();
    }
    public function index()
    {
        // Fetch products from the database and map them with categories
        $products = array_map(function ($i) {
            return [
                'id' => $i['product_id'],	
                'name' => $i['product_name'],
                'description' => $i['product_detail'],
                'price' => $i['price'],
                'image' => $i['image'],
                'category' => $i['category'] // Use category from database
            ];
        }, $this->productModel->getProducts());

        $toppings =  [
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
            $favorites = isset($_SESSION['favorites']) ? $_SESSION['favorites'] : [];
        }

        // Get cart count for notification badge
        $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

        $this->views('order', [
            'title' => 'Order Drinks',
            'products' => $products,
            'toppings' => $toppings,
            'favorites' => $favorites,
            'cartCount' => $cartCount
        ]);
    }

    public function details($id)
    {
        // Sample product data with multiple categories including snack
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
            5 => [
                'id' => 5,
                'name' => 'Strawberry Smoothie',
                'description' => 'Refreshing strawberry smoothie blended with real fruit.',
                'price' => 6.00,
                'image' => '/assets/images/products/strawberry-smoothie.jpg',
                'category' => 'smoothie'
            ],
            6 => [
                'id' => 6,
                'name' => 'Mango Fruit Tea',
                'description' => 'Sweet mango-flavored tea with fresh fruit chunks.',
                'price' => 4.75,
                'image' => '/assets/images/products/mango-fruit-tea.jpg',
                'category' => 'fruit-tea'
            ],
            7 => [
                'id' => 7,
                'name' => 'Iced Americano',
                'description' => 'Bold espresso with cold water over ice.',
                'price' => 3.50,
                'image' => '/assets/images/products/iced-americano.jpg',
                'category' => 'coffee'
            ],
            8 => [
                'id' => 8,
                'name' => 'Passion Fruit Tea',
                'description' => 'Tangy passion fruit tea with a refreshing zing.',
                'price' => 4.50,
                'image' => '/assets/images/products/passion-fruit-tea.jpg',
                'category' => 'fruit-tea'
            ],
            9 => [
                'id' => 9,
                'name' => 'Crispy Snack Mix',
                'description' => 'A savory mix of crunchy snacks.',
                'price' => 3.50,
                'image' => '/assets/images/products/snack-mix.jpg',
                'category' => 'snack'
            ],
            10 => [
                'id' => 10,
                'name' => 'Spicy Chips',
                'description' => 'Crispy chips with a spicy kick.',
                'price' => 2.75,
                'image' => '/assets/images/products/spicy-chips.jpg',
                'category' => 'snack'
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

        $product = isset($products[$id]) ? $products[$id] : null;

        if (!$product) {
            // Handle product not found
            $_SESSION['error'] = 'Product not found';
            header('Location: /order');
            exit;
        }

        $this->views('order_details', [
            'title' => 'Customize Your ' . ($product['category'] === 'snack' ? 'Snack' : 'Drink'),
            'product' => $product,
            'toppings' => $product['category'] === 'snack' ? [] : $toppings // No toppings for snacks
        ]);
    }

    public function addToCart()
    {
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
        $requiredFields = ['product_id', 'quantity'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
                exit;
            }
        }

        // Fetch product from database to validate and get category
        $product = $this->productModel->find($data['product_id']);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }

        // For drinks, validate additional fields
        if ($product['category'] !== 'snack') {
            $drinkFields = ['size', 'sugar', 'ice'];
            foreach ($drinkFields as $field) {
                if (!isset($data[$field])) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => "Missing required field for drink: $field"]);
                    exit;
                }
            }
        }

        // Initialize cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Generate a unique ID for the cart item
        $cartItemId = uniqid();

        // Prepare cart item
        $cartItem = [
            'id' => $cartItemId,
            'product_id' => $data['product_id'],
            'product_name' => $product['product_name'],
            'category' => $product['category'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'total_price' => $data['price'] * $data['quantity'],
            'image' => $product['image'],
            'added_at' => date('Y-m-d H:i:s')
        ];

        // Add drink-specific fields if not a snack
        if ($product['category'] !== 'snack') {
            $cartItem['size'] = $data['size'];
            $cartItem['sugar'] = $data['sugar'];
            $cartItem['ice'] = $data['ice'];
            $cartItem['toppings'] = isset($data['toppings']) ? $data['toppings'] : [];
        }

        // Add to cart
        $_SESSION['cart'][] = $cartItem;

        echo json_encode([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => count($_SESSION['cart'])
        ]);
        exit;
    }

    public function cart()
    {
        // In a real application, you would fetch the cart items from the database
        // For now, we'll create sample data with multiple categories including snack
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
                'image' => '/assets/images/products/classic-milk-tea.jpg',
                'category' => 'milk-tea'
            ],
            [
                'id' => 2,
                'product_id' => 5,
                'product_name' => 'Strawberry Smoothie',
                'size' => 'large',
                'sugar' => '70%',
                'ice' => '30%',
                'toppings' => ['Fresh Fruit'],
                'quantity' => 2,
                'price' => 13.00,
                'image' => '/assets/images/products/strawberry-smoothie.jpg',
                'category' => 'smoothie'
            ],
            [
                'id' => 3,
                'product_id' => 6,
                'product_name' => 'Mango Fruit Tea',
                'size' => 'medium',
                'sugar' => '30%',
                'ice' => '50%',
                'toppings' => ['Aloe Vera'],
                'quantity' => 1,
                'price' => 5.50,
                'image' => '/assets/images/products/mango-fruit-tea.jpg',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 4,
                'product_id' => 9,
                'product_name' => 'Crispy Snack Mix',
                'quantity' => 1,
                'price' => 3.50,
                'image' => '/assets/images/products/snack-mix.jpg',
                'category' => 'snack'
            ]
        ];

        $this->views('cart', [
            'title' => 'Your Cart',
            'cartItems' => $cartItems,
            'subtotal' => 28.00,
            'tax' => 2.24,
            'total' => 30.24
        ]);
    }
}