<?php
require_once 'Models/UserModel.php';
require_once 'BaseController.php';
class UserController extends BaseController
{
    private $model;
    function __construct()
    {
        $this->model =  new UserModel();
    }
    
    public function profile() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            return;
        }
        
        // Get user data
        $user = $this->db->getUserById($_SESSION['user_id']);
        
        if (!$user) {
            // User not found
            session_destroy();
            header('Location: /login');
            return;
        }
        
        // Get user orders
        $orders = $this->db->getOrdersByUserId($_SESSION['user_id']);
        
        // Include the view
        include 'views/profile.php';
    }
    
    public function notifications() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'User not logged in']);
            return;
        }
        
        
    }
}
