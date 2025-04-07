<?php

// Database connection
require_once '../includes/db_connect.php';

// Get filter parameters
$dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
$nameFilter = isset($_GET['name']) ? $_GET['name'] : '';

// Build the SQL query with filters
$sql = "SELECT f.id, f.message, f.created_at, 
        CASE WHEN f.user_id IS NULL THEN 'Guest' ELSE u.name END AS customer_name
        FROM feedback f
        LEFT JOIN users u ON f.user_id = u.id
        WHERE 1=1";

$params = [];

if (!empty($dateFilter)) {
    $sql .= " AND DATE(f.created_at) = ?";
    $params[] = $dateFilter;
}

if (!empty($nameFilter)) {
    $sql .= " AND (u.name LIKE ? OR (f.user_id IS NULL AND 'Guest' LIKE ?))";
    $params[] = "%$nameFilter%";
    $params[] = "%$nameFilter%";
}

// Order by newest first
$sql .= " ORDER BY f.created_at DESC";

// Prepare and execute the query
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$feedbackEntries = $result->fetch_all(MYSQLI_ASSOC);

// Include the layout
$contentFile = 'views/admin/feedback_view.php';
include 'layout.php';
?>

