<?php
// Set content type to JSON
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "admin_dashboard"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get product count
$product_count_sql = "SELECT COUNT(*) as total FROM products";
$product_count_result = $conn->query($product_count_sql);
$product_count = $product_count_result->fetch_assoc()['total'];

// Get total inventory value (sum of all product prices)
$inventory_value_sql = "SELECT SUM(price) as total_value FROM products";
$inventory_value_result = $conn->query($inventory_value_sql);
$inventory_value = $inventory_value_result->fetch_assoc()['total_value'] ?? 0;

// Get monthly earnings
$monthly_earnings_sql = "SELECT SUM(price) as monthly_earnings FROM products WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$monthly_earnings_result = $conn->query($monthly_earnings_sql);
$monthly_earnings = $monthly_earnings_result->fetch_assoc()['monthly_earnings'] ?? 0;

// Get annual earnings
$annual_earnings_sql = "SELECT SUM(price) as annual_earnings FROM products WHERE YEAR(created_at) = YEAR(CURRENT_DATE())";
$annual_earnings_result = $conn->query($annual_earnings_sql);
$annual_earnings = $annual_earnings_result->fetch_assoc()['annual_earnings'] ?? 0;

// Get pending requests (this is a placeholder - adjust based on your actual data)
$pending_requests_sql = "SELECT COUNT(*) as pending FROM products WHERE status = 'pending'";
$pending_requests_result = $conn->query($pending_requests_sql);
$pending_requests = $pending_requests_result->fetch_assoc()['pending'] ?? 0;

// Get monthly data for chart
$monthly_data = [];
for ($i = 1; $i <= 12; $i++) {
    $month_sql = "SELECT SUM(price) as month_total FROM products WHERE MONTH(created_at) = $i AND YEAR(created_at) = YEAR(CURRENT_DATE())";
    $month_result = $conn->query($month_sql);
    $month_total = $month_result->fetch_assoc()['month_total'] ?? 0;
    $monthly_data[] = $month_total;
}

// Get revenue sources for pie chart (this is a placeholder - adjust based on your actual data)
$revenue_sources = [
    'direct' => 55,
    'social' => 30,
    'referral' => 15
];

// Prepare response data
$response = [
    'product_count' => $product_count,
    'inventory_value' => $inventory_value,
    'monthly_earnings' => $monthly_earnings,
    'annual_earnings' => $annual_earnings,
    'pending_requests' => $pending_requests,
    'monthly_data' => $monthly_data,
    'revenue_sources' => $revenue_sources
];

// Return JSON response
echo json_encode($response);