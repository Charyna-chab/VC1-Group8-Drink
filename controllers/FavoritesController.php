<?php

class FavoritesController extends BaseController {
    public function index() {
        // Fetch favorites from the database (replace with your logic)
        $favorites = [
            [
                'id' => 1,
                'name' => 'Taro Milk Tea',
                'description' => 'Creamy taro milk tea with chewy tapioca pearls',
                'price' => 4.50,
                'image' => '/assets/images/products/taro-milk-tea.jpg',
                'category' => 'milk-tea'
            ],
            [
                'id' => 3,
                'name' => 'Matcha Latte',
                'description' => 'Premium Japanese matcha with creamy milk',
                'price' => 5.50,
                'image' => '/assets/images/products/matcha-latte.jpg',
                'category' => 'milk-tea'
            ],
            [
                'id' => 6,
                'name' => 'Mango Smoothie',
                'description' => 'Refreshing mango smoothie with popping boba',
                'price' => 5.25,
                'image' => '/assets/images/products/mango-smoothie.jpg',
                'category' => 'smoothies'
            ]
        ];
        
        $this->views('favorites', ['favorites' => $favorites]);
    }

    public function toggle() {
        $productId = $_POST['productId'];
        $isFavorite = $_POST['isFavorite'];

        // Replace this with your database logic
        if ($isFavorite) {
            // Remove from favorites
            // Example: Favorite::where('user_id', $userId)->where('product_id', $productId)->delete();
        } else {
            // Add to favorites
            // Example: Favorite::create(['user_id' => $userId, 'product_id' => $productId]);
        }

        echo json_encode(['success' => true]);
    }
}