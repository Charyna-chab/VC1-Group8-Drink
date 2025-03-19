<?php

class WelcomeController extends BaseController {
    public function welcome() {
        // Your welcome page logic here
        $categories = $this->getCategories();
        $featuredProducts = $this->getFeaturedProducts();
        $this->views("welcome/welcome", compact('categories', 'featuredProducts'));
    }

    private function getCategories() {
        // Fetch categories from the database or define them here
        return [
            ['slug' => 'all', 'name' => 'All'],
            ['slug' => 'drinks', 'name' => 'Drinks'],
            ['slug' => 'snacks', 'name' => 'Snacks']
        ];
    }

    private function getFeaturedProducts() {
        // Fetch featured products from the database or define them here
        return [
            ['id' => 1, 'category' => 'drinks', 'name' => 'Coca Cola', 'description' => 'Refreshing soda', 'price' => 1.99, 'image' => '/assets/images/coca-cola.png', 'discount' => '10%'],
            ['id' => 2, 'category' => 'snacks', 'name' => 'Chips', 'description' => 'Crispy chips', 'price' => 2.99, 'image' => '/assets/images/chips.png', 'discount' => '']
        ];
    }
}