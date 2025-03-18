
<?php
class OrderController extends BaseController {
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
                'name' => 'Sweet Potato Brown Sugar',
                'description' => 'A delightful espresso drink with chocolate syrup and steamed milk for a sweet and smooth taste.',
                'price' => 4.50,
                'image' => '/assets/image/products/Sweet Potato Brown Sugar.png',
                'category' => 'coffee'
            ],
            [
                'id' => 16,
                'name' => 'Black Tea Machhiato',
                'description' => 'Espresso combined with vanilla syrup and steamed milk for a sweet, comforting coffee.',
                'price' => 4.50,
                'image' => '/assets/image/products/Black Tea Machhiato.png',
                'category' => 'coffee'
            ],
            [
                'id' => 17,
                'name' => 'Earl Grey Brown Sugar Milk Tea',
                'description' => 'Hong Kong-style egg waffles, crispy on the outside and fluffy on the inside, served fresh.',
                'price' => 4.00,
                'image' => '/assets/image/products/Earl Grey Brown Sugar Milk Tea.png',
                'category' => 'snacks'
            ],
            [
                'id' => 18,
                'name' => 'Toy Machhiato',
                'description' => 'Crispy Taiwanese-style popcorn chicken, seasoned with special spices for a savory snack.',
                'price' => 5.50,
                'image' => '/assets/image/products/Toy Machhiato.png',
                'category' => 'snacks'
            ],
            [
                'id' => 19,
                'name' => 'Honey Latte',
                'description' => 'Crispy and delicious sweet potato fries, seasoned with a special blend of spices.',
                'price' => 4.00,
                'image' => '/assets/image/products/Honey Latte.png',
                'category' => 'snacks'
            ],
            [
                'id' => 20,
                'name' => 'Honey Lemon Green Tea',
                'description' => 'A soft sponge cake topped with our signature cheese foam, creating a creamy and sweet experience.',
                'price' => 4.50,
                'image' => '/assets/image/products/Honey Lemon Green Tea.png',
                'category' => 'snacks'
            ],
            [
                'id' => 21,
                'name' => 'Chocolate Milk tea',
                'description' => 'A creamy matcha milk tea with sweet red beans for a unique flavor.',
                'price' => 4.50,
                'image' => '/assets/image/products/Chocolate Milk Tea.png',
                'category' => 'milk-tea'
            ],
            [
                'id' => 22,
                'name' => 'Honey Lemon Tea',
                'description' => 'A refreshing blend of honey and lemon with green tea.',
                'price' => 3.75,
                'image' => '/assets/image/products/honey-lemon-tea.png',
                'category' => 'fruit-tea'
            ],
            [
                'id' => 23,
                'name' => 'Strawberry Banana Smoothie',
                'description' => 'A sweet and creamy smoothie made with fresh strawberries and bananas.',
                'price' => 4.25,
                'image' => '/assets/image/products/strawberry-banana-smoothie.png',
                'category' => 'smoothie'
            ],
            [
                'id' => 24,
                'name' => 'Caramel Macchiato',
                'description' => 'A rich espresso drink with caramel syrup and steamed milk.',
                'price' => 4.50,
                'image' => '/assets/image/products/caramel-macchiato.png',
                'category' => 'coffee'
            ],
            [
                'id' => 25,
                'name' => 'Cheese Garlic Bread',
                'description' => 'Warm and crispy garlic bread topped with melted cheese.',
                'price' => 3.00,
                'image' => '/assets/image/products/cheese-garlic-bread.png',
                'category' => 'snacks'
            ],
            [
                'id' => 26,
                'name' => 'Chocolate Lava Cake',
                'description' => 'A warm chocolate cake with a gooey molten center.',
                'price' => 4.75,
                'image' => '/assets/image/products/chocolate-lava-cake.png',
                'category' => 'snacks'
            ],
            [
                'id' => 27,
                'name' => 'Pineapple Coconut Smoothie',
                'description' => 'A tropical blend of pineapple and coconut for a refreshing treat.',
                'price' => 4.50,
                'image' => '/assets/image/products/pineapple-coconut-smoothie.png',
                'category' => 'smoothie'
            ],
            [
                'id' => 28,
                'name' => 'Iced Hazelnut Latte',
                'description' => 'A smooth iced latte with the rich flavor of hazelnut.',
                'price' => 4.25,
                'image' => '/assets/image/products/iced-hazelnut-latte.png',
                'category' => 'coffee'
            ],
            [
                'id' => 29,
                'name' => 'Tiramisu',
                'description' => 'A classic Italian dessert with layers of coffee-soaked ladyfingers and mascarpone cream.',
                'price' => 5.00,
                'image' => '/assets/image/products/tiramisu.png',
                'category' => 'snacks'
            ],
            [
                'id' => 30,
                'name' => 'Blueberry Cheesecake',
                'description' => 'A creamy cheesecake topped with fresh blueberry compote.',
                'price' => 5.50,
                'image' => '/assets/image/products/blueberry-cheesecake.png',
                'category' => 'snacks'
            ],
            [
                'id' => 31,
                'name' => 'Mango Sticky Rice',
                'description' => 'A traditional Thai dessert with sweet mango and sticky rice.',
                'price' => 4.75,
                'image' => '/assets/image/products/mango-sticky-rice.png',
                'category' => 'snacks'
            ],
            [
                'id' => 32,
                'name' => 'Green Tea Mochi',
                'description' => 'Soft and chewy mochi filled with sweet green tea paste.',
                'price' => 3.50,
                'image' => '/assets/image/products/green-tea-mochi.png',
                'category' => 'snacks'
            ],
            [
                'id' => 33,
                'name' => 'Coconut Macaroon',
                'description' => 'A sweet and chewy coconut macaroon with a crispy exterior.',
                'price' => 2.75,
                'image' => '/assets/image/products/coconut-macaroon.png',
                'category' => 'snacks'
            ],
            [
                'id' => 34,
                'name' => 'Pandan Waffle',
                'description' => 'A fragrant pandan-flavored waffle, crispy on the outside and soft on the inside.',
                'price' => 3.50,
                'image' => '/assets/image/products/pandan-waffle.png',
                'category' => 'snacks'
            ],
            [
                'id' => 35,
                'name' => 'Sesame Ball',
                'description' => 'A traditional Chinese dessert with a crispy sesame crust and sweet filling.',
                'price' => 2.50,
                'image' => '/assets/image/products/sesame-ball.png',
                'category' => 'snacks'
            ],
            [
                'id' => 36,
                'name' => 'Egg Tart',
                'description' => 'A flaky pastry filled with a creamy egg custard.',
                'price' => 3.00,
                'image' => '/assets/image/products/egg-tart.png',
                'category' => 'snacks'
            ],
            [
                'id' => 37,
                'name' => 'Matcha Cheesecake',
                'description' => 'A creamy cheesecake with the rich flavor of matcha green tea.',
                'price' => 5.25,
                'image' => '/assets/image/products/matcha-cheesecake.png',
                'category' => 'snacks'
            ],
            [
                'id' => 38,
                'name' => 'Churros',
                'description' => 'Crispy fried dough sticks dusted with cinnamon sugar.',
                'price' => 3.75,
                'image' => '/assets/image/products/churros.png',
                'category' => 'snacks'
            ],
            [
                'id' => 39,
                'name' => 'Red Bean Bun',
                'description' => 'A soft and fluffy bun filled with sweet red bean paste.',
                'price' => 2.50,
                'image' => '/assets/image/products/red-bean-bun.png',
                'category' => 'snacks'
            ],
            [
                'id' => 40,
                'name' => 'Almond Cookie',
                'description' => 'A crunchy almond cookie with a buttery flavor.',
                'price' => 2.00,
                'image' => '/assets/image/products/almond-cookie.png',
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
    
        // Simulate adding the item to the cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = $data;
    
        // Update notification count
        if (!isset($_SESSION['notification_count'])) {
            $_SESSION['notification_count'] = 0;
        }
        $_SESSION['notification_count'] += 1;
    
        // Get product name for the notification
        $productName = 'Unknown Product';
        $products = $this->getProducts(); // Fetch products from your data source
        foreach ($products as $product) {
            if ($product['id'] == $data['product_id']) {
                $productName = $product['name'];
                break;
            }
        }
    
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => count($_SESSION['cart']),
            'notification_count' => $_SESSION['notification_count'],
            'product_name' => $productName
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
        
        $this->views('cart', [
            'title' => 'Your Cart',
            'cartItems' => $cartItems,
            'subtotal' => 19.00,
            'tax' => 1.52,
            'total' => 20.52
        ]);
    }
}

