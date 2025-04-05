<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Admin Dashboard - XING FU CHA'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            padding-top: 0;
            overflow-x: hidden;
        }
        
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        
        .main-content {
            width: 100%;
            padding: 20px;
            margin-left: 250px; /* Adjust this to match your sidebar width */
            transition: all 0.3s;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1.25rem 1.5rem;
        }
        
        .search-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .search-input {
            width: 300px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .badge-admin {
            background-color: #4e73df;
            color: white;
        }
        
        .badge-user {
            background-color: #1cc88a;
            color: white;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            
            .search-container {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }
            
            .search-input {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php require './views/admin/Partials/sidebar.php' ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require './views/admin/Partials/navbar.php' ?>
                
                <div class="container-fluid">
                    <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0 font-weight-bold text-primary">User Management</h5>
                            <div class="search-container">
                                <div class="input-group search-input">
                                    <input type="text" class="form-control" placeholder="Search users..." id="searchInput">
                                    <button class="btn btn-primary" type="button" id="searchButton">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <a href="/admin/users/create" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Add User
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="userTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($users)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No users found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach($users as $index => $user): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td>
                                                        <?php if(!empty($user['image'])): ?>
                                                            <img src="<?php echo htmlspecialchars($user['image']); ?>" alt="User Avatar" class="user-avatar">
                                                        <?php else: ?>
                                                            <img src="/placeholder.svg?height=40&width=40" alt="Default Avatar" class="user-avatar">
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                                    <td>
                                                        <span class="badge <?php echo $user['role'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                                                            <?php echo ucfirst(htmlspecialchars($user['role'] ?? 'user')); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchButton').click(function() {
                filterTable();
            });
            
            $('#searchInput').keyup(function(e) {
                if (e.keyCode === 13) {
                    filterTable();
                }
            });
            
            function filterTable() {
                const value = $('#searchInput').val().toLowerCase();
                $('#userTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            }
        });
    </script>
</body>

</html>