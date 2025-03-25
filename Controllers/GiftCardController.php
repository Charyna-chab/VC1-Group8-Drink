<?php
namespace GiftCardController\Controllers;

class GiftCardController {
    public function index() {
        // Render the gift card page
        include __DIR__ . '/../gift-card.php';
    }
}

