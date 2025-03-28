<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold" style="color: #E91E63;">Customer Feedback</h2>
                            <p class="text-muted mb-0">View and manage all customer feedback submissions</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0">

            </div>

            <div class="card-body bg-white">
                <!-- Filters -->
                <div class="mb-4 p-3 rounded" style="background-color: #FCE4EC;">
                    <form action="" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-black">Customer Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search" style="color: #E91E63;"></i>
                                </span>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control border-start-0"
                                    placeholder="Search by customer name...">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-black">Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-calendar-alt" style="color: #E91E63;"></i>
                                </span>
                                <input
                                    type="date"
                                    name="date"
                                    class="form-control border-start-0"
                                    value="<?php echo htmlspecialchars($dateFilter); ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <a href="../feedback_view.php"> <button class="btn" style="background-color: #E91E63; color: white;">
                                        <i class="fas fa-plus-circle me-1"></i> Add New Feedback
                                    </button>
                                </a>

                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr style="background-color: #FCE4EC;">
                                <th scope="col" class="fw-bold text-black">Customer</th>
                                <th scope="col" class="fw-bold text-black">Feedback</th>
                                <th scope="col" class="fw-bold text-black">Date</th>
                                <th scope="col" class="fw-bold text-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->

            </div>
        </div>
    </div>
</div>
</div>

<style>
    /* Custom styles */
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

    .feedback-text {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .feedback-text:hover {
        white-space: normal;
        max-width: 300px;
        overflow: visible;
        cursor: pointer;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    /* Pink theme button hover effect */
    .btn[style*="background-color: #E91E63"]:hover {
        background-color: #D81B60 !important;
        transition: background-color 0.2s ease;
    }

    /* Table hover effect */
    .table tr:hover {
        background-color: #FCE4EC;
        transition: background-color 0.2s ease;
    }
</style>