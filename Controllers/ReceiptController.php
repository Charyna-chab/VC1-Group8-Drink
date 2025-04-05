<?php
namespace YourNamespace\Controllers;

require_once './Controllers/BaseController.php';
require_once './Models/ReceiptModel.php';

use YourNamespace\Models\ReceiptModel;
use YourNamespace\BaseController;
class ReceiptController extends BaseController
{
    private $model;

    function __construct()
    {
        // Make sure sessions are started if you're using $_SESSION
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new ReceiptModel();
    }

    function index()
    {
        // Get user ID from session if user is logged in
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        if (!$userId) {
            $_SESSION['error'] = "You must be logged in to view receipts.";
            $this->redirect('/login');
            return;
        }
        
        $receipts = $this->model->getReceiptsByUser($userId);
        $this->views('receipts/receipt-list', ['receipts' => $receipts]);
    }

    function download($id = null)
    {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "Invalid receipt ID!";
            $this->redirect('/receipt');
            return;
        }
        
        $receipt = $this->model->getReceipt($id);
        
        if (!$receipt) {
            $_SESSION['error'] = "Receipt not found!";
            $this->redirect('/receipt');
            return;
        }
        
        // Check if the receipt belongs to the logged-in user
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if ($userId && $receipt['user_id'] != $userId && $_SESSION['role'] != 'admin') {
            $_SESSION['error'] = "You don't have permission to view this receipt!";
            $this->redirect('/receipt');
            return;
        }
        
        $this->views('receipts/receipt-download.php', ['receipt' => $receipt]);
    }
}