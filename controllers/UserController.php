<?php
class UserController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
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
        
        // Get user data
        $user = $this->db->getUserById($_SESSION['user_id']);
        
        if (!$user) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'User not found']);
            return;
        }
        
        // Get user orders as notifications
        $orders = $this->db->getOrdersByUserId($_SESSION['user_id']);
        
        // Format orders as notifications
        $notifications = [];
        foreach ($orders as $order) {
            $notifications[] = [
                'id' => $order['id'],
                'title' => 'Order: ' . $order['product_name'],
                'message' => $order['size'] . ', ' . $order['sugar_level'] . 
                             (count($order['toppings']) > 0 ? ' with ' . implode(', ', $order['toppings']) : '') . 
                             ' - $' . number_format($order['total_price'], 2),
                'image' => $order['product_image'],
                'time' => date('h:i A', strtotime($order['created_at'])),
                'date' => date('M d, Y', strtotime($order['created_at'])),
                'status' => $order['status']
            ];
        }
        
        // Return notifications as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'notifications' => $notifications
        ]);
    }
}
?>

