// Set active class based on current URL
document.addEventListener('DOMContentLoaded', function() {
    // Get current page URL
    const currentUrl = window.location.pathname;
    console.log("Current URL:", currentUrl); // Debug log

    // Find all sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-item .nav-link');

    // Loop through links and add active class if URL matches
    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        console.log("Checking link:", href); // Debug log

        // Check if current URL matches or starts with the link's href
        if (currentUrl === href || currentUrl.startsWith(href + '/')) {
            console.log("Match found for:", href); // Debug log
            link.classList.add('active');
            link.classList.remove('collapsed'); // Remove collapsed class if present
            link.closest('.nav-item').classList.add('active');

            // If this is the customers page, add data attribute to body
            if (href === '/admin/users' || currentUrl.includes('/admin/users')) {
                document.body.setAttribute('data-page', 'customers');
                console.log("Set customers page attribute"); // Debug log
            }
        }
    });

    // Special case for customers page - more aggressive approach
    if (currentUrl.includes('/admin/users')) {
        document.body.setAttribute('data-page', 'customers');

        // Directly target the customers link and add active class
        const customersLink = document.querySelector('.sidebar .nav-item a[href="/admin/users"]');
        if (customersLink) {
            customersLink.classList.add('active');
            customersLink.classList.remove('collapsed');
            customersLink.closest('.nav-item').classList.add('active');
            console.log("Directly activated customers link"); // Debug log
        }
    }
});