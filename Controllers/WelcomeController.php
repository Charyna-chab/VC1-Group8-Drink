<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class WelcomeController extends BaseController {
    public function welcome() {
        // Check if user is logged in
        $isLoggedIn = isset($_SESSION['user_id']);
        
        // Pass data to the view
        $data = [
            'title' => 'Welcome to XING FU CHA',
            'isLoggedIn' => $isLoggedIn
        ];
        
        // If user is logged in, add user data
        if ($isLoggedIn && isset($_SESSION['user'])) {
            $data['user'] = $_SESSION['user'];
        }
        
        $this->views('welcome/welcome', $data);
    }
}

