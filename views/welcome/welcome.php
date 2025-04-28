<style>
  /* Main Styles for Welcome and Order Pages */
  @import url("https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Lobster&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  margin: 0;
  padding: 0;
  background: #fdf8f2;
  font-family: "Poppins", sans-serif;
  color: #333;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}


/* Layout Structure */

.main-container {
  display: flex;
  min-height: 100vh;
  justify-content: center;
}

.section-sidebar {
  width: 250px;
  min-width: 250px;
  background-color: #fff;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  z-index: 900;
}

.content {
  flex: 1;
  margin-left: 250px;
  /* Same as sidebar width */
  padding: 20px;
  padding-top: 90px;
  /* Space for fixed header */
  min-height: 100vh;
  position: relative;
  top: 70px;
}


/* Header Styles - Fixed at the top */

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 5%;
  background: #ff6769;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 70px;
  z-index: 1000;
}

header .logo-container {
  display: flex;
  align-items: center;
}

header img.logo {
  width: 50px;
  height: auto;
}

.cart-icon {
  font-size: 24px;
  color: white;
  cursor: pointer;
  transition: all 0.3s ease;
}

.cart-icon:hover {
  transform: scale(1.1);
}

nav {
  flex: 1;
  text-align: center;
}

nav ul {
  list-style: none;
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;
}

nav ul li {
  display: inline-block;
  margin: 0 10px;
}

nav ul li a {
  text-decoration: none;
  color: white;
  font-weight: 600;
  font-size: 16px;
  padding: 8px 12px;
  transition: all 0.3s;
  border-radius: 8px;
}

nav ul li a:hover {
  color: #000000;
  background-color: rgba(255, 255, 255, 0.3);
}

.search-bar {
  position: relative;
  margin-right: 15px;
}

.search-bar input {
  padding: 10px 15px;
  width: 250px;
  border-radius: 20px;
  border: none;
  outline: none;
  font-size: 14px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.order-search {
  background: #ff3b30;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 20px;
  font-weight: bold;
  transition: all 0.3s;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.order-search:hover {
  background: #e62e24;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}


/* User Profile in Header */

.user-profile {
  display: flex;
  align-items: center;
  margin-left: 15px;
  cursor: pointer;
  position: relative;
}

.user-profile img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #fff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.notification-icon {
  position: relative;
  margin-left: 15px;
  cursor: pointer;
}

.notification-icon i {
  font-size: 22px;
  color: white;
}

.notification-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #ff3b30;
  color: white;
  font-size: 10px;
  font-weight: bold;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}


/* Language Selector */

.language-selector {
  position: relative;
  margin-left: 15px;
  cursor: pointer;
}

.selected-language {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 5px 10px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.3);
  transition: all 0.3s;
}

.selected-language:hover {
  background: rgba(255, 255, 255, 0.5);
}

.selected-language img {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  object-fit: cover;
}

.selected-language span {
  font-size: 14px;
  font-weight: 600;
  color: white;
}

.selected-language i {
  color: white;
}

.language-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  width: 150px;
  background: white;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  padding: 10px;
  margin-top: 10px;
  display: none;
  z-index: 1001;
}

.language-selector:hover .language-dropdown {
  display: block;
}

.language-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px;
  border-radius: 5px;
  transition: all 0.3s;
  text-decoration: none;
  color: #333;
}

.language-option:hover {
  background: #f5f5f5;
}

.language-option img {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  object-fit: cover;
}

.language-option span {
  font-size: 14px;
}

.content-welcome {
  width: 80%;
  margin: auto;
  position: relative;
  top: 100px;
}


/* Discount Banner */

.discount-banner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: linear-gradient(135deg, #ff9a9e 0%, #ff5e62 100%);
  border-radius: 16px;
  padding: 40px 60px;
  margin: 0;
  height: 30vh;
  width: 100%;
  /* Change to 100% for responsiveness */
  position: relative;
  color: white;
  box-sizing: border-box;
}

.banner-content {
  z-index: 1;
  max-width: 600px;
}

.discount-banner img {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  object-fit: cover;
  width: 100%;
  height: 100%;
  opacity: 0.5;
  /* Slightly transparent */
}
.content-welcome{
  position: relative;
  bottom: 100px;
}
.hero-section{
  position: relative;
  bottom: 100px;
}

  

.btn-primary {
  background-color: #ff5e62;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #ff9a9e;
}

.discount-banner h2 {
  font-size: 24px;
  margin: 0 0 10px;
}

.discount-banner p {
  font-size: 16px;
  margin: 0 0 15px;
  opacity: 0.9;
}

.discount-banner button {
  background: white;
  color: #ff5e62;
  border: none;
  padding: 10px 20px;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.discount-banner button:hover {
  background: rgba(255, 255, 255, 0.9);
  transform: translateY(-2px);
}

.header-banner img {
  width: 800px;
  /* Make the image bigger */
  max-width: 500px;
  display: block;
  margin: auto;
  position: relative;
  left:100px;
  border-radius: 20px;
  transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
}

.header-banner img:hover {
  transform: scale(1.1);
  /* Zoom effect */
  filter: brightness(1.1);
  /* Make it slightly brighter */
}

.wave-text {
  font-size: 28px;
  font-weight: bold;
  color: #ff6363;
  animation: waveEffect 1.5s infinite alternate;
  margin: 10px 0;
}

@keyframes waveEffect {
  0% {
      transform: translateY(0);
  }
  100% {
      transform: translateY(-5px);
  }
}

.social-media {
  margin-top: 15px;
}

.social-icon {
  display: inline-block;
  margin-right: 10px;
  text-decoration: none;
  font-weight: bold;
  color: #ff6363;
  transition: color 0.3s ease-in-out;
}

.social-icon:hover {
  color: #ff2a2a;
}


/* Category Section */

.category-section {
  display: flex;
  /* Use flexbox for layout */
  justify-content: space-between;
  /* Space items between left and right */
  align-items: center;
  /* Vertically align items */
  margin-bottom: 30px;
  position: relative;
  top: 20px;
}

.category-list {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 0;
  /* Remove bottom margin for alignment */
  justify-content: flex-start;
  /* Align category items to the left */
}

.category-item {
  padding: 12px 20px;
  background: white;
  border: 1px solid #ddd;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 600;
  color: #666;
  cursor: pointer;
  transition: all 0.3s;
}

.category-item.active,
.category-item:hover {
  background: #ff5e62;
  color: white;
  border-color: #ff5e62;
}

.search-container {
  position: relative;
  display: flex;
  /* Make it flex for alignment */
  justify-content: start;
  /* Align search container to the right */
  width: 25%;
  /* Adjust width if necessary */
  left: 10px;
}

.search-container input {
  width: 100%;
  padding: 12px 20px 12px 45px;
  border: 1px solid #ddd;
  border-radius: 30px;
  font-size: 14px;
  transition: all 0.3s;
}

.search-container input:focus {
  outline: none;
  border-color: #ff5e62;
  box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.2);
}

.search-container i {
  position: absolute;
  left: 30px;
  top: 50%;
  transform: translateY(-50%);
  color: #999;
}


/* Popular Dishes Section */

.popular-dishes {
  margin-bottom: 30px;
}

.popular-dishes h3 {
  font-size: 20px;
  margin: 0 0 20px;
  color: #333;
}

.dishes-list {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
}

