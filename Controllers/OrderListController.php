<?php

namespace OrderController;

use OrderController\BaseController;

class OrderListController 
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new \OrderController\Models\ProductModel();
    }

    public function index()
    {
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

        $toppings = [/* ... your toppings array ... */];

        $favorites = isset($_SESSION['user_id']) ? ($_SESSION['favorites'] ?? []) : [];
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
        $products = [/* ... your products array ... */];
        $toppings = [/* ... your toppings array ... */];

        $product = $products[$id] ?? null;

        if (!$product) {
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid request data']);
            exit;
        }

        $requiredFields = ['product_id', 'size', 'sugar', 'ice', 'quantity'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
                exit;
            }
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $cartItemId = uniqid();

        $_SESSION['cart'][] = [
            'id' => $cartItemId,
            'product_id' => $data['product_id'],
            'size' => $data['size'],
            'sugar' => $data['sugar'],
            'ice' => $data['ice'],
            'toppings' => $data['toppings'] ?? [],
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
        $cartItems = [/* ... sample cart items ... */];

        $this->views('cart', [
            'title' => 'Your Cart',
            'cartItems' => $cartItems,
            'subtotal' => 19.00,
            'tax' => 1.52,
            'total' => 20.52
        ]);
    }
}
