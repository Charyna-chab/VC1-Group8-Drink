<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XING FU CHA</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

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

        .profile-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .profile-card {
            background: white;
            width: 500px;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.3s ease;
        }

        .profile-pic-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ddd;
        }

        .camera-icon {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #007bff;
            color: white;
            padding: 6px;
            border-radius: 50%;
            cursor: pointer;
        }

        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .profile-email {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .profile-actions button {
            padding: 12px 10px;
            margin: 0 10px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .cancel-btn {
            background: #ccc;
        }

        .upgrade-btn {
            background: #28a745;
            color: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Profile Picture Container */
        .profile-pic-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .profile-pic {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ff2a2a;
            box-shadow: 0 3px 10px rgba(255, 42, 42, 0.2);
        }

        /* Camera Icon */
        .camera-icon {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: #ff2a2a;
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .camera-icon:hover {
            background-color: #e60000;
            transform: scale(1.1);
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
            font-size: 12px;
            
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

        /* Profile Actions (Cancel and Upgrade buttons) */
        .profile-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .cancel-btn {
            background: #ff2a2a;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            background: #e60000;
            transform: translateY(-2px);
        }

        .upgrade-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .upgrade-btn:hover {
            background: #45a049;
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
            <span class="notification-badge" id="notificationBadge">0</span>
        </div>
        <?php
        // Get user avatar from session or use default
        $userAvatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : '/assets/image/placeholder.svg?height=40&width=40';
        ?>
        <img src="<?php echo htmlspecialchars($userAvatar); ?>" alt="Profile" class="profile-btn" id="profileBtn">
        <!-- Dynamic Login/Logout/Order Links -->

    </div>

    <!-- Notification Modal -->
    <div class="notification-modal" id="notificationModal">
        <div class="notification-header">
            <h4>Notifications</h4>
            <button class="mark-all-read" onclick="markAllAsRead()">Mark all as read</button>
        </div>
        <div class="notification-list" id="notificationList">
            <!-- Notifications will be dynamically loaded here -->
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="profile-modal" id="profileModal">
        <div class="profile-card">
            <!-- Profile picture with camera icon for changing the image -->
            <div class="profile-pic-container">
                <?php
                // Get user avatar from session or use default
                $userAvatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : '/assets/image/placeholder.svg?height=120&width=120';
                ?>
                <img src="<?php echo htmlspecialchars($userAvatar); ?>" class="profile-pic" id="profilePic">
                <label for="profileImageInput" class="camera-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 0 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                    </svg>
                </label>
                <input type="file" id="profileImageInput" accept="image/*" style="display: none;" onchange="updateProfileImage(event)">
            </div>

            <h3 class="profile-name" id="profileName"><?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Guest'; ?></h3>
            <p class="profile-email" id="profileEmail"><?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'guest@example.com'; ?></p>
            <!-- Action buttons: Cancel, Save, and Logout -->
            <div class="profile-actions">
                <button class="cancel-btn" onclick="cancelProfileChanges()">Cancel</button>
                <button class="upgrade-btn" onclick="saveProfileChanges()" id="saveBtn" style="display: none;">Save Changes</button>
            </div>
        </div>
    </div>
</header>
<script>
    // Get elements
    const profileBtn = document.getElementById('profileBtn');
    const profileModal = document.getElementById('profileModal');
    const notificationModal = document.getElementById('notificationModal');
    const notificationIcon = document.querySelector('.notification-icon');
    const notificationBadge = document.getElementById('notificationBadge');
    const notificationList = document.getElementById('notificationList');
    const orderCountElement = document.getElementById('orderCount');
    let originalProfileImage = ''; // To store the original image URL for canceling
    let newImageFile = null; // To store the new image file for uploading

    // Show profile modal
    function showProfile() {
        // Check if user is logged in (you might need to adjust this based on your actual session structure)
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

        if (isLoggedIn) {
            // Use PHP to output the user data directly in JavaScript
            const userData = {
                name: '<?php echo isset($_SESSION['user']['name']) ? addslashes($_SESSION['user']['name']) : "Guest"; ?>',
                email: '<?php echo isset($_SESSION['user']['email']) ? addslashes($_SESSION['user']['email']) : "guest@example.com"; ?>',
                avatar: '<?php echo isset($_SESSION['user']['avatar']) ? addslashes($_SESSION['user']['avatar']) : "/assets/image/placeholder.svg?height=120&width=120"; ?>'
            };

            document.getElementById('profileName').textContent = userData.name;
            document.getElementById('profileEmail').textContent = userData.email;
            document.getElementById('profilePic').src = userData.avatar;
            originalProfileImage = userData.avatar; // Store the original image
        } else {
            // Default values for non-logged-in users
            document.getElementById('profileName').textContent = 'Guest';
            document.getElementById('profileEmail').textContent = 'guest@example.com';
            document.getElementById('profilePic').src = '/assets/image/placeholder.svg?height=120&width=120';
            originalProfileImage = '/assets/image/placeholder.svg?height=120&width=120'; // Store the default image
        }

        // Reset the save button visibility
        document.getElementById('saveBtn').style.display = 'none';
        newImageFile = null; // Reset the new image file

        // Close notification modal if open
        notificationModal.style.display = 'none';
        profileModal.style.display = 'flex';
    }

    // Update profile image when a new image is selected
    function updateProfileImage(event) {
        const file = event.target.files[0];
        if (file) {
            newImageFile = file; // Store the file for later upload
            const reader = new FileReader();
            reader.onload = function(e) {
                const profilePic = document.getElementById('profilePic');
                profilePic.src = e.target.result; // Update the profile image preview
                document.getElementById('saveBtn').style.display = 'block'; // Show the Save button
            };
            reader.readAsDataURL(file);
        }
    }

    // Cancel profile changes and close the modal
    function cancelProfileChanges() {
        // Reset the image to the original
        document.getElementById('profilePic').src = originalProfileImage;
        document.getElementById('saveBtn').style.display = 'none'; // Hide the Save button
        newImageFile = null; // Reset the new image file
        profileModal.style.display = 'none'; // Close the modal
    }

    // Handle the save action
    function saveProfileChanges() {
        if (!newImageFile) {
            alert('No changes to save.');
            return;
        }

        // Create FormData object to send the file
        const formData = new FormData();
        formData.append('profile_image', newImageFile);
        
        // Show loading state
        const saveBtn = document.getElementById('saveBtn');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Saving...';
        saveBtn.disabled = true;
        
        // Send the image to the server
        fetch('/update-profile-image', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the profile images in the UI
                const newImageUrl = data.image_url;
                document.getElementById('profilePic').src = newImageUrl;
                profileBtn.src = newImageUrl;
                originalProfileImage = newImageUrl;
                
                // Show success message
                alert('Profile picture updated successfully!');
                
                // Reset the modal state
                document.getElementById('saveBtn').style.display = 'none';
                profileModal.style.display = 'none';
                newImageFile = null;
            } else {
                alert('Error updating profile picture: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating your profile picture');
        })
        .finally(() => {
            // Reset button state
            saveBtn.textContent = originalText;
            saveBtn.disabled = false;
        });
    }

    // Toggle notification modal
    function toggleNotificationModal() {
        if (notificationModal.style.display === 'block') {
            notificationModal.style.display = 'none';
        } else {
            // Close profile modal if open
            profileModal.style.display = 'none';
            notificationModal.style.display = 'block';
            
            // Load notifications
            loadNotifications();
        }
    }

    // Load notifications from bookings
    function loadNotifications() {
        // Get bookings from localStorage
        const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
        
        // Update notification list
        if (bookings.length === 0) {
            notificationList.innerHTML = `
                <div class="notification-item">
                    <div class="notification-text">
                        <div class="notification-title">No notifications yet</div>
                    </div>
                </div>
            `;
        } else {
            notificationList.innerHTML = '';
            
            bookings.forEach((booking, index) => {
                const date = new Date(booking.date);
                const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                
                const notificationItem = document.createElement('div');
                notificationItem.className = 'notification-item unread';
                
                notificationItem.innerHTML = `
                    <div class="notification-icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                        </svg>
                    </div>
                    <div class="notification-text">
                        <div class="notification-title">Order #${booking.id} is ${booking.status}</div>
                        <div class="notification-time">${formattedDate}</div>
                    </div>
                    <div class="notification-dot"></div>
                `;
                
                notificationList.appendChild(notificationItem);
            });
        }
    }

    // Mark all notifications as read
    function markAllAsRead() {
        const unreadItems = document.querySelectorAll('.notification-item.unread');
        
        unreadItems.forEach(item => {
            item.classList.remove('unread');
            const dot = item.querySelector('.notification-dot');
            if (dot) dot.remove();
        });
        
        notificationBadge.textContent = '0';
        notificationBadge.style.display = 'none';
    }

    // Update notification badge
    function updateNotificationBadge() {
        // Get bookings from localStorage
        const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
        const count = bookings.length;
        
        // Update badge
        notificationBadge.textContent = count;
        notificationBadge.style.display = count > 0 ? 'flex' : 'none';
        
        // Update order count in profile
        if (orderCountElement) {
            orderCountElement.textContent = count;
        }
    }

    // Event listeners
    profileBtn.addEventListener('click', showProfile);

    // Close when clicking outside
    window.addEventListener('click', function(e) {
        // Close profile modal
        if (e.target === profileModal) {
            cancelProfileChanges(); // Use cancelProfileChanges to reset the image
        }

        // Close notification modal
        if (e.target !== notificationIcon && !notificationIcon.contains(e.target) &&
            e.target !== notificationModal && !notificationModal.contains(e.target)) {
            notificationModal.style.display = 'none';
        }
    });

    // Update notification badge on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateNotificationBadge();
    });

    // Listen for changes in localStorage
    window.addEventListener('storage', function(e) {
        if (e.key === 'bookings') {
            updateNotificationBadge();
        }
    });

    // Initial update
    updateNotificationBadge();
</script>
</body>
</html>