.product-card {
  background: white;
  border-radius: 16px;
  
  
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease-in-out;
  width: 30%;
  box-sizing: border-box;
  text-align: center;
  padding-bottom: 15px;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.product-image {
  position: relative;
  height: 140px;
  /* Smaller image */
  width: 140px;
  /* Fixed size for centering */
  margin: 0 auto;
  
  
  border-radius: 12px;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease-in-out;
}

.product-image:hover img {
  transform: scale(1.05);
}

.favorite-btn {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 30px;
  height: 30px;
  background: white;
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  transition: background 0.3s;
}

.favorite-btn:hover {
  background: #ff5e62;
  color: white;
}

.product-info {
  padding: 10px;
  text-align: center;
}

.product-info h4 {
  font-size: 16px;
  margin: 0 0 5px;
  color: #333;
}

.description {
  font-size: 14px;
  color: #666;
  margin: 0 auto 10px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  
  max-width: 90%;
}

.product-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 15px 15px;
}

.product-price {
  font-size: 18px;
  font-weight: 700;
  color: #ff5e62;
}

.btn-primary {
  padding: 8px 12px;
  background: #ff5e62;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s ease-in-out, transform 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-primary:hover {
  background: #e62e24;
  transform: translateY(-2px);
}

#no-product-message {
  grid-column: 1 / -1;
  text-align: center;
  padding: 30px;
  background: #f9f9f9;
  border-radius: 8px;
  color: #666;
  font-size: 16px;
}


/* Modal Styles */

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s;
}

.modal-overlay.active {
  opacity: 1;
  visibility: visible;
}

.modal-container {
  width: 90%;
  max-width: 600px;
  max-height: 90vh;
  background: white;
  border-radius: 16px;
 
  display: flex;
  flex-direction: column;
  transform: translateY(20px);
  transition: all 0.3s;
}

.modal-overlay.active .modal-container {
  transform: translateY(0);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 25px;
  border-bottom: 1px solid #eee;
}

.modal-header h3 {
  font-size: 20px;
  margin: 0;
  color: #333;
}

.close-modal {
  background: transparent;
  border: none;
  font-size: 20px;
  color: #999;
  cursor: pointer;
  transition: all 0.3s;
}

.close-modal:hover {
  color: #ff5e62;
}

.modal-body {
  padding: 25px;

}

.product-details {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.modal-product-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
}

.modal-product-info {
  flex: 1;
}

.modal-product-name {
  font-size: 18px;
  margin: 0 0 5px;
  color: #333;
}

.modal-product-description {
  font-size: 14px;
  color: #666;
  margin: 0 0 10px;
}

.modal-product-price {
  font-size: 18px;
  font-weight: 700;
  color: #ff5e62;
}

.modal-divider {
  border: none;
  height: 1px;
  background: #eee;
  margin: 20px 0;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 10px;
  color: #333;
}

.form-group .optional {
  font-size: 12px;
  font-weight: normal;
  color: #999;
}

.option-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.option-button {
  flex: 1;
  min-width: 80px;
  position: relative;
  cursor: pointer;
}

.option-button input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.option-button span {
  display: block;
  padding: 10px 15px;
  background: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 8px;
  text-align: center;
  transition: all 0.3s;
}

.option-button small {
  display: block;
  font-size: 12px;
  color: #999;
  margin-top: 5px;
}

.option-button input:checked+span {
  background: #ff5e62;
  color: white;
  border-color: #ff5e62;
}

.option-button input:checked+span+small {
  color: #ff5e62;
}

.toppings-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 10px;
}

.topping-option {
  position: relative;
  display: flex;
  align-items: center;
  padding: 10px 15px;
  background: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
}

.topping-option input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.topping-option span {
  flex: 1;
  font-size: 14px;
  padding-left: 25px;
  position: relative;
}

.topping-option span::before {
  content: '';
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 18px;
  height: 18px;
  border: 1px solid #ddd;
  border-radius: 4px;
  background: white;
}

.topping-option input:checked+span::before {
  background: #ff5e62;
  border-color: #ff5e62;
}

.topping-option input:checked+span::after {
  content: '✓';
  position: absolute;
  left: 4px;
  top: 50%;
  transform: translateY(-50%);
  color: white;
  font-size: 12px;
}

.topping-option small {
  font-size: 12px;
  color: #999;
}

textarea {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  resize: vertical;
  min-height: 80px;
  transition: all 0.3s;
}

textarea:focus {
  outline: none;
  border-color: #ff5e62;
  box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.2);
}

.quantity-control {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 20px 0;
}

.quantity-control label {
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.quantity-buttons {
  display: flex;
  align-items: center;
}

.quantity-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #f8f9fa;
  border: 1px solid #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s;
}

.quantity-btn:hover {
  background: #ff5e62;
  color: white;
  border-color: #ff5e62;
}

.quantity-buttons input {
  width: 50px;
  height: 36px;
  text-align: center;
  border: 1px solid #ddd;
  margin: 0 10px;
  font-size: 16px;
}

.total-price {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 0;
  border-top: 1px solid #eee;
  margin: 20px 0;
  font-size: 18px;
  font-weight: 600;
}

.price-value {
  color: #ff5e62;
}

.form-actions {
  display: flex;
  gap: 15px;
}

