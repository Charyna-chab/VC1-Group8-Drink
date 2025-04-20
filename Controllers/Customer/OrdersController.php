<?php

namespace YourNamespace\Controllers;
// namespace YourNamespace\Models;

use YourNamespace\BaseController;

class OrdersController extends BaseController
{
    private $productModel;
    private $toppingModel;
    public function __construct()
    {
        // Initialize the product model if needed
        $this->productModel = new \YourNamespace\Models\ProductModel();
        // $this->toppingModel = new \YourNamespace\Models\ToppingModel();
    }
    public function index()
    {
        // In a real application, you would fetch products from the database
        // For now, we'll create sample data
        $products = array_map(function ($i) {
            return [
                'id' => $i['product_id'],	
                'name' => $i['product_name'],
                'description' => $i['product_detail'],
                'price' => $i['price'],
                'image' => $i['image'],
                'category' => 'milk-tea'
            ];
        }, $this->productModel->getProducts());


        // $toppings =  array_map(function ($i) {
        //     return [
        //         'id' => $i['topping_id'],
        //         'name' => $i['topping_name'],
        //         'price' => $i['price']
        //     ];
        // }, $this->toppingModel->getToppings());

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
            // 'toppings' => $toppings,
            'favorites' => $favorites,
            'cartCount' => $cartCount
        ]);
    }

    public function details($id)
    {
        // In a real application, you would fetch the product from the database
        // For now, we'll create a lookup array with all products
        $products = array_map(function ($i) {
            return [
                'id' => $i['product_id'],	
                'name' => $i['product_name'],
                'description' => $i['product_detail'],
                'price' => $i['price'],
                'image' => $i['image'],
                'category' => 'milk-tea'
            ];
        }, $this->productModel->getProducts());

        $toppings =  array_map(function ($i) {
            return [
                'id' => $i['topping_id'],
                'name' => $i['topping_name'],
                'price' => $i['price']
            ];
        }, $this->toppingModel->getToppings());

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

    public function cart()
    {
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

        $this->views('cart', [
            'title' => 'Your Cart',
            'cartItems' => $cartItems,
            'subtotal' => 19.00,
            'tax' => 1.52,
            'total' => 20.52
        ]);
    }
}
