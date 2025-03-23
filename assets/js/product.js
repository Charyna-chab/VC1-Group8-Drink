// Product Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Handle delete product functionality
    setupDeleteProduct();
    
    // Setup real-time dashboard updates if we're on the dashboard page
    if (document.getElementById('monthly-earnings')) {
        setupDashboardUpdates();
    }
    
    // Setup search functionality if we're on the product list page
    if (document.querySelector('input[placeholder="Search..."]')) {
        setupProductSearch();
    }
});

/**
 * Setup delete product functionality with confirmation
 */
function setupDeleteProduct() {
    const deleteButtons = document.querySelectorAll('.delete-product');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-id');
            const confirmDelete = confirm('Are you sure you want to delete this product?');
            
            if (confirmDelete) {
                // Send AJAX request to delete the product
                fetch(`/product/delete?id=${productId}`, {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        this.closest('tr').remove();
                        
                        // Update dashboard stats if we're on the dashboard
                        if (document.getElementById('product-count')) {
                            updateDashboardStats();
                        }
                        
                        alert('Product deleted successfully!');
                    } else {
                        alert('Error deleting product: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the product.');
                });
            }
        });
    });
}

/**
 * Setup dashboard updates
 */
function setupDashboardUpdates() {
    // Initial update
    updateDashboardStats();
    
    // Set interval to update stats every 30 seconds
    setInterval(updateDashboardStats, 30000);
}

/**
 * Update dashboard statistics via AJAX
 */
function updateDashboardStats() {
    fetch('/api/dashboard-stats.php')
        .then(response => response.json())
        .then(data => {
            // Update product count
            const productCountElement = document.getElementById('product-count');
            if (productCountElement) {
                productCountElement.textContent = data.product_count;
            }
            
            // Update product progress bar
            const productProgressElement = document.getElementById('product-progress');
            if (productProgressElement) {
                const percentage = Math.min(100, (data.product_count / 100) * 100);
                productProgressElement.style.width = `${percentage}%`;
                productProgressElement.setAttribute('aria-valuenow', percentage);
            }
            
            // Update monthly earnings
            const monthlyEarningsElement = document.getElementById('monthly-earnings');
            if (monthlyEarningsElement) {
                monthlyEarningsElement.textContent = `$${formatNumber(data.monthly_earnings)}`;
            }
            
            // Update annual earnings
            const annualEarningsElement = document.getElementById('annual-earnings');
            if (annualEarningsElement) {
                annualEarningsElement.textContent = `$${formatNumber(data.annual_earnings)}`;
            }
            
            // Update pending requests
            const pendingRequestsElement = document.getElementById('pending-requests');
            if (pendingRequestsElement) {
                pendingRequestsElement.textContent = data.pending_requests;
            }
            
            // Update charts if needed
            updateCharts(data);
        })
        .catch(error => {
            console.error('Error updating dashboard stats:', error);
        });
}

/**
 * Update charts with new data
 */
function updateCharts(data) {
    // Update area chart if it exists
    if (window.myAreaChart && data.monthly_data) {
        window.myAreaChart.data.datasets[0].data = data.monthly_data;
        window.myAreaChart.update();
    }
    
    // Update pie chart if it exists
    if (window.myPieChart && data.revenue_sources) {
        window.myPieChart.data.datasets[0].data = [
            data.revenue_sources.direct,
            data.revenue_sources.social,
            data.revenue_sources.referral
        ];
        window.myPieChart.update();
    }
}

/**
 * Format number with commas for thousands
 */
function formatNumber(number) {
    return parseFloat(number).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

/**
 * Setup product search functionality
 */
function setupProductSearch() {
    const searchInput = document.querySelector('input[placeholder="Search..."]');
    const tableBody = document.querySelector('tbody');
    
    // Store the original order of rows
    const originalRows = Array.from(tableBody.querySelectorAll('tr'));
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            // If search is empty, restore original order
            restoreOriginalOrder();
            return;
        }
        
        // Create an array to hold rows and their match scores
        const rowsWithScores = [];
        
        originalRows.forEach(row => {
            const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const productName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const productDetail = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const price = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
            
            // Calculate match score (higher is better match)
            let score = 0;
            
            // Exact matches get highest score
            if (id === searchTerm) score += 100;
            if (productName === searchTerm) score += 100;
            if (productDetail === searchTerm) score += 100;
            if (price === searchTerm) score += 100;
            
            // Partial matches get lower scores
            if (id.includes(searchTerm)) score += 50;
            if (productName.includes(searchTerm)) score += 50;
            if (productDetail.includes(searchTerm)) score += 30;
            if (price.includes(searchTerm)) score += 40;
            
            // Add row to array with its score
            rowsWithScores.push({ row, score });
        });
        
        // Sort rows by score (highest first)
        rowsWithScores.sort((a, b) => b.score - a.score);
        
        // Clear the table
        tableBody.innerHTML = '';
        
        // Add rows back in sorted order, hiding non-matching rows
        rowsWithScores.forEach(item => {
            if (item.score > 0) {
                // Highlight the matching row
                item.row.style.display = '';
                item.row.style.backgroundColor = '#f0f8ff'; // Light blue highlight
                
                // After a short delay, remove the highlight
                setTimeout(() => {
                    item.row.style.backgroundColor = '';
                }, 2000);
                
                tableBody.appendChild(item.row);
            } else {
                // Hide non-matching rows
                item.row.style.display = 'none';
                tableBody.appendChild(item.row);
            }
        });
    });
    
    // Function to restore original order
    function restoreOriginalOrder() {
        tableBody.innerHTML = '';
        originalRows.forEach(row => {
            row.style.display = '';
            row.style.backgroundColor = '';
            tableBody.appendChild(row);
        });
    }
    
    // Add event listener for the search button
    const searchButton = document.querySelector('.input-group-append button');
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            // Trigger the keyup event on the search input
            const event = new Event('keyup');
            searchInput.dispatchEvent(event);
        });
    }
}