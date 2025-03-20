<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

      <section class="content">

          <div class="settings-container">
              <div class="settings-sidebar">
                  <ul class="settings-nav">
                      <li class="active" data-tab="account">
                          <i class="fas fa-user"></i>
                          <span>Account</span>
                      </li>
                      <li data-tab="notifications">
                          <i class="fas fa-bell"></i>
                          <span>Notifications</span>
                      </li>
                      <li data-tab="privacy">
                          <i class="fas fa-shield-alt"></i>
                          <span>Privacy</span>
                      </li>
                      <li data-tab="payment">
                          <i class="fas fa-credit-card"></i>
                          <span>Payment Methods</span>
                      </li>
                      <li data-tab="address">
                          <i class="fas fa-map-marker-alt"></i>
                          <span>Addresses</span>
                      </li>
                      <li data-tab="appearance">
                          <i class="fas fa-palette"></i>
                          <span>Appearance</span>
                      </li>
                      <li data-tab="language">
                          <i class="fas fa-language"></i>
                          <span>Language</span>
                      </li>
                  </ul>
              </div>

              <div class="settings-contents">
                  <!-- Account Settings -->
                  <div class="settings-tab active" id="account-tab">
                      <h3>Account Settings</h3>
                      <p>Manage your account information</p>

                      <form id="accountForm" class="settings-form">
                          <div class="form-group">
                              <label for="name">Full Name</label>
                              <input type="text" id="name" name="name" value="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['name'] : ''; ?>" required>
                          </div>

                          <div class="form-group">
                              <label for="email">Email Address</label>
                              <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['email'] : ''; ?>" required>
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

                      <div class="divider"></div>

                      <h3>Password</h3>
                      <p>Update your password</p>

                      <form id="passwordForm" class="settings-form">
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

                      <div class="divider"></div>

                      <h3>Danger Zone</h3>
                      <p>Permanent actions for your account</p>

                      <div class="danger-zone">
                          <button class="btn-danger" id="deleteAccountBtn">
                              <i class="fas fa-trash-alt"></i>
                              Delete Account
                          </button>
                      </div>
                  </div>

                  <!-- Notifications Settings -->
                  <div class="settings-tab" id="notifications-tab">
                      <h3>Notification Settings</h3>
                      <p>Manage how you receive notifications</p>

                      <form id="notificationsForm" class="settings-form">
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
                              <label>Push Notifications</label>
                              <div class="checkbox-group">
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="push_orders" checked>
                                      <span>Order Updates</span>
                                  </label>
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="push_promotions">
                                      <span>Promotions and Discounts</span>
                                  </label>
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="push_news">
                                      <span>News and Updates</span>
                                  </label>
                              </div>
                          </div>

                          <div class="form-actions">
                              <button type="submit" class="btn-primary">Save Preferences</button>
                          </div>
                      </form>
                  </div>

                  <!-- Privacy Settings -->
                  <div class="settings-tab" id="privacy-tab">
                      <h3>Privacy Settings</h3>
                      <p>Manage your privacy preferences</p>

                      <form id="privacyForm" class="settings-form">
                          <div class="form-group">
                              <label>Data Sharing</label>
                              <div class="checkbox-group">
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="share_analytics" checked>
                                      <span>Share anonymous usage data to improve our services</span>
                                  </label>
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="share_marketing">
                                      <span>Share data with marketing partners</span>
                                  </label>
                              </div>
                          </div>

                          <div class="form-group">
                              <label>Cookies</label>
                              <div class="checkbox-group">
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="cookies_essential" checked disabled>
                                      <span>Essential Cookies (Required)</span>
                                  </label>
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="cookies_preferences" checked>
                                      <span>Preferences Cookies</span>
                                  </label>
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="cookies_analytics" checked>
                                      <span>Analytics Cookies</span>
                                  </label>
                                  <label class="checkbox-label">
                                      <input type="checkbox" name="cookies_marketing">
                                      <span>Marketing Cookies</span>
                                  </label>
                              </div>
                          </div>

                          <div class="form-actions">
                              <button type="submit" class="btn-primary">Save Preferences</button>
                          </div>
                      </form>

                      <div class="divider"></div>

                      <h3>Data Management</h3>
                      <p>Manage your personal data</p>

                      <div class="data-management">
                          <button class="btn-outline" id="downloadDataBtn">
                              <i class="fas fa-download"></i>
                              Download My Data
                          </button>
                      </div>
                  </div>

                  <!-- Payment Methods -->
                  <div class="settings-tab" id="payment-tab">
                      <h3>Payment Methods</h3>
                      <p>Manage your payment methods</p>

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

                  <!-- Addresses -->
                  <div class="settings-tab" id="address-tab">
                      <h3>Delivery Addresses</h3>
                      <p>Manage your delivery addresses</p>

                      <div class="addresses">
                          <div class="address-empty">
                              <i class="fas fa-map-marker-alt"></i>
                              <p>You don't have any addresses saved yet.</p>
                              <button class="btn-primary add-address-btn">
                                  <i class="fas fa-plus"></i> Add Address
                              </button>
                          </div>
                      </div>
                  </div>

                  <!-- Appearance -->
                  <div class="settings-tab" id="appearance-tab">
                      <h3>Appearance Settings</h3>
                      <p>Customize the app appearance</p>

                      <form id="appearanceForm" class="settings-form">
                          <div class="form-group">
                              <label>Theme</label>
                              <div class="theme-options">
                                  <label class="theme-option">
                                      <input type="radio" name="theme" value="light" checked>
                                      <div class="theme-preview light-theme">
                                          <div class="theme-header"></div>
                                          <div class="theme-content"></div>
                                          <div class="theme-sidebar"></div>
                                      </div>
                                      <span>Light</span>
                                  </label>
                                  <label class="theme-option">
                                      <input type="radio" name="theme" value="dark">
                                      <div class="theme-preview dark-theme">
                                          <div class="theme-header"></div>
                                          <div class="theme-content"></div>
                                          <div class="theme-sidebar"></div>
                                      </div>
                                      <span>Dark</span>
                                  </label>
                                  <label class="theme-option">
                                      <input type="radio" name="theme" value="system">
                                      <div class="theme-preview system-theme">
                                          <div class="theme-header"></div>
                                          <div class="theme-content"></div>
                                          <div class="theme-sidebar"></div>
                                      </div>
                                      <span>System</span>
                                  </label>
                              </div>
                          </div>

                          <div class="form-group">
                              <label>Font Size</label>
                              <div class="range-slider">
                                  <input type="range" id="font_size" name="font_size" min="12" max="20" value="16">
                                  <div class="range-value">16px</div>
                              </div>
                          </div>

                          <div class="form-actions">
                              <button type="submit" class="btn-primary">Save Preferences</button>
                          </div>
                      </form>
                  </div>

                  <!-- Language -->
                  <div class="settings-tab" id="language-tab">
                      <h3>Language Settings</h3>
                      <p>Choose your preferred language</p>

                      <form id="languageForm" class="settings-form">
                          <div class="form-group">
                              <label for="language">Language</label>
                              <select id="language" name="language">
                                  <option value="en" selected>English</option>
                                  <option value="zh">中文 (Chinese)</option>
                                  <option value="es">Español (Spanish)</option>
                                  <option value="fr">Français (French)</option>
                                  <option value="ja">日本語 (Japanese)</option>
                              </select>
                          </div>

                          <div class="form-actions">
                              <button type="submit" class="btn-primary">Save Preferences</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </section>
  </main>

  <?php include 'views/notification_panel.php'; ?>
  <?php include 'views/toast.php'; ?>
  <?php include 'views/overlay.php'; ?>
  <script src="/assets/js/app.js"></script>
  <script src="/assets/js/settings.js"></script>
</body>

</html>

