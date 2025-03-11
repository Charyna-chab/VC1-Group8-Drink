<?php

class HomeController {
  private $db;
  
  public function __construct() {
      $this->db = Database::getInstance();
  }
  
  public function index() {
      $categories = $this->db->getAllCategories();
      $featuredProducts = $this->db->getFeaturedProducts();
      
      require 'views/home.php';
  }
  
  public function favorites() {
      // Check if user is logged in
      if (!isset($_SESSION['user'])) {
          header('Location: /login');
          exit;
      }
      
      // In a real app, you would fetch the user's favorites from the database
      // For demo purposes, we'll just show the favorites page
      
      require 'views/favorites.php';
  }
  
  public function feedback() {
      // Make database available to the view
      $db = $this->db;
      
      require 'views/feedback.php';
  }
  
  public function settings() {
      // Check if user is logged in
      if (!isset($_SESSION['user'])) {
          header('Location: /login');
          exit;
      }
      
      require 'views/settings.php';
  }
  
  public function about() {
      require 'views/about.php';
  }
  
  public function contact() {
      require 'views/contact.php';
  }
  
  public function careers() {
      require 'views/careers.php';
  }
  
  public function franchise() {
      require 'views/franchise.php';
  }
  
  public function blog() {
      require 'views/blog.php';
  }
  
  public function faq() {
      require 'views/faq.php';
  }
}
?>

