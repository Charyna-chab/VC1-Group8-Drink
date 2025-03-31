<?php
namespace YourNamespace\Controllers;

class MoreController {
    public function index() {
        // Set page title
        $pageTitle = "More Options - XING FU CHA";
        
        // Include header
        include __DIR__ . '/../views/partials/header.php';
        
        // Include the more page
        include __DIR__ . '/../views/more.php';
        
        // Include footer
        include __DIR__ . '/../views/partials/footer.php';
    }
    
    public function aboutUs() {
        // Set page title
        $pageTitle = "About Us - XING FU CHA";
        
        // Include header
        include __DIR__ . '/../views/partials/header.php';
        
        // Include the about us page
        include __DIR__ . '/../views/about-us.php';
        
        // Include footer
        include __DIR__ . '/../views/partials/footer.php';
    }
    
    public function contactUs() {
        // Set page title
        $pageTitle = "Contact Us - XING FU CHA";
        
        // Include header
        include __DIR__ . '/../views/layouts/header.php';
        
        // Include the contact us page
        include __DIR__ . '/../views/contact-us.php';
        
        // Include footer
        include __DIR__ . '/../views/layouts/footer.php';
    }
    
    public function faq() {
        // Set page title
        $pageTitle = "FAQ - XING FU CHA";
        
        // Include header
        include __DIR__ . '/../views/layouts/header.php';
        
        // Include the FAQ page
        include __DIR__ . '/../views/faq.php';
        
        // Include footer
        include __DIR__ . '/../views/layouts/footer.php';
    }
}