.form-actions button {
  flex: 1;
  padding: 12px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.form-actions button i {
  margin-right: 8px;
}

.btn-secondary {
  background: white;
  color: #333;
  border: 1px solid #ddd;
}

.btn-secondary:hover {
  background: #f5f5f5;
}


/* Toast Notification */

.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.toast {
  min-width: 300px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  padding: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  animation: slideIn 0.3s forwards;
}

.toast.success {
  border-left: 4px solid #43a047;
}

.toast.error {
  border-left: 4px solid #e53935;
}

.toast.info {
  border-left: 4px solid #039be5;
}

.toast-icon {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.toast.success .toast-icon {
  background: #43a047;
}

.toast.error .toast-icon {
  background: #e53935;
}

.toast.info .toast-icon {
  background: #039be5;
}

.toast-content {
  flex: 1;
}

.toast-title {
  font-size: 16px;
  font-weight: 600;
  margin: 0 0 5px;
}

.toast-message {
  font-size: 14px;
  color: #666;
  margin: 0;
}

.toast-close {
  background: transparent;
  border: none;
  color: #999;
  cursor: pointer;
  font-size: 16px;
}

@keyframes slideIn {
  from {
      transform: translateX(100%);
      opacity: 0;
  }
  to {
      transform: translateX(0);
      opacity: 1;
  }
}

@keyframes slideOut {
  from {
      transform: translateX(0);
      opacity: 1;
  }
  to {
      transform: translateX(100%);
      opacity: 0;
  }
}


/* Responsive Styles */

@media (max-width: 768px) {
  /* Mobile Navigation */
  header {
      padding: 10px 15px;
  }
  
  .mobile-menu-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      font-size: 24px;
      color: white;
      cursor: pointer;
      z-index: 1001;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
  }
  
  .mobile-menu-icon i {
      font-size: 20px;
  }
  
  nav {
      position: fixed;
      top: 70px;
      left: -100%;
      width: 100%;
      background: #ff6769;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px 0;
      z-index: 999;
  }
  
  nav.show {
      left: 0;
  }
  
  nav ul {
      flex-direction: column;
      gap: 15px;
  }
  
  nav ul li {
      margin: 0;
      width: 100%;
      text-align: center;
  }
  
  nav ul li a {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 12px;
  }
  
  nav ul li a i {
      margin-right: 10px;
      font-size: 18px;
  }
  
  .auth-buttons {
      position: fixed;
      top: 70px;
      right: -100%;
      background: #ff6769;
      padding: 20px;
      width: 100%;
      display: flex;
      justify-content: center;
      gap: 15px;
      transition: all 0.3s ease;
      z-index: 999;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }
  
  .auth-buttons.show {
      right: 0;
  }
  
  /* Mobile Sidebar */
  .mobile-sidebar {
      display: block;
      position: fixed;
      top: 0;
      left: -100%;
      width: 80%;
      height: 100vh;
      background: white;
      z-index: 1002;
      padding: 20px;
      transition: all 0.3s ease;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
  }
  
  .mobile-sidebar.show {
      left: 0;
  }
  
  .mobile-sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
  }
  
  .mobile-sidebar ul li {
      margin-bottom: 15px;
  }
  
  .mobile-sidebar ul li a {
      display: flex;
      align-items: center;
      padding: 10px;
      color: #333;
      text-decoration: none;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s;
  }
  
  .mobile-sidebar ul li a i {
      margin-right: 10px;
      font-size: 18px;
      color: #ff5e62;
  }
  
  .mobile-sidebar ul li a:hover {
      background: #ff5e62;
      color: white;
  }
  
  .mobile-sidebar ul li a:hover i {
      color: white;
  }
  
  /* Hero Section Responsive */
  .hero-section {
      flex-direction: column;
      text-align: center;
  }
  
  .header-banner {
      order: -1; /* Move image to top */
      margin-bottom: 20px;
  }
  
  .header-banner img {
      width: 100%;
      max-width: 100%;
      left: 0;
  }
  
  .hero-content {
      padding: 0 15px;
  }
  
  .content-welcome {
      width: 95%;
      top: 70px;
  }
  
  /* Category Section Responsive */
  .category-section {
      flex-direction: column;
      align-items: flex-start;
      gap: 15px;
  }
  
  .category-list {
      width: 100%;
      overflow-x: auto;
      padding-bottom: 10px;
      flex-wrap: nowrap;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none; /* Firefox */
  }
  
  .category-list::-webkit-scrollbar {
      display: none; /* Chrome, Safari, Edge */
  }
  
  .category-item {
      white-space: nowrap;
      display: flex;
      align-items: center;
  }
  
  .category-item i {
      margin-right: 5px;
  }
  
  .search-container {
      width: 100%;
      left: 0;
  }
  
  /* Product Cards Responsive */
  .product-card {
      width: 100%;
  }
  
  .product-details {
      flex-direction: column;
  }
  
  .modal-product-image {
      width: 100%;
      height: 150px;
  }
  
  .option-buttons {
      flex-direction: column;
  }
  
  .option-button {
      width: 100%;
  }
  
  .toppings-grid {
      grid-template-columns: 1fr;
  }
  
  .form-actions {
      flex-direction: column;
  }
  
  .dishes-list {
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
}

@media (min-width: 769px) and (max-width: 1024px) {
  /* Tablet Layout */
  .hero-section {
      flex-direction: column;
      text-align: center;
  }
  
  .header-banner {
      order: -1; /* Move image to top */
      margin-bottom: 30px;
  }
  
  .header-banner img {
      width: 80%;
      max-width: 500px;
      left: 0;
      margin: 0 auto;
  }
  
  .hero-content {
      padding: 0 20px;
  }
  
  .product-card {
      width: 48%;
  }
}

@media (max-width: 480px) {
  /* iPhone/Small Mobile Layout */
  header {
      height: 60px;
  }
  
  header img.logo {
      width: 40px;
  }
  
  .mobile-menu-icon {
      width: 36px;
      height: 36px;
  }
  
  .wave-text {
      font-size: 22px;
  }
  
  .hero-content h1 {
      font-size: 24px;
      margin-bottom: 10px;
  }
  
  .hero-content p {
      font-size: 14px;
      line-height: 1.4;
  }
  
  .hero-buttons {
      flex-direction: column;
      gap: 10px;
      width: 100%;
  }
  
  .btn-primary, .btn-outline {
      width: 100%;
      justify-content: center;
  }
  
  .category-item {
      padding: 8px 15px;
      font-size: 12px;
  }
  
  .search-container input {
      padding: 10px 15px 10px 40px;
  }
  
  .search-container i {
      left: 15px;
  }
  
  .product-image {
      height: 120px;
      width: 120px;
  }
  
  .product-info h4 {
      font-size: 14px;
  }
  
  .description {
      font-size: 12px;
  }
  
  .product-price {
      font-size: 16px;
  }
  
  .btn-primary {
      padding: 8px 10px;
      font-size: 12px;
  }
  
  .modal-container {
      width: 95%;
  }
  
  .modal-header h3 {
      font-size: 18px;
  }
  
  .modal-body {
      padding: 15px;
  }
  
  .toast {
      min-width: auto;
      width: 90%;
  }
  
  /* Auth buttons responsive */
  .auth-buttons {
      flex-direction: column;
      align-items: center;
      gap: 10px;
  }
  
  .sign-in-button, .sign-out-button {
      width: 100%;
      text-align: center;
  }
}

/* Footer Styles */

.main-footer {
  background-color: #2c3e50;
  /* Dark background color */
  color: #ecf0f1;
  /* Light text color */
  padding: 40px 20px;
  font-family: 'Arial', sans-serif;
  margin-top: 200px;
}

.footer-content {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-section {
  flex: 1;
  min-width: 200px;
  margin: 10px 20px;
}

.footer-section h3 {
  font-size: 1.5rem;
  margin-bottom: 15px;
  color: #f1c40f;
  /* Accent color for headings */
}

.footer-section p {
  font-size: 0.9rem;
  line-height: 1.6;
  margin-bottom: 15px;
}

.social-links {
  display: flex;
  gap: 10px;
}

.social-links a {
  color: #ecf0f1;
  font-size: 1.2rem;
  transition: color 0.3s ease;
}

.social-links a:hover {
  color: #f1c40f;
  /* Accent color on hover */
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section ul li {
  margin-bottom: 10px;
}

.footer-section ul li a {
  color: #ecf0f1;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-section ul li a:hover {
  color: #f1c40f;
  /* Accent color on hover */
}

.contact-info li,
.opening-hours li {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  font-size: 0.9rem;
}

.contact-info i,
.opening-hours i {
  margin-right: 10px;
  color: #f1c40f;
  /* Accent color for icons */
}

.footer-bottom {
  text-align: center;
  margin-top: 20px;
  padding-top: 10px;
  border-top: 1px solid #34495e;
  /* Subtle border for separation */
  font-size: 0.8rem;
  color: #bdc3c7;
}


/* Responsive Design */

@media (max-width: 768px) {
  .footer-content {
      flex-direction: column;
      align-items: center;
      text-align: center;
  }
  .footer-section {
      margin: 10px 0;
  }
  .social-links {
      justify-content: center;
  }
}


/* Global Styles */

:root {
  --primary-color: #fe356b;
  /* Pink - brand color */
  --primary-dark: #f61d53;
  --primary-light: #f06ca6;
  --secondary-color: #6f42c1;
  /* Purple - accent color */
  --secondary-dark: #5a36a0;
  --secondary-light: #8c68d6;
  --dark-color: #343a40;
  --light-color: #f8f9fa;
  --success-color: #28a745;
  --warning-color: #ffc107;
  --danger-color: #dc3545;
  --info-color: #17a2b8;
  --border-color: #dee2e6;
  --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 10px 20px rgba(0, 0, 0, 0.15);
  --transition: all 0.3s ease;
  --border-radius: 8px;
  --border-radius-lg: 12px;
  --border-radius-sm: 4px;
  --font-family: "Poppins", sans-serif;
  --font-size-base: 1rem;
  --font-size-lg: 1.25rem;
  --font-size-sm: 0.875rem;
  --font-size-xs: 0.75rem;
  --font-weight-normal: 400;
  --font-weight-medium: 500;
  --font-weight-bold: 700;
  --line-height-base: 1.6;
  --container-width: 1200px;
  --header-height: 80px;
  --footer-height: 300px;
  --spacing-xs: 0.25rem;
  --spacing-sm: 0.5rem;
  --spacing-md: 1rem;
  --spacing-lg: 1.5rem;
  --spacing-xl: 2rem;
  --spacing-xxl: 3rem;
}

html {
  scroll-behavior: smooth;
}

.container {
  width: 100%;
  max-width: var(--container-width);
  margin: 0 auto;
  padding: 0 15px;
  position: relative;
  top: 2000px;
}

a {
  text-decoration: none;
  color: var(--primary-color);
  transition: var(--transition);
}

a:hover {
  color: var(--primary-dark);
}

button {
  cursor: pointer;
  transition: var(--transition);
  font-family: var(--font-family);
}

img {
  max-width: 100%;
  height: auto;
  display: block;
}

ul,
ol {
  list-style: none;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  margin-bottom: var(--spacing-md);
  font-weight: var(--font-weight-bold);
  line-height: 1.3;
}

p {
  margin-bottom: var(--spacing-md);
}

.section-header {
  text-align: center;
  margin-bottom: var(--spacing-xxl);
}

.section-header h2 {
  font-size: 2.5rem;
  margin-bottom: var(--spacing-sm);
  position: relative;
  display: inline-block;
}

.section-header h2::after {
  content: "";
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 3px;
  background-color: var(--primary-color);
}

.section-header p {
  font-size: var(--font-size-lg);
  color: #6c757d;
  max-width: 700px;
  margin: 0 auto;
}


/* Buttons */

.btn {
  display: inline-block;
  padding: 12px 24px;
  border-radius: var(--border-radius);
  font-weight: var(--font-weight-medium);
  text-align: center;
  border: none;
  cursor: pointer;
  transition: var(--transition);
  font-size: var(--font-size-base);
}

.btn-primary {
  background-color: var(--primary-color);
  color: white;
}

.btn-primary:hover {
  background-color: var(--primary-dark);
  transform: translateY(-2px);
}

.btn-secondary {
  background-color: var(--secondary-color);
  color: white;
}

.btn-secondary:hover {
  background-color: var(--secondary-dark);
  transform: translateY(-2px);
}

.btn-outline {
  background-color: transparent;
  border: 2px solid var(--primary-color);
  color: var(--primary-color);
}

.btn-outline:hover {
  background-color: var(--primary-color);
  color: white;
  transform: translateY(-2px);
}

.btn-lg {
  padding: 14px 28px;
  font-size: var(--font-size-lg);
}

.btn-sm {
  padding: 8px 16px;
  font-size: var(--font-size-sm);
}

.btn-icon {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-icon i {
  font-size: 1.1em;
}


/* Forms */

.form-group {
  margin-bottom: var(--spacing-lg);
}

.form-group label {
  display: block;
  margin-bottom: var(--spacing-sm);
  font-weight: var(--font-weight-medium);
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  font-family: var(--font-family);
  font-size: var(--font-size-base);
  transition: var(--transition);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: var(--primary-color);
  outline: none;
  box-shadow: 0 0 0 3px rgba(232, 62, 140, 0.1);
}

.form-group .form-hint {
  font-size: var(--font-size-sm);
  color: #6c757d;
  margin-top: var(--spacing-xs);
}

.form-row {
  display: flex;
  flex-wrap: wrap;
  gap: var(--spacing-lg);
}

.form-row .form-group {
  flex: 1;
  min-width: 250px;
}

.form-row .form-group.full-width {
  flex-basis: 100%;
}

.required {
  color: var(--danger-color);
}


/* Checkbox and Radio Styles */

.checkbox-label,
.radio-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.checkbox-custom,
.radio-custom {
  position: relative;
  display: inline-block;
  width: 18px;
  height: 18px;
  background-color: white;
  border: 1px solid var(--border-color);
  border-radius: 3px;
  vertical-align: middle;
  transition: var(--transition);
}

.radio-custom {
  border-radius: 50%;
}

.checkbox-label input,
.radio-label input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.checkbox-label input:checked~.checkbox-custom::after {
  content: "\f00c";
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: var(--primary-color);
  font-size: 12px;
}

.radio-label input:checked~.radio-custom::after {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: var(--primary-color);
}

.checkbox-label:hover .checkbox-custom,
.radio-label:hover .radio-custom {
  border-color: var(--primary-color);
}


/* Hero Section Styles */

.hero {
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/hero-bg.jpg") center / cover no-repeat;
  color: white;
  text-align: center;
  padding: 120px 20px;
  margin-bottom: 60px;
  position: relative;
  
}

.hero::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(45deg, rgba(232, 62, 140, 0.3), rgba(111, 66, 193, 0.3));
  z-index: 1;
}

.hero .container {
  position: relative;
  z-index: 2;
}

.hero h1 {
  font-size: 3.5rem;
  margin-bottom: 20px;
  font-weight: 800;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  animation: fadeInDown 1s ease;
}

.hero p {
  font-size: 1.4rem;
  max-width: 800px;
  margin: 0 auto 30px;
  opacity: 0.9;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
  animation: fadeInUp 1s ease 0.3s both;
}


/* Breadcrumbs */

.breadcrumbs {
  margin-bottom: var(--spacing-lg);
  font-size: var(--font-size-sm);
  color: #6c757d;
}

.breadcrumbs a {
  color: #6c757d;
  text-decoration: none;
}

.breadcrumbs a:hover {
  color: var(--primary-color);
}

.breadcrumbs span {
  color: var(--dark-color);
}


/* Cards */

.card {
  background-color: white;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);

  transition: var(--transition);
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.card-image {
  position: relative;
 
}

.card-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.card:hover .card-image img {
  transform: scale(1.05);
}

.card-content {
  padding: var(--spacing-lg);
}

.card-title {
  font-size: 1.3rem;
  margin-bottom: var(--spacing-sm);
}

.card-text {
  color: #6c757d;
  margin-bottom: var(--spacing-md);
}

.card-footer {
  padding: var(--spacing-md) var(--spacing-lg);
  border-top: 1px solid var(--border-color);
  display: flex;
  justify-content: space-between;
  align-items: center;
}


/* Badges */

.badge {
  display: inline-block;
  padding: 4px 8px;
  border-radius: 50px;
  font-size: var(--font-size-xs);
  font-weight: var(--font-weight-medium);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.badge.primary {
  background-color: var(--primary-light);
  color: white;
}

.badge.secondary {
  background-color: var(--secondary-light);
  color: white;
}

.badge.success {
  background-color: var(--success-color);
  color: white;
}

.badge.warning {
  background-color: var(--warning-color);
  color: var(--dark-color);
}

.badge.danger {
  background-color: var(--danger-color);
  color: white;
}

.badge.info {
  background-color: var(--info-color);
  color: white;
}


/* Alerts */

.alert {
  padding: var(--spacing-md) var(--spacing-lg);
  border-radius: var(--border-radius);
  margin-bottom: var(--spacing-lg);
  display: flex;
  align-items: center;
  gap: var(--spacing-md);
}

.alert-icon {
  font-size: 1.5rem;
}

.alert-content {
  flex: 1;
}

.alert-content h4 {
  margin-bottom: var(--spacing-xs);
}

.alert-success {
  background-color: rgba(40, 167, 69, 0.1);
  border-left: 4px solid var(--success-color);
  color: var(--success-color);
}

.alert-warning {
  background-color: rgba(255, 193, 7, 0.1);
  border-left: 4px solid var(--warning-color);
  color: #856404;
}

.alert-danger {
  background-color: rgba(220, 53, 69, 0.1);
  border-left: 4px solid var(--danger-color);
  color: var(--danger-color);
}

.alert-info {
  background-color: rgba(23, 162, 184, 0.1);
  border-left: 4px solid var(--info-color);
  color: var(--info-color);
}


/* Modals */

.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1000;

  padding: 50px 0;
  animation: fadeIn 0.3s ease;
}

.modal-content {
  background-color: white;
  border-radius: var(--border-radius);
  max-width: 600px;
  margin: 0 auto;
  padding: var(--spacing-xl);
  position: relative;
  animation: slideInUp 0.4s ease;
}

.close-modal {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 1.5rem;
  cursor: pointer;
  color: #aaa;
  transition: var(--transition);
}

.close-modal:hover {
  color: var(--dark-color);
}

.modal.active {
  display: block;
}


/* Tabs */

.tabs-container {
  margin-bottom: var(--spacing-xxl);
}

.tabs-header {
  display: flex;
  border-bottom: 1px solid var(--border-color);
  margin-bottom: var(--spacing-lg);
 
  scrollbar-width: none;
  /* Firefox */
}

.tabs-header::-webkit-scrollbar {
  display: none;
  /* Chrome, Safari, Edge */
}

.tab-btn {
  padding: var(--spacing-md) var(--spacing-lg);
  background: none;
  border: none;
  border-bottom: 3px solid transparent;
  font-weight: var(--font-weight-medium);
  color: #6c757d;
  cursor: pointer;
  transition: var(--transition);
  white-space: nowrap;
}

.tab-btn:hover {
  color: var(--primary-color);
}

.tab-btn.active {
  color: var(--primary-color);
  border-bottom-color: var(--primary-color);
}

.tab-panel {
  display: none;
  animation: fadeIn 0.5s ease;
}

.tab-panel.active {
  display: block;
}


/* Accordions */

.faq-accordion {
  max-width: 800px;
  margin: 0 auto;
}

.faq-item {
  margin-bottom: var(--spacing-md);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  
  
}

.faq-question {
  background-color: #f8f9fa;
  padding: var(--spacing-md) var(--spacing-lg);
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  transition: var(--transition);
}

.faq-question h3 {
  font-size: 1.1rem;
  margin: 0;
  font-weight: var(--font-weight-medium);
}

.faq-question i {
  transition: transform 0.3s ease;
  color: var(--primary-color);
}

.faq-item.active .faq-question {
  background-color: #f0f0f0;
}

.faq-item.active .faq-question i {
  transform: rotate(180deg);
}

.faq-answer {
  padding: 0;
  max-height: 0;
 
  
  transition: max-height 0.3s ease, padding 0.3s ease;
}

.faq-item.active .faq-answer {
  padding: var(--spacing-lg);
  max-height: 1000px;
}


/* Pagination */

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: var(--spacing-xl);
  gap: var(--spacing-md);
}

.pagination-btn {
  padding: 8px 16px;
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  background-color: white;
  cursor: pointer;
  transition: var(--transition);
  display: flex;
  align-items: center;
  gap: 5px;
}

.pagination-btn:hover:not(:disabled) {
  background-color: var(--primary-color);
  color: white;
  border-color: var(--primary-color);
}

.pagination-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.pagination-info {
  font-size: var(--font-size-sm);
  color: #6c757d;
}


/* Tooltips */

.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltip-text {
  visibility: hidden;
  width: 120px;
  background-color: var(--dark-color);
  color: white;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.3s;
  font-size: var(--font-size-xs);
}

.tooltip .tooltip-text::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: var(--dark-color) transparent transparent transparent;
}

.tooltip:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}


