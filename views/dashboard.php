<?php require_once __DIR__ . '/../views/layouts/header.php'; ?>

<?php require_once __DIR__ . '/../views/layouts/sidebar.php'; ?>


<section class="content">
    
    <div class="dashboard-container">
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-content">
                    <h3>Orders</h3>
                    <p class="stat-value">12</p>
                    <p class="stat-label">Total Orders</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="stat-content">
                    <h3>Favorites</h3>
                    <p class="stat-value">3</p>
                    <p class="stat-label">Saved Items</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>Vouchers</h3>
                    <p class="stat-value">2</p>
                    <p class="stat-label">Available</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <h3>Rewards</h3>
                    <p class="stat-value">150</p>
                    <p class="stat-label">Points</p>
                </div>
            </div>
        </div>
        
        <div class="dashboard-sections">
            <div class="dashboard-section">
                <h3>Recent Orders</h3>
                <div class="recent-orders">
                    <div class="order-item">
                        <div class="order-image">
                            <img src="/assets/images/products/taro-milk-tea.jpg" alt="Taro Milk Tea">
                        </div>
                        <div class="order-details">
                            <h4>Taro Milk Tea</h4>
                            <p>Order #1234 • March 10, 2025</p>
                            <span class="order-status completed">Completed</span>
                        </div>
                        <div class="order-actions">
                            <button class="btn-outline-sm">Reorder</button>
                        </div>
                    </div>
                    
                    <div class="order-item">
                        <div class="order-image">
                            <img src="/assets/images/products/matcha-latte.jpg" alt="Matcha Latte">
                        </div>
                        <div class="order-details">
                            <h4>Matcha Latte</h4>
                            <p>Order #1233 • March 8, 2025</p>
                            <span class="order-status completed">Completed</span>
                        </div>
                        <div class="order-actions">
                            <button class="btn-outline-sm">Reorder</button>
                        </div>
                    </div>
                    
                    <a href="/orders" class="view-all">View All Orders <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            
            <div class="dashboard-section">
                <h3>Available Vouchers</h3>
                <div class="vouchers">
                    <div class="voucher">
                        <div class="voucher-content">
                            <h4>10% OFF</h4>
                            <p>On all milk tea drinks</p>
                            <p class="voucher-expiry">Expires: April 15, 2025</p>
                        </div>
                        <div class="voucher-action">
                            <button class="btn-outline-sm">Use Now</button>
                        </div>
                    </div>
                    
                    <div class="voucher">
                        <div class="voucher-content">
                            <h4>FREE TOPPING</h4>
                            <p>With any large drink</p>
                            <p class="voucher-expiry">Expires: March 30, 2025</p>
                        </div>
                        <div class="voucher-action">
                            <button class="btn-outline-sm">Use Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>