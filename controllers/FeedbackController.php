<?php
class FeedbackController extends BaseController {
    public function index() {
        // You might want to add database connection here if needed for products/orders
        $db = null; // Replace with your actual database connection if needed
        
        $this->view('feedback', [
            'title' => 'Feedback',
            'db' => $db
        ]);
    }
}