<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>

<div class="section-praents">
<section class="gift-card-options">
    <div class="container">
        <div class="section-header">
            <h2>Choose Your Gift Card</h2>
            <p>Perfect for birthdays, holidays, or just to say thank you</p>
        </div>
        
        <div class="gift-card-grid">
            <?php
            $giftCards = [
                [
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
                [
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
                [
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
            
            foreach ($giftCards as $card): ?>
                <div class="gift-card-item" data-id="<?php echo $card['id']; ?>">
                    <div class="gift-card-image">
                        <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>">
                        <div class="card-overlay">
                            <a href="/gift-card/details/<?php echo $card['id']; ?>" class="view-details-btn">View Details</a>
                        </div>
                    </div>
                    <div class="gift-card-content">
                        <h3><?php echo $card['name']; ?></h3>
                        <p class="card-description"><?php echo $card['description']; ?></p>
                        <div class="price-options">
                            <?php foreach ($card['options'] as $index => $option): ?>
                                <button class="price-option <?php echo $index === 0 ? 'active' : ''; ?>" data-value="<?php echo $option['value']; ?>"><?php echo $option['label']; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <button class="add-to-cart-btn" data-id="<?php echo $card['id']; ?>">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2>How It Works</h2>
            <p>Sending a gift card is quick and easy</p>
        </div>
        
        <div class="steps-container">
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3>1. Choose a Card</h3>
                <p>Select from our beautiful gift card designs</p>
            </div>
            
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <h3>2. Select Discount</h3>
                <p>Choose the perfect discount amount</p>
            </div>
            
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>3. Personalize</h3>
                <p>Add a custom message for the recipient</p>
            </div>
            
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h3>4. Send or Print</h3>
                <p>Email directly or print at home</p>
            </div>
        </div>
    </div>
</section>

<section class="gift-card-info">
    <div class="container">
        <div class="section-header">
            <h2>Gift Card Information</h2>
            <p>Everything you need to know about our gift cards</p>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <i class="fas fa-credit-card"></i>
                <h3>No Expiration</h3>
                <p>Our gift cards never expire, so your gift can be enjoyed anytime.</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-store"></i>
                <h3>Use at Any Location</h3>
                <p>Gift cards can be redeemed at any XING FU CHA location.</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <h3>Digital Delivery</h3>
                <p>Send directly to the recipient's email for immediate gifting.</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-gift"></i>
                <h3>Personalize Your Gift</h3>
                <p>Add a custom message to make your gift more special.</p>
            </div>
        </div>
    </div>
</section>

<section class="gift-card-faq">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our gift cards</p>
        </div>
        
        <div class="faq-accordion">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I redeem a gift card?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>You can redeem your gift card at any XING FU CHA location by presenting the physical card or digital code at checkout. The amount will be deducted from your total purchase.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I check my gift card balance?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, you can check your gift card balance at any XING FU CHA location or online by entering your gift card number and PIN.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I reload my gift card?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, you can reload your gift card at any XING FU CHA location or online through our website.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What if my gift card is lost or stolen?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>If your gift card is registered, we can help you recover the balance. Please contact our customer service team with your gift card details.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I use my gift card for online orders?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, you can use your gift card for online orders by entering the gift card number and PIN during checkout.</p>
                </div>
            </div>
        </div>
    </div>
</section>


</div>


<?php $pageScript = '/assets/js/gift-card.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

