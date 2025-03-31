<?php
namespace YourNamespace\Controllers;

class GiftCardController {
    public function index() {
        // Set page title
        $pageTitle = "Gift Cards - XING FU CHA";
        
        // Include header
        include __DIR__ . '/../views/layouts/header.php';
        
        // Include the gift card page
        include __DIR__ . '/../views/gift-card.php';
        
        // Include footer
        include __DIR__ . '/../views/layouts/footer.php';
    }
    
    public function details($id) {
        // Set page title
        $pageTitle = "Gift Card Details - XING FU CHA";
        
        // Get gift card details based on ID
        $giftCard = $this->getGiftCardById($id);
        
        // Include header
        include __DIR__ . '/../views/partials/header.php';
        
        // Include the gift card details page
        include __DIR__ . '/../views/gift-card-details.php';
        
        // Include footer
        include __DIR__ . '/../views/partials/footer.php';
    }
    
    private function getGiftCardById($id) {
        // This would typically fetch from a database
        $giftCards = [
            '1' => [
                'id' => 1,
                'name' => 'Classic Gift Card',
                'description' => 'Perfect for any occasion',
                'image' => '/assets/image/giftcard.jpg',
                'options' => [
                    ['value' => '0.20', 'label' => '20%'],
                    ['value' => '0.30', 'label' => '30%'],
                    ['value' => '0.40', 'label' => '40%']
                ]
            ],
            '2' => [
                'id' => 2,
                'name' => 'Member Gift Card',
                'description' => 'Celebrate with bubble tea',
                'image' => '/assets/image/2membership.jpg',
                'options' => [
                    ['value' => '0.15', 'label' => '15%'],
                    ['value' => '0.25', 'label' => '25%'],
                    ['value' => '0.35', 'label' => '35%']
                ]
            ],
            '3' => [
                'id' => 3,
                'name' => 'Holiday Gift Card',
                'description' => 'Seasonal special design',
                'image' => '/assets/image/holyday.jpg',
                'options' => [
                    ['value' => '0.25', 'label' => '25%'],
                    ['value' => '0.50', 'label' => '50%'],
                    ['value' => '0.70', 'label' => '70%']
                ]
            ]
        ];
        
        return isset($giftCards[$id]) ? $giftCards[$id] : null;
    }
}

