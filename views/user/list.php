<link rel="stylesheet" href="/assets/css/sidebar.css">
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
        margin-left: 250px;
        /* Adjust this to match your sidebar width */
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

<?php require './views/admin/Partials/header.php' ?>

<body>
    <div id="wrapper">
        <?php require './views/admin/Partials/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require './views/admin/Partials/navbar.php' ?>

                <div class="container-fluid">
                    <?php if (isset($error)): ?>
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
                                <a href="/admin/users/create" class="btn btn-success" style="width: 150px">
                                    <i class="fas fa-plus text-white"></i> Add User
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($users)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No users found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($users as $index => $user): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <div style="display: inline-block; width: 60px; height: 60px; border-radius: 100%; overflow: hidden;">
                                                            <?php if (!empty($user['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $user['image'])): ?>
                                                                <img src="/<?= htmlspecialchars($user['image']) ?>"
                                                                    style="width: 100%; height: 100%; object-fit: cover;"
                                                                    alt="User Image">
                                                            <?php else: ?>
                                                                <img src="/assets/images/default-user.png"
                                                                    style="width: 100%; height: 100%; object-fit: cover;"
                                                                    alt="Default User">
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="user-name"><?php echo htmlspecialchars($user['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                                    <td>
                                                        <span class="badge <?php echo $user['role'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                                                            <?php echo ucfirst(htmlspecialchars($user['role'] ?? 'user')); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#users<?= $user['user_id'] ?>">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Place the modal HTML right here, after the closing </tr> tag -->
                                                <div class="modal fade" id="users<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete <?= htmlspecialchars($user['name']) ?>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="/admin/users/delete" method="POST">
                                                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
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
                filterTable();
            });

            function filterTable() {
                const searchTerm = $('#searchInput').val().toLowerCase().trim();
                
                if (searchTerm === '') {
                    // Show all rows if search is empty
                    $('#userTable tbody tr').show();
                    return;
                }
                
                $('#userTable tbody tr').each(function() {
                    const $row = $(this);
                    const userName = $row.find('.user-name').text().toLowerCase();
                    
                    // Check if the name contains the search term
                    if (userName.includes(searchTerm)) {
                        $row.show();
                        
                        // If the name matches exactly, move it to the top
                        if (userName === searchTerm) {
                            $row.prependTo($('#userTable tbody'));
                        }
                    } else {
                        $row.hide();
                    }
                });
            }
        });
    </script>
</body>
</html>