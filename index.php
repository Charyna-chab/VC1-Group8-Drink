<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Include the controller file
require_once __DIR__ . '/controllers/LocationsController.php';

// Main entry point - only require the router
require_once __DIR__ . '/router/route.php';
