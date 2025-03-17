<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>
  <section class="content">
            <!-- Banner Section -->
            <div class="banner">
                <h2>Special Offer!</h2>
                <p>Get 20% off on all drinks today. Don't miss out on this amazing deal!</p>
                <button class="cta-button">Order Now</button>
            </div>

            <!-- Booking Container -->
            <div class="booking-container">
                <!-- Booking Filters -->
                <div class="booking-filters">
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-status="all">All Orders</button>
                        <button class="filter-tab" data-status="processing">Processing</button>
                        <button class="filter-tab" data-status="completed">Completed</button>
                        <button class="filter-tab" data-status="cancelled">Cancelled</button>
                    </div>
                    <div class="search-filter">
                        <input type="text" id="bookingSearch" placeholder="Search by order number...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>

                <!-- Bookings List -->
                <div class="bookings-list">
                    <!-- Example Booking Card -->
                    <div class="booking-card" data-status="completed">
                        <div class="booking-header">
                            <div class="booking-info">
                                <h3>Order #ORD-001</h3>
                                <p class="booking-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    May 15, 2023 at 14:30
                                </p>
                            </div>
                            <div class="booking-status completed">
                                Completed
                            </div>
                        </div>
                        <div class="booking-items">
                            <div class="booking-item">
                                <div class="item-details">
                                    <h4>Classic Milk Tea</h4>
                                    <p>Size: Medium | Sugar: 50% | Ice: Regular</p>
                                    <p>Toppings: Boba Pearls</p>
                                </div>
                                <div class="item-price">
                                    $5.00
                                </div>
                            </div>
                        </div>
                        <div class="booking-footer">
                            <div class="booking-total">
                                <span>Total:</span>
                                <span class="total-price">$5.00</span>
                            </div>
                            <div class="booking-actions">
                                <a href="#" class="btn-secondary">
                                    <i class="fas fa-eye"></i>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<script src="/assets/js/booking.js"></script>