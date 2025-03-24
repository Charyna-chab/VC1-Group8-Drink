document.addEventListener("DOMContentLoaded", () => {
    // Search functionality
    const searchBtn = document.getElementById("searchBtn")
    const locationSearch = document.getElementById("locationSearch")
  
    searchBtn.addEventListener("click", () => {
      const searchTerm = locationSearch.value.trim()
  
      if (searchTerm === "") {
        alert("Please enter a city or zip code")
        return
      }
  
      // Here you would normally search for locations via AJAX
      // For now, just simulate the action
      alert(`Searching for locations near: ${searchTerm}`)
    })
  
    // Get directions functionality
    const directionButtons = document.querySelectorAll(".btn-directions")
  
    directionButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault()
  
        const locationCard = this.closest(".location-card")
        const locationName = locationCard.querySelector("h3").textContent
        const locationAddress = locationCard
          .querySelector(".location-info p:first-of-type")
          .textContent.replace("📍", "")
          .trim()
  
        // Open Google Maps in a new tab
        const mapsUrl = `https://www.google.com/maps/search/${encodeURIComponent(locationAddress)}`
        window.open(mapsUrl, "_blank")
      })
    })
  
    // Order online functionality
    const orderButtons = document.querySelectorAll(".btn-order")
  
    orderButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault()
  
        const locationCard = this.closest(".location-card")
        const locationName = locationCard.querySelector("h3").textContent
  
        // Redirect to order page with location parameter
        window.location.href = `/order?location=${encodeURIComponent(locationName)}`
      })
    })
  
    // Map placeholder - in a real implementation, you would initialize a Google Map here
    const mapPlaceholder = document.querySelector(".map-placeholder")
    if (mapPlaceholder) {
      mapPlaceholder.addEventListener("click", () => {
        alert("Interactive map coming soon!")
      })
    }
  })
  
  