/* Toasts */

.toast-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
}

.toast {
  background-color: white;
  border-radius: var(--border-radius);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  padding: 15px 20px;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-width: 300px;
  max-width: 400px;
  animation: slideInRight 0.3s ease;
}

.toast.toast-hiding {
  animation: slideOutRight 0.3s ease forwards;
}

.toast-content {
  display: flex;
  align-items: center;
  gap: 10px;
}

.toast-content i {
  font-size: 1.2rem;
}

.toast-close {
  background: none;
  border: none;
  color: #aaa;
  cursor: pointer;
  transition: var(--transition);
}

.toast-close:hover {
  color: var(--dark-color);
}

.toast-success {
  border-left: 4px solid var(--success-color);
}

.toast-success i {
  color: var(--success-color);
}

.toast-error {
  border-left: 4px solid var(--danger-color);
}

.toast-error i {
  color: var(--danger-color);
}

.toast-info {
  border-left: 4px solid var(--info-color);
}

.toast-info i {
  color: var(--info-color);
}

.toast-warning {
  border-left: 4px solid var(--warning-color);
}

.toast-warning i {
  color: var(--warning-color);
}


/* Loaders */

.loader {
  display: inline-block;
  width: 40px;
  height: 40px;
  border: 3px solid rgba(232, 62, 140, 0.3);
  border-radius: 50%;
  border-top-color: var(--primary-color);
  animation: spin 1s ease-in-out infinite;
}

