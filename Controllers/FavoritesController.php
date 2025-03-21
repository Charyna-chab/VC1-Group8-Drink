<?php
class FavoritesController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    
    public function index() {
        // In a real application, you would fetch favorites from the database
        // For now, we'll use sample data or get from localStorage via JavaScript
        $favorites = [];
        
        $this->views('favorites', [
            'title' => 'My Favorites - XING FU CHA',
            'favorites' => $favorites
        ]);
    }
    
    public function toggle() {
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
        if (!isset($data['product_id'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Missing product_id']);
            exit;
        }
        
        // In a real application, you would:
        // 1. Check if the product exists
        // 2. Toggle the favorite status in the database
        
        // For now, we'll just return success
        echo json_encode([
            'success' => true,
            'message' => isset($data['add']) && $data['add'] ? 'Added to favorites' : 'Removed from favorites',
            'is_favorite' => isset($data['add']) ? $data['add'] : false
        ]);
        exit;
    }
}