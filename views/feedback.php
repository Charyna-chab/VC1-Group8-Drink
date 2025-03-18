<?php require_once __DIR__ . '/../views/layouts/header.php'; ?>
<?php require_once __DIR__ . '/../views/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="feedback-container">
        <div class="feedback-tabs">
        <button class="feedback-tab active" data-tab="review">Write a Review</button>
        <button class="feedback-tab" data-tab="suggestion">Suggestion Box</button>
        <button class="feedback-tab" data-tab="report">Report an Issue</button>
    </div>

            <div class="feedback-content active" id="review-tab">
                <!-- Review Form Content -->
                <div class="feedback-form">
                            <h3>Share Your Experience</h3>
                            <p>Let us know how we're doing! Your review helps us improve our service.</p>

                            <form id="reviewForm">
                                <div class="form-group">
                                    <label>What would you like to review?</label>
                                    <select name="review_type" required>
                                        <option value="">Select an option</option>
                                        <option value="product">A Product</option>
                                        <option value="service">Customer Service</option>
                                        <option value="app">Mobile App/Website</option>
                                        <option value="store">Store Experience</option>
                                    </select>
                                </div>

                                <div class="form-group product-select" style="display: none;">
                                    <label>Select Product</label>
                                    <select name="product_id">
                                        <option value="">Select a product</option>
                                        <?php 
                                        $products = $db->getAllProducts();
                                        foreach($products as $product): 
                                        ?>
                                            <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Your Rating</label>
                                    <div class="rating-stars">
                                        <i class="far fa-star" data-rating="1"></i>
                                        <i class="far fa-star" data-rating="2"></i>
                                        <i class="far fa-star" data-rating="3"></i>
                                        <i class="far fa-star" data-rating="4"></i>
                                        <i class="far fa-star" data-rating="5"></i>
                                    </div>
                                    <input type="hidden" name="rating" value="0" required>
                                </div>

                                <div class="form-group">
                                    <label for="review_title">Title</label>
                                    <input type="text" id="review_title" name="review_title" placeholder="Summarize your experience" required>
                                </div>

                                <div class="form-group">
                                    <label for="review_content">Your Review</label>
                                    <textarea id="review_content" name="review_content" rows="5" placeholder="Tell us what you liked or didn't like" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Add Photos (Optional)</label>
                                    <div class="photo-upload">
                                        <input type="file" id="review_photos" name="review_photos[]" multiple accept="image/*">
                                        <label for="review_photos" class="upload-btn">
                                            <i class="fas fa-camera"></i>
                                            <span>Upload Photos</span>
                                        </label>
                                        <div class="photo-preview"></div>
                                    </div>
                                </div>

                                <button type="submit" class="btn-primary">Submit Review</button>
                            </form>
                        </div>
            </div>

            <div class="feedback-content" id="suggestion-tab">
                <!-- Suggestion Form Content -->
                <div class="feedback-form">
                            <h3>Suggestion Box</h3>
                            <p>Have an idea to make our service better? We'd love to hear it!</p>

                            <form id="suggestionForm">
                                <div class="form-group">
                                    <label>Suggestion Type</label>
                                    <select name="suggestion_type" required>
                                        <option value="">Select an option</option>
                                        <option value="menu">Menu Suggestion</option>
                                        <option value="service">Service Improvement</option>
                                        <option value="store">Store Ambiance</option>
                                        <option value="app">App/Website Feature</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="suggestion_title">Title</label>
                                    <input type="text" id="suggestion_title" name="suggestion_title" placeholder="Give your suggestion a title" required>
                                </div>

                                <div class="form-group">
                                    <label for="suggestion_content">Your Suggestion</label>
                                    <textarea id="suggestion_content" name="suggestion_content" rows="5" placeholder="Describe your suggestion in detail" required></textarea>
                                </div>

                                <button type="submit" class="btn-primary">Submit Suggestion</button>
                            </form>
                        </div>
            </div>

            <div class="feedback-content" id="report-tab">
                <!-- Report Form Content -->
                <div class="feedback-form">
                            <h3>Report an Issue</h3>
                            <p>Encountered a problem? Let us know so we can fix it!</p>

                            <form id="reportForm">
                                <div class="form-group">
                                    <label>Issue Type</label>
                                    <select name="issue_type" required>
                                        <option value="">Select an option</option>
                                        <option value="order">Order Problem</option>
                                        <option value="product">Product Quality</option>
                                        <option value="service">Customer Service</option>
                                        <option value="app">App/Website Issue</option>
                                        <option value="store">Store Experience</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="form-group order-select" style="display: none;">
                                    <label>Select Order</label>
                                    <select name="order_id">
                                        <option value="">Select an order</option>
                                        <?php 
                                        if(isset($_SESSION['user'])) {
                                            $orders = $db->getOrdersByUserId($_SESSION['user']['id']);
                                            foreach($orders as $order): 
                                                $product = $db->getProductById($order['product_id']);
                                        ?>
                                            <option value="<?php echo $order['id']; ?>">
                                                Order #<?php echo $order['id']; ?> - <?php echo $product['name']; ?>
                                            </option>
                                        <?php 
                                            endforeach; 
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="issue_title">Title</label>
                                    <input type="text" id="issue_title" name="issue_title" placeholder="Summarize the issue" required>
                                </div>

                                <div class="form-group">
                                    <label for="issue_content">Issue Description</label>
                                    <textarea id="issue_content" name="issue_content" rows="5" placeholder="Describe the issue in detail" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Add Photos (Optional)</label>
                                    <div class="photo-upload">
                                        <input type="file" id="issue_photos" name="issue_photos[]" multiple accept="image/*">
                                        <label for="issue_photos" class="upload-btn">
                                            <i class="fas fa-camera"></i>
                                            <span>Upload Photos</span>
                                        </label>
                                        <div class="photo-preview"></div>
                                    </div>
                                </div>

                                <button type="submit" class="btn-primary">Submit Report</button>
                            </form>
                        </div>
                    </div>
            </div>
        <!-- Report Tab -->
</section>

<?php require_once __DIR__ . '/../views/layouts/footer.php'; ?>