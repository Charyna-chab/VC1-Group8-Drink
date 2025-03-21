<?php
namespace GiftCardController\Controllers;

class GiftCardController extends BaseController {
    public function index() {
        // Render the gift card page
        $this->render('gift-card');
    }
}