<?php
class OrderController extends BaseController {
    public function index() {
        // You might want to fetch products from the database
        // For now, we'll create sample data
        $products = [
            [
                'id' => 1,
                'name' => 'Classic Milk Tea',
                'description' => 'Our signature milk tea with premium black tea and creamy milk.',
                'price' => 4.50,
                'image' => '/assets/images/products/classic-milk-tea.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Taro Milk Tea',
                'description' => 'Creamy taro flavor blended with our premium milk tea.',
                'price' => 5.00,
                'image' => '/assets/images/products/taro-milk-tea.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Matcha Latte',
                'description' => 'Premium Japanese matcha powder with fresh milk.',
                'price' => 5.50,
                'image' => '/assets/images/products/matcha-latte.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Brown Sugar Boba Milk',
                'description' => 'Fresh milk with brown sugar syrup and chewy boba pearls.',
                'price' => 5.75,
                'image' => '/assets/images/products/brown-sugar-boba.jpg'
            ],
            [
                'id' => 5,
                'name' => 'Strawberry Fruit Tea',
                'description' => 'Refreshing fruit tea with fresh strawberry pieces.',
                'price' => 5.25,
                'image' => '/assets/images/products/strawberry-tea.jpg'
            ],
            [
                'id' => 6,
                'name' => 'Mango Smoothie',
                'description' => 'Tropical mango blended with ice for a refreshing treat.',
                'price' => 6.00,
                'image' => '/assets/images/products/mango-smoothie.jpg'
            ]
        ];
        
        $toppings = [
            ['id' => 1, 'name' => 'Boba Pearls', 'price' => 0.75],
            ['id' => 2, 'name' => 'Grass Jelly', 'price' => 0.75],
            ['id' => 3, 'name' => 'Aloe Vera', 'price' => 0.75],
            ['id' => 4, 'name' => 'Pudding', 'price' => 1.00],
            ['id' => 5, 'name' => 'Cheese Foam', 'price' => 1.50],
            ['id' => 6, 'name' => 'Fresh Fruit', 'price' => 1.25]
        ];
        
        $this->view('order', [
            'title' => 'Order Drinks',
            'products' => $products,
            'toppings' => $toppings
        ]);
    }
    
    public function details($id) {
        // In a real application, you would fetch the product from the database
        // For now, we'll create sample data
        $products = [
            1 => [
                'id' => 1,
                'name' => 'Classic Milk Tea',
                'description' => 'Our signature milk tea with premium black tea and creamy milk.',
                'price' => 4.50,
                'image' => '/assets/images/products/classic-milk-tea.jpg'
            ],
            2 => [
                'id' => 2,
                'name' => 'Taro Milk Tea',
                'description' => 'Creamy taro flavor blended with our premium milk tea.',
                'price' => 5.00,
                'image' => '/assets/images/products/taro-milk-tea.jpg'
            ],
            // Add other products as needed
        ];
        
        $toppings = [
            ['id' => 1, 'name' => 'Boba Pearls', 'price' => 0.75],
            ['id' => 2, 'name' => 'Grass Jelly', 'price' => 0.75],
            ['id' => 3, 'name' => 'Aloe Vera', 'price' => 0.75],
            ['id' => 4, 'name' => 'Pudding', 'price' => 1.00],
            ['id' => 5, 'name' => 'Cheese Foam', 'price' => 1.50],
            ['id' => 6, 'name' => 'Fresh Fruit', 'price' => 1.25]
        ];
        
        $product = isset($products[$id]) ? $products[$id] : null;
        
        if (!$product) {
            // Handle product not found
            header('Location: /order');
            exit;
        }
        
        $this->view('order_details', [
            'title' => $product['name'],
            'product' => $product,
            'toppings' => $toppings
        ]);
    }
}