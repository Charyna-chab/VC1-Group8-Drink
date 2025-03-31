<div class="sidebar bg-dark text-white" style="min-height: 100vh;">
    <div class="sidebar-header p-3 text-center">
        <div class="logo-container mb-3">
            <div class="logo-circle mx-auto" style="background-color: #E91E63;">
                <i class="fas fa-coffee fa-lg"></i>
            </div>
        </div>
        <h3 class="text-white mb-0">Drink Shop</h3>
        <div class="divider bg-pink opacity-25 my-2"></div>
        <p class="text-muted small mb-0">Admin Dashboard</p>
    </div>
    
    <div class="px-3 py-2">
        <div class="admin-profile d-flex align-items-center mb-3">
            <div class="avatar-circle me-2" style="background-color: #E91E63;">
                <span>A</span>
            </div>
            <div>
                <div class="text-white fw-bold">Admin User</div>
                <div class="text-muted small">Administrator</div>
            </div>
        </div>
    </div>
    
    <ul class="nav flex-column sidebar-menu p-2">
        <li class="nav-item mb-2">
            <a href="dashboard" class="nav-link text-white d-flex align-items-center p-3 rounded hover-effect">
                <i class="fas fa-tachometer-alt me-3"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="feedback" class="nav-link active d-flex align-items-center p-3 rounded" style="background-color: #E91E63;">
                <i class="fas fa-comments me-3"></i>
                <span>Feedback</span>
                <span class="badge bg-white text-dark ms-auto">5</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="products" class="nav-link text-white d-flex align-items-center p-3 rounded hover-effect">
                <i class="fas fa-coffee me-3"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="orders" class="nav-link text-white d-flex align-items-center p-3 rounded hover-effect">
                <i class="fas fa-shopping-cart me-3"></i>
                <span>Orders</span>
                <span class="badge bg-info text-dark ms-auto">3</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="users" class="nav-link text-white d-flex align-items-center p-3 rounded hover-effect">
                <i class="fas fa-users me-3"></i>
                <span>Customers</span>
            </a>
        </li>
        
        <li class="nav-item mt-3">
            <div class="text-muted small px-3 py-2 text-uppercase fw-bold">System</div>
        </li>
        
        <li class="nav-item mb-2">
            <a href="settings" class="nav-link text-white d-flex align-items-center p-3 rounded hover-effect">
                <i class="fas fa-cog me-3"></i>
                <span>Settings</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="reports" class="nav-link text-white d-flex align-items-center p-3 rounded hover-effect">
                <i class="fas fa-chart-bar me-3"></i>
                <span>Reports</span>
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer p-3 mt-auto border-top border-secondary">
        <div class="d-grid">
            <a href="logout" class="btn btn-outline-light">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
</div>

<style>
    /* Custom sidebar styles */
    .sidebar {
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .divider {
        height: 1px;
        width: 100%;
    }
    
    .bg-pink {
        background-color: #E91E63;
    }
    
    .hover-effect:hover {
        background-color: rgba(233, 30, 99, 0.2);
        transition: background-color 0.2s ease;
    }
    
    .nav-link.active {
        font-weight: bold;
    }
    
    .logo-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>

