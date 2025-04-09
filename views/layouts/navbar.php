<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XING FU CHA</title>
    <style>
        /* Header actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Notification icon */
        .notification-icon {
            position: relative;
            cursor: pointer;
            width: 24px;
            height: 24px;
        }

        .notification-icon svg {
            width: 100%;
            height: 100%;
            fill: white;
            transition: all 0.3s ease;
        }

        .notification-icon:hover svg {
            transform: scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: white;
            color: #ff2a2a;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        /* Profile button */
        .profile-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            cursor: pointer;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .profile-btn:hover {
            transform: scale(1.1);
        }

        /* Profile Modal */
        .profile-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .profile-card {
            background: white;
            width: 320px;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 4px solid #ff2a2a;
            box-shadow: 0 3px 10px rgba(255, 42, 42, 0.2);
        }

        .profile-name {
            font-size: 22px;
            margin: 10px 0 5px;
            color: #333;
            font-weight: 600;
        }

        .profile-email {
            color: #666;
            margin-bottom: 25px;
            font-size: 15px;
        }

        .profile-stats {
            display: flex;
            justify-content: space-around;
            margin: 25px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #ff2a2a;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: #888;
        }

        .close-btn {
            background: #ff2a2a;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .close-btn:hover {
            background: #e60000;
            transform: translateY(-2px);
        }

        /* Notification Modal */
        .notification-modal {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1001;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h4 {
            margin: 0;
            color: #333;
        }

        .mark-all-read {
            background: none;
            border: none;
            color: #ff2a2a;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .notification-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            background-color: #f9f9f9;
        }

        .notification-item.unread {
            background-color: #fff5f5;
        }

        .notification-icon-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ffecec;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-icon-container svg {
            width: 20px;
            height: 20px;
            fill: #ff2a2a;
        }

        .notification-text {
            flex: 1;
        }

        .notification-title {
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #888;
        }

        .notification-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #ff2a2a;
            margin-left: auto;
        }
    </style>
</head>

<body>
    <header>
        <a href="/welcome">
            <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo" class="logo">
        </a>
        <nav>
            <ul>
                <li><a href="/gift-card">Gift Card</a></li>
                <li><a href="/locations">Locations</a></li>
                <li><a href="/join-the-team">Join The Team</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <div class="notification-icon" onclick="toggleNotificationModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                </svg>
                <span class="notification-badge">3</span>
            </div>
            <img src="https://via.placeholder.com/150" alt="Profile" class="profile-btn" id="profileBtn">
        </div>

        <!-- Notification Modal -->
        <div class="notification-modal" id="notificationModal">
            <div class="notification-header">
                <h4>Notifications</h4>
                <button class="mark-all-read" onclick="markAllAsRead()">Mark all as read</button>
            </div>
            <div class="notification-list">
                <div class="notification-item unread">
                    <div class="notification-icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                        </svg>
                    </div>
                    <div class="notification-text">
                        <div class="notification-title">Your order #1234 is ready for pickup</div>
                        <div class="notification-time">10 minutes ago</div>
                    </div>
                    <div class="notification-dot"></div>
                </div>
                <div class="notification-item unread">
                    <div class="notification-icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                        </svg>
                    </div>
                    <div class="notification-text">
                        <div class="notification-title">New promotion: 20% off all drinks today</div>
                        <div class="notification-time">1 hour ago</div>
                    </div>
                    <div class="notification-dot"></div>
                </div>
                <div class="notification-item">
                    <div class="notification-icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                        </svg>
                    </div>
                    <div class="notification-text">
                        <div class="notification-title">Your loyalty points have been updated</div>
                        <div class="notification-time">Yesterday</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Modal -->
        <div class="profile-modal" id="profileModal">
            <div class="profile-card">
                <img src="<?php echo isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'https://via.placeholder.com/150'; ?>" class="profile-pic" id="profilePic">
                <h3 class="profile-name" id="profileName"><?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : ''; ?></h3>
                <p class="profile-email" id="profileEmail"><?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : ''; ?></p>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">15</div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">320</div>
                        <div class="stat-label">Points</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">Gold</div>
                        <div class="stat-label">Member</div>
                    </div>
                </div>

                <button class="close-btn" onclick="hideProfile()">Close</button>
            </div>
        </div>
    </header>

    <script>
        // Get elements
        const profileBtn = document.getElementById('profileBtn');
        const profileModal = document.getElementById('profileModal');
        const notificationModal = document.getElementById('notificationModal');
        const notificationIcon = document.querySelector('.notification-icon');

        // Show profile modal
        // Show profile modal
        function showProfile() {
            // Check if user is logged in (you might need to adjust this based on your actual session structure)
            const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

            if (isLoggedIn) {
                // Use PHP to output the user data directly in JavaScript
                const userData = {
                    name: '<?php echo isset($_SESSION['user']['name']) ? addslashes($_SESSION['user']['name']) : "Guest"; ?>',
                    email: '<?php echo isset($_SESSION['user']['email']) ? addslashes($_SESSION['user']['email']) : "guest@example.com"; ?>',
                    avatar: '<?php echo isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : "https://via.placeholder.com/150"; ?>'
                };

                document.getElementById('profileName').textContent = userData.name;
                document.getElementById('profileEmail').textContent = userData.email;
                document.getElementById('profilePic').src = userData.avatar;
            } else {
                // Default values for non-logged-in users
                document.getElementById('profileName').textContent = '';
                document.getElementById('profileEmail').textContent = '';
                document.getElementById('profilePic').src = 'https://via.placeholder.com/150';
            }

            // Close notification modal if open
            notificationModal.style.display = 'none';
            profileModal.style.display = 'flex';
        }

        // Hide profile modal
        function hideProfile() {
            profileModal.style.display = 'none';
        }

        // Toggle notification modal
        function toggleNotificationModal() {
            if (notificationModal.style.display === 'block') {
                notificationModal.style.display = 'none';
            } else {
                // Close profile modal if open
                profileModal.style.display = 'none';
                notificationModal.style.display = 'block';
            }
        }

        // Mark all notifications as read
        function markAllAsRead() {
            const unreadItems = document.querySelectorAll('.notification-item.unread');
            const badge = document.querySelector('.notification-badge');

            unreadItems.forEach(item => {
                item.classList.remove('unread');
                const dot = item.querySelector('.notification-dot');
                if (dot) dot.remove();
            });

            badge.textContent = '0';
        }

        // Event listeners
        profileBtn.addEventListener('click', showProfile);

        // Close when clicking outside
        window.addEventListener('click', function(e) {
            // Close profile modal
            if (e.target === profileModal) {
                hideProfile();
            }

            // Close notification modal
            if (e.target !== notificationIcon && !notificationIcon.contains(e.target) &&
                e.target !== notificationModal && !notificationModal.contains(e.target)) {
                notificationModal.style.display = 'none';
            }
        });
    </script>
</body>

</html>