.loader-container {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: var(--spacing-xl) 0;
}

.loader-text {
  margin-left: var(--spacing-md);
  color: #6c757d;
}


/* CTA Section */

.cta-section {
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/cta-bg.jpg") center / cover no-repeat;
  padding: 80px 0;
  margin: 60px 0;
  position: relative;
}

.cta-section::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(45deg, rgba(232, 62, 140, 0.7), rgba(111, 66, 193, 0.7));
  z-index: 1;
}

.cta-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: white;
  max-width: 800px;
  margin: 0 auto;
}

.cta-content h2 {
  font-size: 2.5rem;
  margin-bottom: var(--spacing-md);
}

.cta-content p {
  font-size: var(--font-size-lg);
  margin-bottom: var(--spacing-lg);
  opacity: 0.9;
}

.cta-button {
  display: inline-block;
  background-color: white;
  color: var(--primary-color);
  padding: 14px 30px;
  border-radius: 50px;
  font-weight: var(--font-weight-bold);
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: var(--transition);
}

.cta-button:hover {
  background-color: var(--primary-color);
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.cta-buttons {
  display: flex;
  justify-content: center;
  gap: var(--spacing-md);
  flex-wrap: wrap;
}

.cta-button.primary {
  background-color: white;
  color: var(--primary-color);
}

.cta-button.primary:hover {
  background-color: var(--primary-color);
  color: white;
}

.cta-button.secondary {
  background-color: transparent;
  color: white;
  border: 2px solid white;
}

.cta-button.secondary:hover {
  background-color: white;
  color: var(--primary-color);
}


/* Animations */

@keyframes fadeIn {
  from {
      opacity: 0;
  }
  to {
      opacity: 1;
  }
}

@keyframes fadeInUp {
  from {
      opacity: 0;
      transform: translateY(20px);
  }
  to {
      opacity: 1;
      transform: translateY(0);
  }
}

@keyframes fadeInDown {
  from {
      opacity: 0;
      transform: translateY(-20px);
  }
  to {
      opacity: 1;
      transform: translateY(0);
  }
}

@keyframes fadeInLeft {
  from {
      opacity: 0;
      transform: translateX(-20px);
  }
  to {
      opacity: 1;
      transform: translateX(0);
  }
}

@keyframes fadeInRight {
  from {
      opacity: 0;
      transform: translateX(20px);
  }
  to {
      opacity: 1;
      transform: translateX(0);
  }
}

@keyframes slideInUp {
  from {
      transform: translateY(50px);
      opacity: 0;
  }
  to {
      transform: translateY(0);
      opacity: 1;
  }
}

@keyframes slideInDown {
  from {
      transform: translateY(-50px);
      opacity: 0;
  }
  to {
      transform: translateY(0);
      opacity: 1;
  }
}

@keyframes slideInLeft {
  from {
      transform: translateX(-50px);
      opacity: 0;
  }
  to {
      transform: translateX(0);
      opacity: 1;
  }
}

@keyframes slideInRight {
  from {
      transform: translateX(50px);
      opacity: 0;
  }
  to {
      transform: translateX(0);
      opacity: 1;
  }
}

@keyframes slideOutRight {
  from {
      transform: translateX(0);
      opacity: 1;
  }
  to {
      transform: translateX(50px);
      opacity: 0;
  }
}

@keyframes spin {
  to {
      transform: rotate(360deg);
  }
}

@keyframes pulse {
  0% {
      transform: scale(1);
  }
  50% {
      transform: scale(1.05);
  }
  100% {
      transform: scale(1);
  }
}

@keyframes bounce {
  0%,
  20%,
  50%,
  80%,
  100% {
      transform: translateY(0);
  }
  40% {
      transform: translateY(-20px);
  }
  60% {
      transform: translateY(-10px);
  }
}

@keyframes shake {
  0%,
  100% {
      transform: translateX(0);
  }
  10%,
  30%,
  50%,
  70%,
  90% {
      transform: translateX(-5px);
  }
  20%,
  40%,
  60%,
  80% {
      transform: translateX(5px);
  }
}


/* Responsive Styles */

@media (max-width: 1200px) {
   :root {
      --container-width: 960px;
  }
}

@media (max-width: 992px) {
   :root {
      --container-width: 720px;
  }
  .section-header h2 {
      font-size: 2.2rem;
  }
  .hero h1 {
      font-size: 3rem;
  }
  .hero p {
      font-size: 1.2rem;
  }
}

@media (max-width: 768px) {
   :root {
      --container-width: 540px;
  }
  .section-header h2 {
      font-size: 2rem;
  }
  .hero {
      padding: 80px 20px;
  }
  .hero h1 {
      font-size: 2.5rem;
  }
  .hero p {
      font-size: 1.1rem;
  }
  .form-row {
      flex-direction: column;
      gap: var(--spacing-md);
  }
  .cta-content h2 {
      font-size: 2rem;
  }
  .cta-buttons {
      flex-direction: column;
      align-items: center;
  }
}

@media (max-width: 576px) {
   :root {
      --container-width: 100%;
  }
  .section-header h2 {
      font-size: 1.8rem;
  }
  .hero h1 {
      font-size: 2rem;
  }
  .hero p {
      font-size: 1rem;
  }
  .tabs-header {
      flex-wrap: nowrap;
      
      
  }
  .tab-btn {
      padding: 10px 15px;
      font-size: var(--font-size-sm);
  }
  .modal-content {
      padding: var(--spacing-md);
      max-width: 90%;
  }
  .toast {
      min-width: auto;
      width: 90%;
  }
}


/* Gift Card Page Styles */

.section-praents {
  position: relative;
  bottom: 800px;
  margin-bottom: 1400px;
  position: relative;
}

.section-praents-location {
  position: relative;
  bottom: 20px;
  margin-bottom: 1400px;
  position: relative;
}

.section-praents-join-team {
  position: relative;
  bottom: 20px;
  margin-bottom: 1400px;
  position: relative;
  top: 240px;
}

.gift-card-hero {
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/gift-card-hero.jpg") center / cover no-repeat;
}

.gift-card-options {
  padding: 60px 0;
  position: relative;
}

.gift-card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 30px;
  margin-bottom: 50px;
}

