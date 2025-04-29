<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class AdminController extends BaseController {
    public function __construct() {
        // Always start session at the beginning
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkAdminAuth();
    }
    
    private function checkAdminAuth() {
        // Check if user is logged in and is an admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            // Clear any existing session data
            $_SESSION = array();
            
            // Destroy the session cookie
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }
            
            // Destroy the session
            session_destroy();
            
            // Redirect to admin login
            $this->redirect('/admin-login');
        }
    }
    
    public function dashboard() {
        $this->redirect('/admin-dashboard');
    }
}