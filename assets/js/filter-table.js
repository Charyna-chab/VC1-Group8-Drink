document.addEventListener("DOMContentLoaded", () => {
    // Get the search input element
    const searchInput = document.getElementById("searchInput")

    // Add event listener for input changes
    if (searchInput) {
        searchInput.addEventListener("keyup", () => {
            filterTable()
        })

        // Get the search button
        const searchButton = document.getElementById("searchButton")
        if (searchButton) {
            searchButton.addEventListener("click", () => {
                filterTable()
            })
        }
    }

    // Function to filter the table
    function filterTable() {
        // Get the input value and convert to lowercase
        const filterValue = searchInput.value.toLowerCase()

        // Get the table and rows
        const table = document.getElementById("userTable")
        if (!table) return

        const rows = table.getElementsByTagName("tr")

        // Loop through all table rows, starting from index 1 to skip the header
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i]
            let shouldShow = false

            // Get all cells in the row
            const cells = row.getElementsByTagName("td")

            // Loop through all cells
            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j]

                // If the cell content includes the filter value, show the row
                if (cell.textContent.toLowerCase().includes(filterValue)) {
                    shouldShow = true
                    break
                }
            }

            // Set the display style based on whether the row should be shown
            row.style.display = shouldShow ? "" : "none"
        }
    }
})