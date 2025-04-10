<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Product List'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/sidebar.css">

    <style>
        body {
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
        }

        #content {
            width: 100%;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
        }

        .dropdown-toggle::after {
            display: none;
        }

        /* Search Container Styles - Bigger and Right-Aligned */
        .search-container {
            position: relative;
            width: 100%;
            max-width: 350px;
            /* Increased from 400px */
            margin-left: auto;
            /* This pushes it to the right */
            margin-right: 0;
            /* Removes right margin */
        }

        .search-container .input-group {
            display: flex;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            /* Stronger shadow */
            border-radius: 30px;
            /* More rounded */
            overflow: hidden;
            transition: all 0.3s ease;
            height: 40px;
            /* Fixed height for bigger size */
        }

        .search-container .input-group:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            /* Stronger hover shadow */
        }

        /* Search Input Styles - Bigger */
        .search-container #searchInput {
            flex: 1;
            border: none;
            padding: 12px 25px;
            /* Increased padding */
            font-size: 16px;
            /* Larger font */
            background-color: #f8f9fc;
            color: #333;
            outline: none;
            height: 100%;
            /* Takes full height of container */
        }

        .search-container #searchInput::placeholder {
            color: #9a9a9a;
            font-weight: 300;
            font-size: 15px;
            /* Larger placeholder */
        }

        .search-container #searchInput:focus {
            background-color: #fff;
            box-shadow: inset 0 0 0 2px #4e73df;
            /* Thicker focus border */
        }

        /* Search Button Styles - Bigger */
        .search-container #searchButton {
            border: none;
            background-color: #4e73df;
            color: white;
            padding: 0 25px;
            /* Wider button */
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 60px;
            /* Minimum button width */
        }

        .search-container #searchButton:hover {
            background-color: #2e59d9;
        }

        .search-container #searchButton i {
            font-size: 20px;
            /* Larger icon */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .search-container {
                max-width: 100%;
            }

            .search-container #searchInput {
                padding: 10px 20px;
                font-size: 15px;
            }

            .search-container #searchButton {
                padding: 0 20px;
                min-width: 50px;
            }

            .search-container #searchButton i {
                font-size: 18px;
            }
        }

        /* Highlight for search results */
        .highlight-match {
            background-color: #fffde7;
            font-weight: bold;
            padding: 3px 5px;
            /* Slightly bigger highlight */
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                width: 100%;
            }

            .search-container {
                width: 100%;
            }
        }
    </style>
</head>
<div id="wrapper">
    <?php require_once __DIR__ . '/admin/Partials/sidebar.php'; ?>

    <div id="content">
        <?php require_once __DIR__ . '/admin/Partials/navbar.php'; ?>

        <div class="container-fluid">
            <div class="order-list-container">
                <div class="order-list-header">
                    <h2>User Order List</h2>
                </div>

                <table class="order-list-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Product Name</th>
                            <th>Drink Size</th>
                            <th>Price</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['order_id']); ?></td>
                                    <td><?= htmlspecialchars($order['customer_name']); ?></td>
                                    <td><?= htmlspecialchars($order['customer_email']); ?></td>
                                    <td><?= htmlspecialchars($order['product_name']); ?></td>
                                    <td><?= htmlspecialchars($order['drink_size']); ?></td>
                                    <td>$<?= number_format($order['product_price'], 2); ?></td>
                                    <td><?= htmlspecialchars($order['order_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="no-data">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for Icons (if not already included) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Your existing CSS styling stays the same -->

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