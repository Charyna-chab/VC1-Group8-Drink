<?php
require_once 'Models/FeedbackModel.php';
require_once './controllers/BaseController.php'; // Correct path to BaseController.php

use YourNamespace\BaseController; // Ensure the namespace matches BaseController

class FeedbackController extends BaseController {
    private $model;
    
    function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new FeedbackModel();
    }

    public function index()
    {
        // Example view rendering
        $this->views('feedback/index.php');
    }

    function create()
    {
        $this->views('products/product-create.php');
    }

}