.gift-card-item {
  background-color: white;
  border-radius: var(--border-radius);
 
  box-shadow: var(--shadow);
  transition: var(--transition);
  display: flex;
  flex-direction: column;
  animation: fadeIn 0.8s ease;
}

.gift-card-item:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}

.gift-card-image {
  position: relative;

  
}

.gift-card-image img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.gift-card-item:hover .gift-card-image img {
  transform: scale(1.08);
}

.card-overlay {
  position: absolute;
  bottom: -50px;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.7);
  padding: 15px;
  transition: bottom 0.3s ease;
  text-align: center;
}

.gift-card-item:hover .card-overlay {
  bottom: 0;
}

.view-details-btn {
  color: white;
  font-weight: var(--font-weight-medium);
  display: inline-block;
  transition: var(--transition);
}

.view-details-btn:hover {
  color: var(--primary-light);
}

.gift-card-content {
  padding: 25px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.gift-card-content h3 {
  font-size: 1.5rem;
  margin-bottom: 10px;
  color: var(--dark-color);
}

.card-description {
  margin-bottom: 20px;
  color: #6c757d;
}

.price-options {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 25px;
}

.price-option {
  background-color: #f8f9fa;
  border: 2px solid #dee2e6;
  border-radius: 5px;
  padding: 8px 15px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  color: var(--dark-color);
}

.price-option:hover {
  background-color: #e9ecef;
  border-color: var(--primary-color);
}

.price-option.active {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
  color: white;
}

.add-to-cart-btn {
  background-color: var(--secondary-color);
  color: white;
  border: none;
  border-radius: 5px;
  padding: 12px 20px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.add-to-cart-btn:hover {
  background-color: var(--secondary-dark);
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(111, 66, 193, 0.3);
}

.how-it-works {
  padding: 60px 0;
  background-color: #f8f9fa;
}

.steps-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
}

.step-item {
  background-color: white;
  border-radius: var(--border-radius);
  padding: 30px;
  text-align: center;
  box-shadow: var(--shadow);
  flex: 1;
  min-width: 220px;
  max-width: 280px;
  transition: var(--transition);
  position: relative;
}

.step-item:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.step-item:not(:last-child)::after {
  content: "\f054";
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
  position: absolute;
  top: 50%;
  right: -20px;
  transform: translateY(-50%);
  color: var(--primary-color);
  font-size: 20px;
  z-index: 1;
}

.step-icon {
  width: 70px;
  height: 70px;
  background-color: rgba(232, 62, 140, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
}

.step-icon i {
  font-size: 30px;
  color: var(--primary-color);
}

.step-item h3 {
  font-size: 1.3rem;
  margin-bottom: 10px;
  color: var(--dark-color);
}

.step-item p {
  color: #6c757d;
}

.gift-card-info {
  padding: 60px 0;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 30px;
}

.info-item {
  background-color: white;
  border-radius: var(--border-radius);
  padding: 30px;
  text-align: center;
  box-shadow: var(--shadow);
  transition: var(--transition);
  border-top: 3px solid var(--primary-color);
}

.info-item:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.info-item i {
  font-size: 2.5rem;
  color: var(--primary-color);
  margin-bottom: 20px;
}

.info-item h3 {
  font-size: 1.3rem;
  margin-bottom: 15px;
  color: var(--dark-color);
}

.info-item p {
  color: #6c757d;
  line-height: 1.6;
}

.product-actions{
  margin-left: 20px;
}
.favorite-btn{
  color: #ff2a2a;
  margin-left: 200px;
}
.btn-outline {
  justify-content: center;
}

/* Mobile Menu Styles */
.mobile-menu-icon {
  display: none;
  font-size: 24px;
  color: white;
  cursor: pointer;
}

.mobile-sidebar {
  display: none;
}

/* Auth buttons container */
.auth-buttons {
  display: flex;
  gap: 15px;
  align-items: center;
}

/* Play Button (No border) */
.play-button {
  background: black;
  color: white;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 14px;
}

/* Sign In Button (White - No border) */
.sign-in-button {
  background: white;
  color:  #ff2a2a;
  padding: 10px 22px;
  border-radius: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
  border: none;
}

/* Sign Out Button (Black - No border) */
.sign-out-button {
  background:  #ff2a2a;
  color: white;
  padding: 10px 22px;
  border-radius: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
  border: none;
}

/* Hover effects */
.play-button:hover {
  background: #333;
  transform: scale(1.05);
}

.sign-in-button:hover {
  background: #f5f5f5;
  transform: translateY(-2px);
}

.sign-out-button:hover {
  background: #333;
  transform: translateY(-2px);
}

/* Hero Section Styles */
.hero-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 0;
  margin-bottom: 40px;
}

.hero-content {
  flex: 1;
  padding-right: 20px;
}

.hero-buttons {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

.explore-btn, .order-now-btn {
  padding: 12px 25px;
  font-weight: 600;
}

/* Quick Links Section */
.quick-links {
  margin-top: 30px;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.quick-links h3 {
  font-size: 18px;
  margin-bottom: 15px;
  color: #333;
  text-align: center;
}

.quick-links-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px;
}

.quick-link-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 15px;
  border-radius: 8px;
  transition: all 0.3s ease;
  background-color: #f8f9fa;
}

.quick-link-item:hover {
  background-color: #ff5e62;
  transform: translateY(-5px);
}

.quick-link-item:hover i,
.quick-link-item:hover span {
  color: white;
}

.quick-link-item i {
  font-size: 24px;
  color: #ff5e62;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}

.quick-link-item span {
  font-size: 14px;
  font-weight: 600;
  color: #333;
  transition: all 0.3s ease;
}

/* Mobile Sidebar Enhanced Styles */
.mobile-sidebar {
  display: block;
  position: fixed;
  top: 0;
  left: -100%;
  width: 80%;
  height: 100vh;
  background: white;
  z-index: 1002;
  padding: 20px;
  transition: all 0.3s ease;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
  overflow-y: auto;
}

.mobile-sidebar.show {
  left: 0;
}

.mobile-sidebar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 15px;
  margin-bottom: 20px;
  border-bottom: 1px solid #eee;
}

.mobile-sidebar-header img {
  width: 40px;
  height: auto;
}

.mobile-sidebar-close {
  font-size: 24px;
  color: #999;
  background: none;
  border: none;
  cursor: pointer;
}

.mobile-sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.mobile-sidebar ul li {
  margin-bottom: 15px;
}

.mobile-sidebar ul li a {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  color: #333;
  text-decoration: none;
  font-weight: 600;
  border-radius: 8px;
  transition: all 0.3s;
}

.mobile-sidebar ul li a i {
  margin-right: 15px;
  font-size: 20px;
  color: #ff5e62;
  width: 24px;
  text-align: center;
}

.mobile-sidebar ul li a:hover {
  background: #ff5e62;
  color: white;
}

.mobile-sidebar ul li a:hover i {
  color: white;
}

.mobile-sidebar-divider {
  height: 1px;
  background: #eee;
  margin: 15px 0;
}

.mobile-sidebar-footer {
  margin-top: 30px;
  padding-top: 20px;
  border-top: 1px solid #eee;
}

.mobile-sidebar-footer .social-links {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-bottom: 20px;
}

.mobile-sidebar-footer .social-links a {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ff5e62;
  transition: all 0.3s;
}

.mobile-sidebar-footer .social-links a:hover {
  background: #ff5e62;
  color: white;
  transform: translateY(-3px);
}

/* Additional Responsive Styles */
@media (max-width: 768px) {
  .mobile-menu-icon {
      display: block;
  }
  
  .hero-section {
      flex-direction: column;
      text-align: center;
  }
  
  .hero-content {
      padding-right: 0;
      margin-bottom: 30px;
  }
  
  .hero-buttons {
      justify-content: center;
  }
  
  .header-banner img {
      left: 0;
  }
  
  .quick-links-grid {
      grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 480px) {
  .quick-links-grid {
      grid-template-columns: 1fr;
  }
}
</style>
<header>
  <div class="mobile-menu-icon">
    <a href="#" id="menuToggle" class="menu-icon-link">
      <img src="assets/image/icon navabr.png" alt="Menu Icon">
    </a>
  </div>

  <div class="logo-container">
    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo" class="logo">
  </div>

  <nav id="navLinks">
    <ul>
      <li><a href="/gift-card"><i class="fas fa-gift"></i> Gift Card</a></li>
      <li><a href="/locations"><i class="fas fa-map-marker-alt"></i> Locations</a></li>
      <li><a href="/join-the-team"><i class="fas fa-users"></i> Join The Team</a></li>
    </ul>
  </nav>

  <div class="auth-buttons">
    <button class="sign-in-button" onclick="window.location.href='/login'">Sign In</button>
    <button class="sign-out-button" onclick="window.location.href='/register'">Sign Out</button>
  </div>
</header>

<!-- Sidebar for Mobile -->
<div id="mobileSidebar" class="mobile-sidebar">
  <div class="mobile-sidebar-header">
    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
    <button class="mobile-sidebar-close" id="closeSidebar">
      <i class="fas fa-times"></i>
    </button>
  </div>
  
  <ul>
    <li><a href="/gift-card"><i class="fas fa-gift"></i> Gift Card</a></li>
    <li><a href="/locations"><i class="fas fa-map-marker-alt"></i> Locations</a></li>
    <li><a href="/join-the-team"><i class="fas fa-users"></i> Join The Team</a></li>
  </ul>

  <div class="mobile-sidebar-footer">
    <div class="social-links">
      <a href="https://facebook.com/xingfucha" target="_blank"><i class="fab fa-facebook-f"></i></a>
      <a href="https://instagram.com/xingfucha" target="_blank"><i class="fab fa-instagram"></i></a>
      <a href="https://twitter.com/xingfucha" target="_blank"><i class="fab fa-twitter"></i></a>
      <a href="https://tiktok.com/@xingfucha" target="_blank"><i class="fab fa-tiktok"></i></a>
    </div>
  </div>
</div>

<section class="content-welcome">
    
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="header-banner">
            <img src="/assets/image/Header-banner.png" alt="Xing Fu Cha Bubble Tea">
        </div>
        <div class="hero-content">
            <h1>Welcome to <span class="brand-name">XING FU CHA</span></h1>
            <p>
                Experience the authentic taste of premium bubble tea and refreshing drinks. 
                Our handcrafted beverages are made with the finest ingredients, offering a perfect 
                balance of sweetness, creaminess, and chewiness in every sip. Whether you love 
                classic milk tea, fruity blends, or unique toppings, we have something special for you. 
                Come and indulge in the ultimate bubble tea experience!
            </p>

            
            <div class="wave-text">Sip Happiness in Every Cup! </div> <!-- New animated text -->

            <div class="hero-buttons">
                <button class="btn-primary explore-btn">Explore Menu</button>
                <button class="btn-outline order-now-btn">Order Now</button>
            </div>

        </div>
    </div>
    <!-- Category Section -->
    <div class="category-section">
        <div class="category-list">
            <div class="category-item active" data-category="all"><i class="fas fa-th-large"></i> All</div>
            <div class="category-item" data-category="milk-tea"><i class="fas fa-mug-hot"></i> Milk Tea</div>
            <div class="category-item" data-category="fruit-tea"><i class="fas fa-apple-alt"></i> Fruit Tea</div>
            <div class="category-item" data-category="smoothie"><i class="fas fa-blender"></i> Smoothies</div>
            <div class="category-item" data-category="coffee"><i class="fas fa-coffee"></i> Coffee</div>
            <div class="category-item" data-category="snacks"><i class="fas fa-cookie"></i> Snacks</div>
        </div>
        <div class="search-container">
            <input type="text" id="productSearch" placeholder="Search for your favorite drink...">
            <i class="fas fa-search"></i>
        </div>
    </div>
    <!-- Popular dishes section -->
    <div class="popular-dishes">
        <h3>Popular Drinks & Snacks</h3>
        <div class="dishes-list" id="dishes-container">
            <!-- Product Cards (Dynamic Product List) -->
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/milk-tea-macha.png" alt="Strawberry Smoothie">
                </div>


                <div class="product-info">
                    <h4>Strawberry Smoothie</h4>
                    <p class="description">Delicious strawberry smoothie with a creamy texture.</p>
                    <div class="product-price">$4.99</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="9">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/Almond Puff 55baht.png" alt="Mango Smoothie">
                </div>

                <div class="product-info">
                    <h4>Almond Puff</h4>
                    <p class="description">A refreshing mango smoothie for your hot day.</p>
                    <div class="product-price">$5.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="10">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/image/products/coffee-cream.png" alt="Classic Milk Tea">
                </div>

                <div class="product-info">
                    <h4>Classic Milk Tea</h4>
                    <p class="description">Our signature milk tea with premium black tea and creamy milk.</p>
                    <div class="product-price">$4.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="1">Order Now</button>
                </div>
            </div>
            

            
            <!-- No products found message -->

        </div>
    </div>
</section>

<!-- Login Redirect Modal -->
<div class="modal-overlay" id="loginRedirectModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Login Required</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="login-redirect-content">
                <i class="fas fa-user-lock"></i>
                <p>Please login to continue with your order</p>
                <div class="login-redirect-buttons">
                    <a href="/login" class="btn-primary">Login</a>
                    <a href="/register" class="btn-outline">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div class="modal-overlay" id="orderModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Customize Your Drink</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="product-details">
                <img src="/placeholder.svg?height=100&width=100" alt="" class="modal-product-image">
                <div class="modal-product-info">
                    <h4 class="modal-product-name"></h4>
                    <p class="modal-product-description"></p>
                    <div class="modal-product-price"></div>
                </div>
            </div>
            
            <hr class="modal-divider">
            
            <form id="customizeForm">
                <input type="hidden" name="product_id" id="product_id">
                
                <div class="form-group">
                    <label>Size</label>
                    <div class="option-buttons size-buttons">
                        <label class="option-button">
                            <input type="radio" name="size" value="small" data-price="0">
                            <span>Small</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="medium" data-price="0.50" checked>
                            <span>Medium</span>
                            <small>+$0.50</small>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="large" data-price="1.00">
                            <span>Large</span>
                            <small>+$1.00</small>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Sugar Level</label>
                    <div class="option-buttons sugar-buttons">
                        <label class="option-button">
                            <input type="radio" name="sugar" value="0">
                            <span>0%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="30">
                            <span>30%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="50" checked>
                            <span>50%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="70">
                            <span>70%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="100">
                            <span>100%</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" id="cancelOrder">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div class="toast-container" id="toastContainer"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    const authButtons = document.querySelector('.auth-buttons');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        navLinks.classList.toggle('show');
        authButtons.classList.toggle('show');
        mobileSidebar.classList.toggle('show');
    });
    
    closeSidebar.addEventListener('click', function() {
        mobileSidebar.classList.remove('show');
    });
    
    // Close mobile menu when clicking on a link
    const navItems = document.querySelectorAll('#navLinks a, #mobileSidebar a');
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            navLinks.classList.remove('show');
            authButtons.classList.remove('show');
            mobileSidebar.classList.remove('show');
        });
    });
    
    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#mobileSidebar') && 
            !event.target.closest('#menuToggle') && 
            mobileSidebar.classList.contains('show')) {
            mobileSidebar.classList.remove('show');
        }
    });
    
    // Category filtering
    const categoryItems = document.querySelectorAll('.category-item');
    const productCards = document.querySelectorAll('.product-card');
    
    categoryItems.forEach(item => {
        item.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Remove active class from all items
            categoryItems.forEach(cat => cat.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Filter products
            productCards.forEach(card => {
                if (category === 'all' || card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('productSearch');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        productCards.forEach(card => {
            const title = card.querySelector('h4').textContent.toLowerCase();
            const description = card.querySelector('.description').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Order button functionality
    const orderButtons = document.querySelectorAll('.order-btn');
    const orderModal = document.getElementById('orderModal');
    
    orderButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const productCard = this.closest('.product-card');
            const productName = productCard.querySelector('h4').textContent;
            const productDesc = productCard.querySelector('.description').textContent;
            const productPrice = productCard.querySelector('.product-price').textContent;
            const productImage = productCard.querySelector('.product-image img').src;
            
            // Set modal content
            document.getElementById('product_id').value = productId;
            document.querySelector('.modal-product-name').textContent = productName;
            document.querySelector('.modal-product-description').textContent = productDesc;
            document.querySelector('.modal-product-price').textContent = productPrice;
            document.querySelector('.modal-product-image').src = productImage;
            
            // Show modal
            orderModal.classList.add('active');
        });
    });
    
    // Close modal
    const closeModalButtons = document.querySelectorAll('.close-modal');
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.modal-overlay').classList.remove('active');
        });
    });
    
    // Cancel order
    document.getElementById('cancelOrder').addEventListener('click', function() {
        orderModal.classList.remove('active');
    });
    
    // Form submission
    document.getElementById('customizeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show success toast
        showToast('Success', 'Item added to your cart!', 'success');
        
        // Close modal
        orderModal.classList.remove('active');
    });
    
    // Toast notification function
    function showToast(title, message, type) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info-circle'}"></i>
            </div>
            <div class="toast-content">
                <h4 class="toast-title">${title}</h4>
                <p class="toast-message">${message}</p>
            </div>
            <button class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.getElementById('toastContainer').appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('toast-hiding');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
        
        // Close button
        toast.querySelector('.toast-close').addEventListener('click', function() {
            toast.classList.add('toast-hiding');
            setTimeout(() => {
                toast.remove();
            }, 300);
        });
    }
});
</script>
