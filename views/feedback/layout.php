<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drink Shop Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        
        .main-content {
            min-height: 100vh;
        }
        
        .page-container {
            display: flex;
        }
        
        .content-wrapper {
            flex: 1;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .sidebar-wrapper {
            width: 280px;
            transition: all 0.3s;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #E91E63;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #D81B60;
        }
        
        /* Responsive sidebar */
        @media (max-width: 768px) {
            .sidebar-wrapper {
                width: 70px;
            }
            
            .sidebar-wrapper .nav-link span,
            .sidebar-wrapper .sidebar-header h3,
            .sidebar-wrapper .sidebar-header p,
            .sidebar-wrapper .admin-profile div,
            .sidebar-wrapper .text-uppercase {
                display: none;
            }
            
            .sidebar-wrapper .logo-circle {
                width: 40px;
                height: 40px;
            }
            
            .content-wrapper {
                margin-left: 0;
            }
            
            .sidebar-wrapper .badge {
                position: absolute;
                top: 5px;
                right: 5px;
                font-size: 0.6rem;
            }
        }
        
        /* Toast notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
</head>
<body>
    <!-- Toast notification container -->
    <div class="toast-container"></div>

    <div class="page-container">
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <?php if (isset($content) && strpos($content, 'sidebar') !== false): ?>
                <!-- The sidebar is already included in the content -->
            <?php else: ?>
                <?php include 'views/feedback/sidebar.php'; ?>
            <?php endif; ?>
        </div>
        
        <!-- Main Content -->
        <div class="content-wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded">
                <div class="container-fluid">
                    <button class="navbar-toggler border-0" type="button" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-link text-dark dropdown-toggle" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <span class="badge rounded-pill" style="background-color: #E91E63;">3</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                                <li><h6 class="dropdown-header">Notifications</h6></li>
                                <li><a class="dropdown-item" href="#">New order received</a></li>
                                <li><a class="dropdown-item" href="#">New feedback submitted</a></li>
                                <li><a class="dropdown-item" href="#">System update available</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="#">View all</a></li>
                            </ul>
                        </div>
                        
                        <div class="dropdown ms-3">
                            <button class="btn btn-link text-dark dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar-circle me-2" style="background-color: #E91E63; width: 30px; height: 30px; font-size: 12px;">
                                    A
                                </div>
                                <span>Admin</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <?php echo $content; ?>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar-wrapper').classList.toggle('collapsed');
            document.querySelector('.content-wrapper').classList.toggle('expanded');
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Show toast notification on page load (demo)
        window.addEventListener('DOMContentLoaded', (event) => {
            // Create toast element
            const toastEl = document.createElement('div');
            toastEl.className = 'toast show';
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');
            
            toastEl.innerHTML = `
                <div class="toast-header">
                    <strong class="me-auto" style="color: #E91E63;">
                        <i class="fas fa-info-circle me-1"></i> Notification
                    </strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Welcome to the Feedback Management System!
                </div>
            `;
            
            // Add to container
            document.querySelector('.toast-container').appendChild(toastEl);
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                const toast = new bootstrap.Toast(toastEl);
                toast.hide();
            }, 5000);
        });
    </script>
</body>
</html>

