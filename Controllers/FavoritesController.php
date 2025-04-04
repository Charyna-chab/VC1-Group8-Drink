<?php
namespace YourNamespace\Controllers;
use YourNamespace\BaseController;
class FavoritesController extends BaseController {
    
    // Method to determine if authentication is required
    protected function requiresAuth() {
        // Public pages like menu browsing don't require auth
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $publicActions = [];
        
        return !in_array($action, $publicActions);
    }
    
    public function index() {
        // In a real application, you would fetch favorites from the database
        // For now, we'll use localStorage via JavaScript
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
        
        // For now, we'll just update the session
        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }
        
        $productId = $data['product_id'];
        $isFavorite = isset($data['add']) ? $data['add'] : false;
        
        if ($isFavorite) {
            // Add to favorites if not already there
            if (!in_array($productId, $_SESSION['favorites'])) {
                $_SESSION['favorites'][] = $productId;
            }
        } else {
            // Remove from favorites
            $_SESSION['favorites'] = array_filter($_SESSION['favorites'], function($id) use ($productId) {
                return $id != $productId;
            });
        }
        
        echo json_encode([
            'success' => true,
            'message' => $isFavorite ? 'Added to favorites' : 'Removed from favorites',
            'is_favorite' => $isFavorite
        ]);
        exit;
    }
    
    public function add() {
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
        $requiredFields = ['id', 'name', 'image', 'price'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
                exit;
            }
        }
        
        // In a real application, you would:
        // 1. Check if the product exists
        // 2. Add to favorites in the database
        
        // For now, we'll just update the session
        if (!isset($_SESSION['favorites_data'])) {
            $_SESSION['favorites_data'] = [];
        }
        
        // Add to favorites
        $_SESSION['favorites_data'][$data['id']] = [
            'id' => $data['id'],
            'name' => $data['name'],
            'image' => $data['image'],
            'price' => $data['price'],
            'description' => isset($data['description']) ? $data['description'] : '',
        ];
        
        // Also update the simple favorites array
        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }
        
        if (!in_array($data['id'], $_SESSION['favorites'])) {
            $_SESSION['favorites'][] = $data['id'];
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Added to favorites',
            'favorites_count' => count($_SESSION['favorites'])
        ]);
        exit;
    }
    
    public function remove() {
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
        if (!isset($data['id'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Missing id']);
            exit;
        }
        
        // In a real application, you would:
        // 1. Check if the product exists in favorites
        // 2. Remove from favorites in the database
        
        // For now, we'll just update the session
        if (isset($_SESSION['favorites_data'][$data['id']])) {
            unset($_SESSION['favorites_data'][$data['id']]);
        }
        
        // Also update the simple favorites array
        if (isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = array_filter($_SESSION['favorites'], function($id) use ($data) {
                return $id != $data['id'];
            });
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Removed from favorites',
            'favorites_count' => isset($_SESSION['favorites']) ? count($_SESSION['favorites']) : 0
        ]);
        exit;
    }
    
    public function getAll() {
        // In a real application, you would fetch favorites from the database
        // For now, we'll use session data
        $favorites = isset($_SESSION['favorites_data']) ? array_values($_SESSION['favorites_data']) : [];
        
        echo json_encode([
            'success' => true,
            'favorites' => $favorites
        ]);
        exit;
    }
}