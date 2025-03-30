<?php
// This file can be simplified since we now have a controller

// Include the controller
require_once '../Controllers/FeedbackController.php';

// Create controller instance
$controller = new Controllers\FeedbackController();

// Call the destroy method
$controller->destroy();

