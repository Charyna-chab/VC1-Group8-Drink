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
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar styling */
        #accordionSidebar {
            width: 250px;
            min-height: 100vh;
            background: white;
            transition: all 0.3s;
            position: fixed;
            z-index: 1000;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .sidebar-brand-text {
            font-size: 1.2rem;
            font-weight: 800;
        }

        .sidebar-divider {
            margin: 10px 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .nav-item {
            margin: 5px 0;
        }

        .nav-link {
            padding: 10px 15px;
            color: #333;
            border-radius: 5px;
            margin: 0 10px;
        }

        .nav-link:hover {
            background-color: #f8f9fa;
        }

        .nav-link.active {
            background-color: #4e73df;
            color: white !important;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main content styling */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
            transition: all 0.3s;
        }

        /* Card styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 10px 10px 0 0 !important;
        }

        /* Table styling */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom-width: 1px;
            font-weight: 600;
            color: #4e73df;
            vertical-align: middle;
        }

        .table td,
        .table th {
            padding: 12px 15px;
            vertical-align: middle;
        }



        /* Button styling */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #3a5bc7;
            border-color: #3a5bc7;
        }

        /* Search input styling */
        .input-group {
            width: 250px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #accordionSidebar {
                margin-left: -250px;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .input-group {
                width: 100% !important;
                margin-top: 10px;
            }

            #accordionSidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <?php $users = $users ?? []; ?>
    <?php require './views/admin/Partials/sidebar.php' ?>
    <?php require './views/admin/Partials/navbar.php' ?>


    <!-- Main Content -->
    <div class="main-content">
        <!-- Content Area -->
        <div class="content-wrapper">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Customers List</h6>
                    <div class="d-flex flex-column flex-md-row gap-2 mt-2 mt-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" placeholder="Search..." id="searchInput">
                            <button class="btn btn-primary btn-sm mr-10" type="button" id="searchButton">
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
                                                <img src="<?= htmlspecialchars($user['image']) ?>">
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

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

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