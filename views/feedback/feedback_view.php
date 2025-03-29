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
                        <div>
                            <button class="btn btn-sm" style="background-color: #E91E63; color: white;">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header py-3 bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold" style="color: #E91E63;">Feedback Management</h3>
                            <p class="text-muted mb-0">Total entries: <?php echo count($feedbackEntries); ?></p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-sync-alt me-1"></i> Refresh
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-sort me-1"></i> Sort
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item" href="#">Newest First</a></li>
                                    <li><a class="dropdown-item" href="#">Oldest First</a></li>
                                    <li><a class="dropdown-item" href="#">Customer Name (A-Z)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                                        placeholder="Search by customer name..." 
                                        value="<?php echo htmlspecialchars($nameFilter); ?>"
                                    >
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
                                        value="<?php echo htmlspecialchars($dateFilter); ?>"
                                    >
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn" style="background-color: #E91E63; color: white;">
                                        <i class="fas fa-filter me-1"></i> Apply Filters
                                    </button>
                                    <?php if (!empty($dateFilter) || !empty($nameFilter)): ?>
                                        <a href="feedback" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Clear
                                        </a>
                                    <?php endif; ?>
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
                <th scope="col" class="fw-bold text-black">Date</th>
                <th scope="col" class="fw-bold text-black">Feedback</th>
                <th scope="col" class="fw-bold text-black">Rating</th>
                <th scope="col" class="fw-bold text-black">Status</th>
                <th scope="col" class="fw-bold text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($feedbackEntries) > 0): ?>
                <?php foreach ($feedbackEntries as $index => $feedback): ?>
                    <?php 
                        // Generate random rating and status for demo
                        $rating = isset($feedback['rating']) ? $feedback['rating'] : rand(1, 5);
                        $statuses = ['New', 'Reviewed', 'Responded', 'Closed'];
                        $status = isset($feedback['status']) ? $feedback['status'] : $statuses[array_rand($statuses)];
                        $statusClass = [
                            'New' => 'bg-info',
                            'Reviewed' => 'bg-warning',
                            'Responded' => 'bg-success',
                            'Closed' => 'bg-secondary'
                        ];
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-2" style="background-color: #E91E63; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                    <?php echo substr($feedback['customer_name'], 0, 1); ?>
                                </div>
                                <div>
                                    <div class="fw-bold"><?php echo htmlspecialchars($feedback['customer_name']); ?></div>
                                    <div class="small text-muted">
                                        <?php echo ($feedback['customer_name'] === 'Guest') ? 'Anonymous User' : 'Registered Customer'; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div><?php echo date('M d, Y', strtotime($feedback['created_at'])); ?></div>
                            <small class="text-muted"><?php echo date('h:i A', strtotime($feedback['created_at'])); ?></small>
                        </td>
                        <td>
                            <div class="feedback-text text-truncate" style="max-width: 200px;" title="<?php echo htmlspecialchars($feedback['message']); ?>">
                                <?php echo htmlspecialchars($feedback['message']); ?>
                            </div>
                        </td>
                        <td>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $rating): ?>
                                        <i class="fas fa-star" style="color: #FFD700;"></i>
                                    <?php else: ?>
                                        <i class="far fa-star" style="color: #FFD700;"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?php echo $statusClass[$status]; ?>"><?php echo $status; ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="view_feedback?id=<?php echo $feedback['id']; ?>" class="btn btn-sm btn-outline-secondary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="reply_feedback?id=<?php echo $feedback['id']; ?>" class="btn btn-sm btn-outline-primary" title="Reply">
                                    <i class="fas fa-reply"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" title="Delete" onclick="confirmDelete(<?php echo $feedback['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-comment-slash fa-3x mb-3" style="color: #E91E63;"></i>
                            <h5>No Feedback Found</h5>
                            <p class="text-muted">No feedback entries match your current filters.</p>
                            <?php if (!empty($dateFilter) || !empty($nameFilter)): ?>
                                <a href="feedback" class="btn btn-sm" style="background-color: #E91E63; color: white;">
                                    Clear Filters
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add this JavaScript function at the bottom of your page or in a separate JS file -->
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this feedback?')) {
        window.location.href = 'delete_feedback?id=' + id;
    }
}
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const nameSearchInput = document.querySelector('input[name="name"]');
    const feedbackRows = document.querySelectorAll('tbody tr');
    const emptyStateRow = document.querySelector('tbody tr[colspan]');
    
    // Function to filter and highlight rows
    function filterFeedback() {
        const searchTerm = nameSearchInput.value.toLowerCase().trim();
        let hasMatches = false;
        
        // Check if searching for "vanda"
        if (searchTerm === 'vanda') {
            alert("Showing feedback from user: Vanda");
        }
        
        feedbackRows.forEach(row => {
            if (row === emptyStateRow) return;
            
            const customerNameCell = row.querySelector('td:first-child');
            const customerName = customerNameCell.textContent.toLowerCase();
            
            if (customerName.includes(searchTerm)) {
                row.style.display = '';
                hasMatches = true;
                
                // Highlight matching text if needed
                if (searchTerm && customerName.includes(searchTerm)) {
                    const nameElement = customerNameCell.querySelector('.fw-bold');
                    if (nameElement) {
                        const originalText = nameElement.textContent;
                        const regex = new RegExp(searchTerm, 'gi');
                        nameElement.innerHTML = originalText.replace(regex, 
                            match => `<span class="highlight" style="background-color: #FFEB3B;">${match}</span>`);
                    }
                }
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show/hide empty state
        if (emptyStateRow) {
            emptyStateRow.style.display = hasMatches || !searchTerm ? 'none' : '';
        }
    }
    
    // Initial filter on page load if there's a search term
    if (nameSearchInput.value) {
        filterFeedback();
    }
    
    // Add event listeners
    nameSearchInput.addEventListener('input', function() {
        filterFeedback();
    });
    
    // Clear highlights when search is cleared
    nameSearchInput.addEventListener('search', function() {
        if (!this.value) {
            document.querySelectorAll('.highlight').forEach(el => {
                el.outerHTML = el.textContent;
            });
            filterFeedback();
        }
    });
    
    // Optional: Add debounce for better performance
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }
    
    // Apply debounced version (300ms delay)
    nameSearchInput.addEventListener('input', debounce(filterFeedback, 300));
});
</script>
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

