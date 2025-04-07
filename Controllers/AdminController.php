<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class AdminController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkAdminAuth();
    }
    
    private function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/admin-login');
        }
    }
    
    public function dashboard() {
        $this->redirect('/admin-dashboard');
    }
}