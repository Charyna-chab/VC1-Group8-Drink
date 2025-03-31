<?php
namespace YourNamespace\Controllers;

class MoreController {
    public function index() {
        // Render the more menu page
        include __DIR__ . '/../views/more.php';
    }
    
    public function aboutUs() {
        // Render the about us page
        include __DIR__ . '/../views/about-us.php';
    }
    
    public function menu() {
        // Render the full menu page
        include __DIR__ . '/../views/menu.php';
    }
    
    public function rewards() {
        // Render the rewards program page
        include __DIR__ . '/../views/rewards.php';
    }
    
    public function catering() {
        // Render the catering page
        include __DIR__ . '/../views/catering.php';
    }
    
    public function franchising() {
        // Render the franchising page
        include __DIR__ . '/../views/franchising.php';
    }
    
    public function contact() {
        // Render the contact us page
        include __DIR__ . '/../views/contact.php';
    }
    
    public function faq() {
        // Render the FAQ page
        include __DIR__ . '/../views/faq.php';
    }
    
    public function blog() {
        // Render the blog page
        include __DIR__ . '/../views/blog.php';
    }
}

