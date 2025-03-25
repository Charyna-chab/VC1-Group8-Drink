
</main>
        
        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>XING FU CHA</h3>
                    <p>Premium bubble tea and refreshing drinks made with the finest ingredients.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/order">Order</a></li>
                        <li><a href="/booking">Booking</a></li>
                        <li><a href="/favorites">Favorites</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Bubble Street, Tea City</li>
                        <li><i class="fas fa-phone"></i> +1 (123) 456-7890</li>
                        <li><i class="fas fa-envelope"></i> info@xingfucha.com</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Opening Hours</h3>
                    <ul class="opening-hours">
                        <li>Monday - Friday: 10:00 AM - 9:00 PM</li>
                        <li>Saturday - Sunday: 11:00 AM - 10:00 PM</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 XING FU CHA. All rights reserved.</p>
            </div>
        </footer>
    </div>
    
    <!-- Cart Panel -->
    <div class="cart-panel" id="cartPanel">
        <div class="cart-header">
            <h3>Your Cart</h3>
            <button class="close-cart">&times;</button>
        </div>
        <div class="cart-items" id="cartItemsList">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div id="emptyCartMessage" class="empty-cart-message">
            <i class="fas fa-shopping-cart"></i>
            <p>Your cart is empty</p>
        </div>
        <div class="cart-footer">
            <div class="cart-totals">
                <div class="cart-total-row">
                    <span>Subtotal:</span>
                    <span id="cartSubtotal">$0.00</span>
                </div>
                <div class="cart-total-row final">
                    <span>Total:</span>
                    <span id="cartTotal">$0.00</span>
                </div>
            </div>
            <div class="cart-actions">
                <button id="checkoutBtn">Checkout</button>
                <button id="clearCartBtn">Clear Cart</button>
            </div>
        </div>
    </div>
    
    <!-- Notification Panel -->
    <div class="notification-panel" id="notificationPanel">
        <button class="close-btn">&times;</button>
        <h3>Notifications</h3>
        <div class="notification-list" id="notificationList">
            <!-- Dynamic notifications will be inserted here -->
            <div class="empty-notification">
                <i class="fas fa-bell-slash"></i>
                <p>No notifications yet</p>
            </div>
        </div>
    </div>
    
    <!-- Overlay -->
    <div id="overlay"></div>
    
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- JavaScript Files -->
    <script src="/assets/js/cart.js"></script>
    <script src="/assets/js/notification.js"></script>
    <script src="/assets/js/navbar.js"></script>

<script src="/assets/js/app.js"></script>
<script src="/assets/js/auth.js"></script>
<script src="/assets/js/splash.js"></script>
<script src="/assets/js/menu.js"></script>
<script src="/assets/js/orders.js"></script>
<script src="/assets/js/favorites.js"></script>
<script src="/assets/js/feedback.js"></script>
<script src="/assets/js/settings.js"></script>
<script src="/assets/js/booking.js"></script>
<script src="/assets/js/product.js"></script>
<script src="/assets/js/checkout.js"></script>
<script src="/assets/js/payment.js"></script>
<script src="/assets/js/cash-payment.js"></script>

</body>
</html>