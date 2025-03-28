// Custom alert function to replace the default browser alert
function customAlert(message) {
    // Create overlay
    const overlay = document.createElement("div")
    overlay.className = "alert-overlay"

    // Create alert box
    const alertBox = document.createElement("div")
    alertBox.className = "alert-box"

    // Add content
    alertBox.innerHTML = `
          <h3>Payment Notification</h3>
          <p>${message}</p>
          <button id="alert-ok">OK</button>
      `

    // Add to DOM
    overlay.appendChild(alertBox)
    document.body.appendChild(overlay)

    // Add event listener to OK button
    document.getElementById("alert-ok").addEventListener("click", () => {
        overlay.remove()
    })

    // Also close when clicking outside the alert box
    overlay.addEventListener("click", (e) => {
        if (e.target === overlay) {
            overlay.remove()
        }
    })
}

// Override the default alert function
window.originalAlert = window.alert
window.alert = customAlert