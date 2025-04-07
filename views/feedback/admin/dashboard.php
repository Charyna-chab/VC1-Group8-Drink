<?php

// Database connection
require_once './Database/database.php';

// Get summary statistics
// Total Orders
$ordersSql = "SELECT COUNT(*) as total FROM orders";
$ordersResult = $conn->query($ordersSql);
$ordersData = $ordersResult->fetch_assoc();
$totalOrders = $ordersData['total'];

// Revenue
$revenueSql = "SELECT SUM(total_amount) as total FROM orders";
$revenueResult = $conn->query($revenueSql);
$revenueData = $revenueResult->fetch_assoc();
$totalRevenue = $revenueData['total'];

// Active Customers
$customersSql = "SELECT COUNT(*) as total FROM users WHERE last_login > DATE_SUB(NOW(), INTERVAL 30 DAY)";
$customersResult = $conn->query($customersSql);
$customersData = $customersResult->fetch_assoc();
$activeCustomers = $customersData['total'];

// New Feedback
$feedbackSql = "SELECT COUNT(*) as total FROM feedback WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
$feedbackResult = $conn->query($feedbackSql);
$feedbackData = $feedbackResult->fetch_assoc();
$newFeedback = $feedbackData['total'];

// Include the layout
$contentFile = 'views/admin/dashboard_view.php';
include 'layout.php';
?>

