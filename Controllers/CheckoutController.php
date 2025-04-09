<?php

namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class CheckoutController extends BaseController
{
    public function index()
    {
        // Get cart items from session
        $cartItems = $_SESSION['cart'] ?? [];

        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['totalPrice'];
        }

        $tax = $subtotal * 0.08; // 8% tax
        $total = $subtotal + $tax;

        // Pass data to the view
        $this->views('checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);
    }

    public function processPayment()
    {
        $paymentMethod = $_POST['payment_method'] ?? '';

        switch ($paymentMethod) {
            case 'card':
                $success = $this->processCardPayment();
                break;
            case 'qr':
                $success = $this->processQRPayment();
                break;
            case 'cash':
                $success = $this->processCashPayment();
                break;
            default:
                $success = false;
        }

        if ($success) {
            $orderNumber = 'ORD' . rand(100000, 999999);
            $_SESSION['cart'] = [];
            $this->redirect('/checkout/success?order=' . $orderNumber);
        } else {
            $this->redirect('/checkout?error=payment_failed');
        }
    }

    public function success()
    {
        $orderNumber = $_GET['order'] ?? '';
        $this->views('checkout-success', ['orderNumber' => $orderNumber]);
    }

    private function processCardPayment()
    {
        return true;
    }

    private function processQRPayment()
    {
        return true;
    }

    private function processCashPayment()
    {
        return true;
    }
}
