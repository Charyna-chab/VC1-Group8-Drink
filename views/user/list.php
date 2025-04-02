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
</head>

</head>

<body>


    <!-- Main Content -->
    <div class="main-content">
        <!-- Sidebar -->
        <div class="sidebar text-dark">
            <?php require '../admin/Partials/sidebar.php' ?>

        </div>
        <div class="container-fluid mt-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Customers List</h6>
                    <a href="/user/create" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add New
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th colspan="7">
                                        <div class="d-flex justify-content-end">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" placeholder="Search..." id="searchInput">
                                                <button class="btn btn-primary btn-sm" type="button" id="searchButton">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
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
                                                <img src="<?= htmlspecialchars($user['image']) ?>"
                                                    onerror="this.src='https://via.placeholder.com/50?text=User'"
                                                    alt="User Image">
                                            </td>
                                            <td class="name-user"><?= htmlspecialchars($user['name']) ?></td>
                                            <td class="phone-user"><?= htmlspecialchars($user['phone']) ?></td>
                                            <td class="email-user"><?= htmlspecialchars($user['email']) ?></td>
                                            <td class="address-user"><?= htmlspecialchars($user['address']) ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="/user/edit?id=<?= $user['user_id'] ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['user_id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?= $user['user_id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete <?= htmlspecialchars($user['name']) ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <a href="/user/delete?id=<?= $user['user_id'] ?>" class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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