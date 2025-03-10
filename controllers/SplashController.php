<?php

class SplashController {
    public function index() {
        // Check if user is already logged in
        if (isset($_SESSION['user'])) {
            // If logged in, redirect to home page
            header('Location: /home');
            exit;
        }
        
        // If not logged in, show splash screen
        require 'views/splash.php';
    }
}

