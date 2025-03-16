<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - XING FU CHA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>

<body>
    <?php include 'views/partials/header.php'; ?>

    <main>
        <?php include 'views/partials/sidebar.php'; ?>

        <section class="content">
            <div class="profile-container">
                <div class="profile-header">
                    <h2>My Profile</h2>
                    <p>Manage your account information and preferences</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <?php if(isset($success) || isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo isset($success) ? $success : 'Profile updated successfully'; ?></span>
                    </div>
                <?php endif; ?>

                <div class="profile-content">
                    <div class="profile-sidebar">
                        <div class="profile-image-container">
                            <img src="<?php echo $user['avatar']; ?>" alt="Profile Image" class="profile-image">
                            <div class="profile-image-overlay">
                                <i class="fas fa-camera"></i>
                                <span>Change Photo</span>
                            </div>
                        </div>
                        <h3><?php echo $user['name']; ?></h3>
                        <p><?php echo $user['email']; ?></p>
                        <div class="profile-stats">
                            <div class="stat">
                                <span class="stat-value"><?php echo count($orders); ?></span>
                                <span class="stat-label">Orders</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">0</span>
                                <span class="stat-label">Favorites</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">0</span>
                                <span class="stat-label">Reviews</span>
                            </div>
                        </div>
                        <div class="profile-actions">
                            <a href="/orders" class="profile-action-btn">
                                <i class="fas fa-shopping-bag"></i>
                                <span>My Orders</span>
                            </a>
                            <a href="/favorites" class="profile-action-btn">
                                <i class="fas fa-heart"></i>
                                <span>Favorites</span>
                            </a>
                            <a href="/settings" class="profile-action-btn">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                    <div class="profile-main">
                        <div class="profile-tabs">
                            <button class="profile-tab active" data-tab="account">Account Info</button>
                            <button class="profile-tab" data-tab="password">Password</button>
                            <button class="profile-tab" data-tab="preferences">Preferences</button>
                            <button class="profile-tab" data-tab="payment">Payment Methods</button>
                        </div>
                        
                        <div class="profile-tab-content active" id="account-tab">
                            <form action="/update-profile" method="post" class="profile-form">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="">
                                </div>
                                
                                <div class="form-group">
                                    <label for="birthday">Birthday</label>
                                    <input type="date" id="birthday" name="birthday" value="">
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="profile-tab-content" id="password-tab">
                            <form action="/update-password" method="post" class="profile-form">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" id="new_password" name="new_password" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="profile-tab-content" id="preferences-tab">
                            <form action="/update-preferences" method="post" class="profile-form">
                                <div class="form-group">
                                    <label>Email Notifications</label>
                                    <div class="checkbox-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="notify_orders" checked>
                                            <span>Order Updates</span>
                                        </label>
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="notify_promotions" checked>
                                            <span>Promotions and Discounts</span>
                                        </label>
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="notify_news">
                                            <span>News and Updates</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select id="language" name="language">
                                        <option value="en" selected>English</option>
                                        <option value="zh">中文</option>
                                        <option value="es">Español</option>
                                        <option value="fr">Français</option>
                                        <option value="ja">日本語</option>
                                    </select>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn-primary">Save Preferences</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="profile-tab-content" id="payment-tab">
                            <div class="payment-methods">
                                <div class="payment-method-empty">
                                    <i class="fas fa-credit-card"></i>
                                    <p>You don't have any payment methods saved yet.</p>
                                    <button class="btn-primary add-payment-btn">
                                        <i class="fas fa-plus"></i> Add Payment Method
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="/assets/js/profile.js"></script> 
    <?php include 'views/partials/footer.php'; ?>
          



