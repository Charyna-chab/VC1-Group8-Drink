<div class="page-header">
    <h2>Customer Feedback</h2>
    <p>View and manage all customer feedback submissions</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>Feedback Management</h3>
        <p>Browse through customer feedback sorted from newest to oldest.</p>
    </div>
    
    <div class="card-content">
        <div class="filters">
            <form action="" method="GET" class="filter-form">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input 
                        type="text" 
                        name="name" 
                        placeholder="Search by customer name..." 
                        value="<?php echo htmlspecialchars($nameFilter); ?>"
                    >
                </div>
                
                <div class="date-filter">
                    <input 
                        type="date" 
                        name="date" 
                        value="<?php echo htmlspecialchars($dateFilter); ?>"
                    >
                    <label for="date">Filter by date</label>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <?php if (!empty($dateFilter) || !empty($nameFilter)): ?>
                        <a href="feedback.php" class="btn btn-secondary">Clear Filters</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($feedbackEntries) > 0): ?>
                        <?php foreach ($feedbackEntries as $feedback): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($feedback['customer_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($feedback['created_at'])); ?></td>
                                <td><?php echo htmlspecialchars($feedback['message']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="no-results">No feedback found matching your filters.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

