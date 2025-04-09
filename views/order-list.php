<?php
require_once __DIR__ . '/admin/Partials/header.php';

?>
<div id="wrapper">
    <?php require_once __DIR__ . '/admin/Partials/sidebar.php'; ?>

    <div id="content" class="bg-white"> <!-- Changed to bg-white -->
        <?php require './views/admin/Partials/navbar.php' ?>
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Order List</h1>
            <section class="content">
                <div class="order-list-container">
                    <div class="order-list-header">
                        <h2>Order List</h2>
                        <a href="/admin/order/create" class="btn-create">
                            <i class="fas fa-plus"></i> Create New Order
                        </a>
                    </div>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                            <?php unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="order-list-filters">
                        <form action="/admin/orders" method="GET" class="filter-form">
                            <div class="form-group">
                                <label for="date_from">From Date:</label>
                                <input type="date" id="date_from" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_to">To Date:</label>
                                <input type="date" id="date_to" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
                            </div>
                            <button type="submit" class="btn-filter">Filter</button>
                            <a href="/admin/orders" class="btn-reset">Reset</a>
                        </form>
                    </div>

                    <div class="order-list-content">
                        <?php if (!empty($orders)): ?>
                            <table class="order-list-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                                            <td><?= htmlspecialchars($order['user_id']) ?></td>
                                            <td>
                                                <?php
                                                if (isset($products[$order['product_id']])) {
                                                    echo htmlspecialchars($products[$order['product_id']]['product_name']);
                                                } else {
                                                    echo 'Product #' . htmlspecialchars($order['product_id']);
                                                }
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($order['drink_size']) ?></td>
                                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                                            <td class="actions">
                                                <a href="/admin/order/details/<?= $order['order_id'] ?>" class="btn-view">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/order/edit/<?= $order['order_id'] ?>" class="btn-edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="/admin/order/delete/<?= $order['order_id'] ?>" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                    <button type="submit" class="btn-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <?php if ($totalPages > 1): ?>
                                <div class="pagination">
                                    <?php if ($currentPage > 1): ?>
                                        <a href="?page=<?= $currentPage - 1 ?>" class="page-link">&laquo; Previous</a>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <a href="?page=<?= $i ?>" class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <a href="?page=<?= $currentPage + 1 ?>" class="page-link">Next &raquo;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="no-data">
                                <p>No orders found.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <style>
        /* Order List Page CSS */
        .order-list-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .order-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .order-list-header h2 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        .btn-create {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-create i {
            margin-right: 5px;
        }

        .order-list-filters {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
        }

        .form-group input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-filter {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-reset {
            background-color: #f1f1f1;
            color: #333;
            border: 1px solid #ddd;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .order-list-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .order-list-table th,
        .order-list-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-list-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #333;
        }

        .order-list-table tr:hover {
            background-color: #f9f9f9;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-view,
        .btn-edit,
        .btn-delete {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-view {
            background-color: #2196F3;
            color: white;
        }

        .btn-edit {
            background-color: #FFC107;
            color: white;
        }

        .btn-delete {
            background-color: #F44336;
            color: white;
            border: none;
        }

        .delete-form {
            margin: 0;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }

        .page-link {
            padding: 8px 12px;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }

        .page-link.active {
            background-color: #2196F3;
            color: white;
            border-color: #2196F3;
        }

        .page-link:hover:not(.active) {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>