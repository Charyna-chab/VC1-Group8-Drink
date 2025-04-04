<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Admin Dashboard - XING FU CHA'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        /* Custom styles for full-width table */
        body {
            overflow-x: hidden;
            background-color: #f8f9fc;
        }
        
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
        }
        
        .main-content {
            width: 100%;
      
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            .main-content {
                width: 100%;
            }
            #sidebarCollapse span {
                display: none;
            }
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.35rem;
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }
        
        .card-body {
            padding: 0;
        }
        
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        #dataTable {
            width: 100%;
            margin-bottom: 0;
            color: #6e707e;
        }
        
        #dataTable th {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e3e6f0;
            background-color: #f8f9fc;
            color: #4e73df;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.1rem;
        }
        
        #dataTable td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e3e6f0;
        }
        
        #dataTable tbody tr:hover {
            background-color: #f6f9ff;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        
        .form-control-sm {
            height: calc(1.5em + 0.5rem + 2px);
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        
        .input-group {
            width: auto;
        }
        
        .gap-2 {
            gap: 0.5rem;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require './views/admin/Partials/sidebar.php' ?>
        
        <!-- Main Content -->
        <div id="content" class="main-content">
            <?php require './views/admin/Partials/navbar.php' ?>
            
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Customers List</h6>
                        <div class="d-flex flex-column flex-md-row gap-2 mt-2 mt-md-0">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Search..." id="searchInput">
                                <button class="btn btn-primary btn-sm" type="button" id="searchButton">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <a href="/admin/users/create" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i> Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No customers found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($users as $index => $user): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <img src="<?= htmlspecialchars($user['image']) ?>" alt="User Image" class="user-avatar">
                                                </td>
                                                <td class="name-user"><?= htmlspecialchars($user['name']) ?></td>
                                                <td class="phone-user"><?= htmlspecialchars($user['phone']) ?></td>
                                                <td class="email-user"><?= htmlspecialchars($user['email']) ?></td>
                                                <td class="role-user"><?= htmlspecialchars($user['role']) ?></td>
                                                <td class="address-user"><?= htmlspecialchars($user['address']) ?></td>
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

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
    <!-- jQuery -->
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
                $('tbody tr').each(function() {
                    const $row = $(this);
                    if ($row.find('td').text().toLowerCase().indexOf(value) > -1) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            }
        });
    </script>
</body>
</html>