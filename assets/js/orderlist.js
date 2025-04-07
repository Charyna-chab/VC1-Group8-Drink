document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable if jQuery and DataTables are available
    if (typeof $ !== 'undefined' && typeof $.fn.DataTable !== 'undefined') {
        $('#orderTable').DataTable({
            "order": [[0, "desc"]], // Sort by order ID descending by default
            "pageLength": 25,
            "responsive": true,
            "language": {
                "emptyTable": "No orders found",
                "zeroRecords": "No matching orders found"
            }
        });
    }
    
    // Status filter functionality
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value.toLowerCase();
            const table = document.getElementById('orderTable');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(5)');
                if (!statusCell) return;
                
                const rowStatus = statusCell.textContent.trim().toLowerCase();
                
                if (status === 'all' || rowStatus === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Auto-submit status change (optional feature)
    const autoSubmitSelects = document.querySelectorAll('.auto-submit');
    autoSubmitSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
    
    // Add confirmation for delete buttons
    const deleteForms = document.querySelectorAll('form[action="/delete-order"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
});