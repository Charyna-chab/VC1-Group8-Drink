<?php

namespace GiftCardController\Controllers;

class GiftCardController {
    public function index() {
        // Render the gift card page
        $this->views('gift-card/index');
    }
}


