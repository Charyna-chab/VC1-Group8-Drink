<?php

class FavoritesController extends BaseController {
    public function index() {
        // For demo purposes, we'll show some sample favorites
        // In a real app, this would come from the database
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
}