<?php

namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class CheckoutController extends BaseController
{
    public function index()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Get cart items from localStorage via JavaScript
        // This will be populated in the view

        // Pass data to the view
        $this->views('checkout', [
            'title' => 'Checkout'
        ]);
    }

    public function processPayment()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/checkout?error=invalid_method');
            return;
        }

        // Get payment data
        $paymentMethod = $_POST['payment_method'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $transactionId = $_POST['transaction_id'] ?? '';

        // Validate required fields
        if (empty($paymentMethod) || empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($address)) {
            $this->redirect('/checkout?error=missing_fields');
            return;
        }

        // Process payment based on method
        $success = false;
        switch ($paymentMethod) {
            case 'card':
                $success = $this->processCardPayment();
                break;
            case 'aba':
                $success = $this->processAbaPayment($transactionId);
                break;
            case 'acleda':
                $success = $this->processAcledaPayment($transactionId);
                break;
            case 'cash':
                $success = $this->processCashPayment();
                break;
            default:
                $this->redirect('/checkout?error=invalid_payment_method');
                return;
        }

        if ($success) {
            // Generate order number
            $orderNumber = 'ORD' . date('YmdHis') . rand(100, 999);

            // Store order details in session for receipt
            $_SESSION['order'] = [
                'id' => $orderNumber,
                'date' => date('Y-m-d H:i:s'),
                'payment_method' => $paymentMethod,
                'transaction_id' => $transactionId,
                'customer' => [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'notes' => $notes
                ],
                'status' => 'completed'
            ];

            // Clear cart (will be done via JavaScript)
            
            // Redirect to success page
            $this->redirect('/checkout/success?order=' . $orderNumber);
        } else {
            $this->redirect('/checkout?error=payment_failed');
        }
    }

    public function success()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Get order number from URL
        $orderNumber = $_GET['order'] ?? '';

        // Check if order exists in session
        if (empty($orderNumber) || !isset($_SESSION['order']) || $_SESSION['order']['id'] !== $orderNumber) {
            $this->redirect('/order');
            return;
        }

        // Pass data to the view
        $this->views('checkout-success', [
            'title' => 'Order Successful',
            'order' => $_SESSION['order']
        ]);
    }

    private function processCardPayment()
    {
        // In a real application, you would integrate with a payment gateway
        // For now, we'll just simulate a successful payment
        return true;
    }

    private function processAbaPayment($transactionId)
    {
        // Validate transaction ID
        if (empty($transactionId)) {
            return false;
        }

        // In a real application, you would verify the transaction with ABA
        // For now, we'll just check if the transaction ID is provided
        return !empty($transactionId);
    }

    private function processAcledaPayment($transactionId)
    {
        // Validate transaction ID
        if (empty($transactionId)) {
            return false;
        }

        // In a real application, you would verify the transaction with ACLEDA
        // For now, we'll just check if the transaction ID is provided
        return !empty($transactionId);
    }

    private function processCashPayment()
    {
        // Cash on delivery is always successful
        return true;
    }
}
