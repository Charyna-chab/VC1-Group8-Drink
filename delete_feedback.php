<?php
session_start();
require_once './delete_feedback.php'; // Adjusted to point to the correct location of config.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Invalid CSRF token.');
        }

        // Validate and sanitize feedback ID
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            throw new Exception('Invalid feedback ID.');
        }
        $feedbackId = intval($_POST['id']);

        // Prepare and execute the delete query
        $stmt = $pdo->prepare('DELETE FROM feedback WHERE id = :id');
        $stmt->execute(['id' => $feedbackId]);

        // Redirect with success message
        header('Location: views/feedback/feedback_view.php?deleted=true');
        exit;
    } catch (Exception $e) {
        // Handle errors and redirect with an error message
        header('Location: views/feedback/feedback_view.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
?>
