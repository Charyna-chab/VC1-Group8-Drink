<?php
require_once './controllers/BaseController.php'; // Correct path to BaseController.php

use YourNamespace\BaseController; // Ensure the namespace matches BaseController

class DashboardController extends BaseController
{
    public function index()
    {
        // Example view rendering
        $this->views('dashboard/index.php');
    }
}
?>