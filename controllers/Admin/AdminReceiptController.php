<?php
namespace YourNamespace\Controllers\Admin;

require_once __DIR__ . '/../../controllers/BaseController.php';
require_once __DIR__ . '/../../Models/ReceiptModel.php';


use YourNamespace\BaseController;

class AdminReceiptController extends BaseController
{
    private $model;

    function __construct()
    {
        // Start the session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is an admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = "You don't have permission to access this page.";
            header('Location: /login');
            exit;
        }

        // Initialize the ReceiptModel
        $this->model = new \ReceiptModel();
        
        // Ensure the receipts table exists
        $this->model->createReceiptsTableIfNotExists();
    }

    // Index function for listing all receipts
    function index()
    {
        $receipts = $this->model->getAllReceipts();
        $this->views('admin/receipts/receipt-list', ['receipts' => $receipts, 'title' => 'Receipt Management']);
    }

    // Function to download receipt details
    function download($id = null)
    {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "Invalid receipt ID!";
            $this->redirect('/admin/receipts');
            return;
        }
        
        $receipt = $this->model->getReceipt($id);
        
        if (!$receipt) {
            $_SESSION['error'] = "Receipt not found!";
            $this->redirect('/admin/receipts');
            return;
        }
        
        $this->views('admin/receipts/receipt-download', ['receipt' => $receipt, 'title' => 'Receipt Details']);
    }
    
    // Function to delete a receipt
    function delete($id = null)
    {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "Invalid receipt ID!";
            $this->redirect('/admin/receipts');
            return;
        }
        
        // Handle POST request for deleting the receipt
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->deleteReceipt($id);
            
            if ($result) {
                $_SESSION['success'] = "Receipt deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete receipt!";
            }
            
            $this->redirect('/admin/receipts');
            return;
        }
        
        // If it's a GET request, show confirmation page
        $receipt = $this->model->getReceipt($id);
        
        if (!$receipt) {
            $_SESSION['error'] = "Receipt not found!";
            $this->redirect('/admin/receipts');
            return;
        }
        
        $this->views('admin/receipts/receipt-delete', ['receipt' => $receipt, 'title' => 'Delete Receipt']);
    }
    
    // Export receipts to CSV
    function exportCSV() 
    {
        $receipts = $this->model->getAllReceipts();
        
        // If no receipts available, show an error
        if (empty($receipts)) {
            $_SESSION['error'] = "No receipts available for export.";
            $this->redirect('/admin/receipts');
            return;
        }
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="receipts_export_' . date('Y-m-d') . '.csv"');
        
        // Open the output stream
        $output = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($output, ['Receipt ID', 'Customer', 'Order Date', 'Product', 'Amount', 'Payment Method', 'Status', 'Transaction ID']);
        
        // Add data rows
        foreach ($receipts as $receipt) {
            fputcsv($output, [
                $receipt['receipt_id'],
                $receipt['username'],
                $receipt['order_date'],
                $receipt['product_name'],
                $receipt['amount'],
                $receipt['payment_method'],
                $receipt['payment_status'],
                $receipt['transaction_id']
            ]);
        }
        
        fclose($output);
        exit;
    }
}
