<?php

namespace Controllers;

class FeedbackController
{
    private $pdo;
    
    public function __construct()
    {
        // Database Connection
        $host = "localhost";  // Change if needed
        $user = "root";       // Change to your DB username
        $pass = "";           // Change to your DB password
        $dbname = "drink_db"; // Your database name

        // Create a PDO connection
        try {
            $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
        
        // Start session for CSRF token if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Generate CSRF token if not already set
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
    
    /**
     * Display a listing of feedback entries
     */
    public function index()
    {
        // Get filter parameters
        $nameFilter = isset($_GET['name']) ? $_GET['name'] : '';
        $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
        
        // Build the query
        $query = "SELECT * FROM feedback WHERE 1=1";
        $params = [];
        
        if (!empty($nameFilter)) {
            $query .= " AND customer_name LIKE ?";
            $params[] = "%$nameFilter%";
        }
        
        if (!empty($dateFilter)) {
            $query .= " AND DATE(created_at) = ?";
            $params[] = $dateFilter;
        }
        
        $query .= " ORDER BY created_at DESC";
        
        // Execute the query
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $feedbackEntries = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Check for delete success message
        $deleted = isset($_GET['deleted']) && $_GET['deleted'] === 'true';
        
        // Include the view
        include_once 'views/feedback/feedback_view.php';
    }
    
    /**
     * Show the form for creating a new feedback
     */
    public function create()
    {
        // Include the create form view
        include_once 'views/feedback/create.php';
    }
    
    /**
     * Store a newly created feedback in database
     */
    public function store()
    {
        // Validate CSRF token
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Invalid CSRF token.");
        }
        
        // Validate and sanitize input
        $customerName = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
        
        // Insert into database
        $stmt = $this->pdo->prepare("INSERT INTO feedback (customer_name, message, rating, created_at) VALUES (?, ?, ?, NOW())");
        
        if ($stmt->execute([$customerName, $message, $rating])) {
            header("Location: /feedback?created=true");
            exit();
        } else {
            echo "Error creating feedback.";
        }
    }
    
    /**
     * Show the form for editing the specified feedback
     */
    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            die("Invalid feedback ID.");
        }
        
        // Get the feedback entry
        $stmt = $this->pdo->prepare("SELECT * FROM feedback WHERE id = ?");
        $stmt->execute([$id]);
        $feedback = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$feedback) {
            die("Feedback not found.");
        }
        
        // Include the edit form view
        include_once 'views/feedback/edit.php';
    }
    
    /**
     * Update the specified feedback in database
     */
    public function update()
    {
        // Validate CSRF token
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Invalid CSRF token.");
        }
        
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            die("Invalid feedback ID.");
        }
        
        // Validate and sanitize input
        $customerName = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
        
        // Update in database
        $stmt = $this->pdo->prepare("UPDATE feedback SET customer_name = ?, message = ?, rating = ?, status = ? WHERE id = ?");
        
        if ($stmt->execute([$customerName, $message, $rating, $status, $id])) {
            header("Location: /feedback?updated=true");
            exit();
        } else {
            echo "Error updating feedback.";
        }
    }
    
    /**
     * Remove the specified feedback from database
     */
    public function destroy()
    {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Invalid CSRF token.");
        }
        
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            die("Invalid feedback ID.");
        }
        
        // Delete from database
        $stmt = $this->pdo->prepare("DELETE FROM feedback WHERE id = ?");
        
        if ($stmt->execute([$id])) {
            header("Location: /feedback?deleted=true");
            exit();
        } else {
            echo "Error deleting feedback.";
        }
    }
    
    /**
     * View a specific feedback entry
     */
    public function view()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            die("Invalid feedback ID.");
        }
        
        // Get the feedback entry
        $stmt = $this->pdo->prepare("SELECT * FROM feedback WHERE id = ?");
        $stmt->execute([$id]);
        $feedback = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$feedback) {
            die("Feedback not found.");
        }
        
        // Include the view feedback view
        include_once 'views/feedback/view_feedback.php';
    }
    
    /**
     * Show form to reply to feedback
     */
    public function reply()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            die("Invalid feedback ID.");
        }
        
        // Get the feedback entry
        $stmt = $this->pdo->prepare("SELECT * FROM feedback WHERE id = ?");
        $stmt->execute([$id]);
        $feedback = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$feedback) {
            die("Feedback not found.");
        }
        
        // Include the reply form view
        include_once 'views/feedback/reply_feedback.php';
    }
    
    /**
     * Store a reply to feedback
     */
    public function storeReply()
    {
        // Validate CSRF token
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Invalid CSRF token.");
        }
        
        $feedbackId = filter_input(INPUT_POST, 'feedback_id', FILTER_VALIDATE_INT);
        $replyMessage = filter_input(INPUT_POST, 'reply_message', FILTER_SANITIZE_STRING);
        
        if (!$feedbackId || !$replyMessage) {
            die("Invalid input data.");
        }
        
        // Update feedback status to 'Responded'
        $stmt = $this->pdo->prepare("UPDATE feedback SET status = 'Responded' WHERE id = ?");
        $stmt->execute([$feedbackId]);
        
        // Store the reply (assuming you have a feedback_replies table)
        $stmt = $this->pdo->prepare("INSERT INTO feedback_replies (feedback_id, reply_message, created_at) VALUES (?, ?, NOW())");
        
        if ($stmt->execute([$feedbackId, $replyMessage])) {
            header("Location: /feedback?replied=true");
            exit();
        } else {
            echo "Error storing reply.";
        }
    }
}

