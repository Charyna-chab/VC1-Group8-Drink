
// Enhanced order.js with improved functionality
document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const categoryButtons = document.querySelectorAll(".category-btn")
  const productCards = document.querySelectorAll(".product-card")

  const searchInput = document.getElementById("productSearch")
  const orderButtons = document.querySelectorAll(".order-btn")
  const orderPanel = document.getElementById("orderPanel")
  const closeBtn = document.querySelector(".order-panel .close-btn")
  const overlay = document.getElementById("overlay") || createOverlay()
  const noProductMessage = document.getElementById("no-product-message")
  const addToCartBtn = document.querySelector(".add-to-cart-btn")
  const confirmBtn = document.querySelector(".confirm-btn")




  console.log("Order elements:", {
    categoryButtons: categoryButtons.length,
    productCards: productCards.length,
    searchInput: !!searchInput,
    orderButtons: orderButtons.length,
    orderPanel: !!orderPanel,
    closeBtn: !!closeBtn,
    overlay: !!overlay,
    noProductMessage: !!noProductMessage,
    addToCartBtn: !!addToCartBtn,
    confirmBtn: !!confirmBtn,
  })

  // Create overlay if it doesn't exist
  function createOverlay() {
    const overlayElement = document.createElement("div")
    overlayElement.id = "overlay"
    document.body.appendChild(overlayElement)
    return overlayElement
  }

  // Form Elements
  const drinkSizeSelect = document.getElementById("drinkSize")
  const sugarLevelSelect = document.getElementById("sugarLevel")
  const iceLevelSelect = document.getElementById("iceLevel")
  const toppingCheckboxes = document.querySelectorAll('#toppings input[type="checkbox"]')
  const productImage = document.getElementById("productImage")
  const productName = document.getElementById("productName")
  const productPrice = document.getElementById("productPrice")
  const quantityInput = document.getElementById("quantity")


  // Create toast container if it doesn't exist
  let toastContainer = document.getElementById("toastContainer");
  if (!toastContainer) {
    toastContainer = document.createElement("div");
    toastContainer.id = "toastContainer";
    toastContainer.className = "toast-container";
    document.body.appendChild(toastContainer);
  }

  // Current product data
  const currentProduct = {
    id: null,
    name: "",
    price: 0,
    image: "",
    size: "small",
    sugar: "no",
    toppings: [],
  };

  // Filter products by category
  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Remove active class from all buttons
      categoryButtons.forEach((btn) => btn.classList.remove("active"));

      // Add active class to clicked button
      this.classList.add("active");

      const category = this.getAttribute("data-category");

      // Filter products
      productCards.forEach((card) => {
        if (category === "all" || card.getAttribute("data-category") === category) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  });

  // Search functionality
  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase().trim();

    productCards.forEach((card) => {
      const productName = card.querySelector("h3").textContent.toLowerCase();
      const productDescription = card.querySelector("p").textContent.toLowerCase();

      if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });

  // Open order panel
  orderButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const productCard = this.closest(".product-card");
      currentProduct.id = this.getAttribute("data-product-id");
      currentProduct.name = productCard.querySelector("h3").textContent;
      currentProduct.price = Number.parseFloat(productCard.querySelector(".product-price").textContent.replace("$", ""));
      currentProduct.image = productCard.querySelector(".product-image img").src;

      // Update order panel with product details
      document.getElementById("productImage").src = currentProduct.image;
      document.getElementById("productName").textContent = currentProduct.name;
      document.getElementById("productPrice").textContent = "$" + currentProduct.price.toFixed(2);
      document.getElementById("basePrice").textContent = "$" + currentProduct.price.toFixed(2);

      // Reset form
      drinkSizeSelect.selectedIndex = 0;
      sugarLevelSelect.selectedIndex = 0;
      toppingCheckboxes.forEach((checkbox) => (checkbox.checked = false));

      // Update total price
      updateTotalPrice();

      // Show order panel and overlay
      orderPanel.classList.add("active");
      overlay.classList.add("active");
    });
  });

  // Close order panel
  closeBtn.addEventListener("click", closeOrderPanel);
  overlay.addEventListener("click", closeOrderPanel);

  function closeOrderPanel() {
    orderPanel.classList.remove("active");
    overlay.classList.remove("active");
  }

  // Update price when options change
  drinkSizeSelect.addEventListener("change", function () {
    currentProduct.size = this.value;
    updateTotalPrice();
  });

  sugarLevelSelect.addEventListener("change", function () {
    currentProduct.sugar = this.value;
  });

  toppingCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
      updateToppings();
      updateTotalPrice();
    });
  });

  // Update toppings array
  function updateToppings() {
    currentProduct.toppings = [];
    toppingCheckboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        currentProduct.toppings.push({
          name: checkbox.value,
          price: Number.parseFloat(checkbox.getAttribute("data-price")),
        });
      }
    });
  }

  // Calculate and update total price
  function updateTotalPrice() {
    // Base price
    const basePrice = currentProduct.price;

    // Size price
    let sizePrice = 0;
    if (currentProduct.size === "medium") {
      sizePrice = 0.5;
    } else if (currentProduct.size === "large") {
      sizePrice = 1.0;
    }

    // Toppings price
    let toppingsPrice = 0;
    currentProduct.toppings.forEach((topping) => {
      toppingsPrice += topping.price;
    });

    // Update price displays
    document.getElementById("sizePrice").textContent = "$" + sizePrice.toFixed(2);
    document.getElementById("toppingsPrice").textContent = "$" + toppingsPrice.toFixed(2);

    // Calculate total
    const total = basePrice + sizePrice + toppingsPrice;
    document.getElementById("totalPrice").textContent = "$" + total.toFixed(2);
  }

  // Add to cart
  confirmBtn.addEventListener("click", () => {
    // Get current selections
    const size = drinkSizeSelect.options[drinkSizeSelect.selectedIndex].text;
    const sugar = sugarLevelSelect.options[sugarLevelSelect.selectedIndex].text;

    // Create order summary
    let toppingsText = "";
    if (currentProduct.toppings.length > 0) {
      const toppingNames = currentProduct.toppings.map((t) => t.name).join(", ");
      toppingsText = ` with ${toppingNames}`;
    }


    if (plusBtn) {
      plusBtn.addEventListener("click", () => {
        let quantity = Number.parseInt(quantityInput.value)
        quantity++
        quantityInput.value = quantity
        currentProduct.quantity = quantity
        updateTotalPrice()
      })
    }

    // Add event listeners to topping checkboxes
    if (toppingCheckboxes && toppingCheckboxes.length > 0) {
      toppingCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
          updateToppings()
          updateTotalPrice()
        })
      })
    }

    // Update toppings array
    function updateToppings() {
      currentProduct.toppings = []
      toppingCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          currentProduct.toppings.push({
            name: checkbox.value,
            price: Number.parseFloat(checkbox.getAttribute("data-price") || "0"),
          })
        }
      })
    }

    // Calculate and update total price
    function updateTotalPrice() {
      // Base price
      const baseItemPrice = currentProduct.price

      // Size price
      const sizeItemPrice = currentProduct.size.price || 0

      // Toppings price
      let toppingsItemPrice = 0
      currentProduct.toppings.forEach((topping) => {
        toppingsItemPrice += topping.price
      })

      // Update price displays
      if (sizePrice) sizePrice.textContent = "$" + sizeItemPrice.toFixed(2)
      if (toppingsPrice) toppingsPrice.textContent = "$" + toppingsItemPrice.toFixed(2)

      // Calculate total for one item
      const itemTotal = baseItemPrice + sizeItemPrice + toppingsItemPrice

      // Calculate total with quantity
      const total = itemTotal * currentProduct.quantity

      // Update current product total price
      currentProduct.totalPrice = total

      // Update display
      if (totalPrice) totalPrice.textContent = "$" + total.toFixed(2)
    }

    // Add to cart
    if (addToCartBtn) {
      addToCartBtn.addEventListener("click", addCurrentProductToCart)
    }

    // Confirm button (legacy support)
    if (confirmBtn) {
      confirmBtn.addEventListener("click", addCurrentProductToCart)
    }

    function addCurrentProductToCart() {
      if (!drinkSizeSelect || !sugarLevelSelect || !iceLevelSelect) {
        console.error("Form elements not found")
        return
      }

      // Disable the button to prevent multiple clicks
      if (addToCartBtn) {
        addToCartBtn.disabled = true
        addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...'
      }

      // Get current selections
      const size = drinkSizeSelect.options[drinkSizeSelect.selectedIndex].text
      const sizeValue = drinkSizeSelect.value
      const sizePrice = Number.parseFloat(
        drinkSizeSelect.options[drinkSizeSelect.selectedIndex].getAttribute("data-price") || "0",
      )

      const sugar = sugarLevelSelect.options[sugarLevelSelect.selectedIndex].text
      const sugarValue = sugarLevelSelect.value

      const ice = iceLevelSelect.options[iceLevelSelect.selectedIndex].text
      const iceValue = iceLevelSelect.value

      // Calculate total price
      const basePrice = currentProduct.price

      let toppingsPrice = 0
      const selectedToppings = []
      toppingCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          const toppingPrice = Number.parseFloat(checkbox.getAttribute("data-price") || "0")
          toppingsPrice += toppingPrice
          selectedToppings.push({
            name: checkbox.value,
            price: toppingPrice,
          })
        }
      })

      const itemPrice = basePrice + sizePrice + toppingsPrice
      const quantity = currentProduct.quantity


      // Create order item
      const orderItem = {
        id: Date.now(), // Unique ID for the cart item
        productId: currentProduct.productId,
        name: currentProduct.name,
        image: currentProduct.image,
        description: currentProduct.description,
        basePrice: itemPrice,
        size: {
          name: size,
          value: sizeValue,
          price: sizePrice,
        },
        sugar: {
          name: sugar,
          value: sugarValue,
        },
        ice: {
          name: ice,
          value: iceValue,
        },
        toppings: selectedToppings,
        quantity: quantity,
        totalPrice: totalPrice,
        orderDate: new Date().toISOString(),
        status: "processing",
      }

      // Add to cart using the cart.js function
      if (window.addToCart) {
        console.log("Adding to cart via window.addToCart")
        window.addToCart(orderItem)

        // Add notification
        if (window.addNotification) {
          window.addNotification(
            "Added to Cart",
            `${orderItem.name} (${orderItem.size.name}) has been added to your cart.`,
            "cart",
          )
        }
      } else {
        // Fallback if cart.js is not loaded
        console.error("addToCart function not found")
        showToast("Error", "Cart functionality not available. Please refresh the page and try again.", "error")

        // Re-enable the button
        if (addToCartBtn) {
          addToCartBtn.disabled = false
          addToCartBtn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart'
        }
        return
      }

      const orderSummary = `${size}, ${sugar}${toppingsText}`;
      const totalPrice = document.getElementById("totalPrice").textContent;

      // Show toast notification
      showToast(currentProduct.name, orderSummary, totalPrice);

      // Close order panel
      closeOrderPanel();

      // Redirect to booking page after a delay (simulating adding to cart)
      setTimeout(() => {
        // In a real application, you would save the order to the cart first
        // window.location.href = '/booking';


        // For demo purposes, just show another toast
        showToast("Order Added", "Your order has been added to cart!", "", "success");
      }, 1500);


      // Show toast notification
      function showToast(title, message, price = "", type = "info") {
        const toast = document.createElement("div");
        toast.className = "toast";

        let icon = "info-circle";
        if (type === "success") {
          icon = "check-circle";
          toast.style.borderLeftColor = "#4caf50";
        } else if (type === "error") {
          icon = "exclamation-circle";
          toast.style.borderLeftColor = "#f44336";
        }


        // Format toppings
        let toppingsText = "None"
        if (orderItem.toppings && orderItem.toppings.length > 0) {
          toppingsText = orderItem.toppings.map((t) => t.name).join(", ")
        }

        confirmationCard.innerHTML = `
      <div class="confirmation-content">
        <div class="confirmation-header">
          <h3>Added to Cart!</h3>
          <button class="close-confirmation">&times;</button>
        </div>
        <div class="confirmation-product">
          <img src="${orderItem.image}" alt="${orderItem.name}">
          <div class="confirmation-details">
            <h4>${orderItem.name}</h4>
            <p>Size: ${orderItem.size.name}</p>
            <p>Sugar: ${orderItem.sugar.name}</p>
            <p>Ice: ${orderItem.ice.name}</p>
            <p>Toppings: ${toppingsText}</p>
            <p>Quantity: ${orderItem.quantity}</p>
            <p class="confirmation-price">$${orderItem.totalPrice.toFixed(2)}</p>
          </div>
        </div>
        <div class="confirmation-actions">
          <button class="view-cart-btn">View Cart</button>
          <button class="checkout-btn">Checkout Now</button>
          <button class="continue-shopping-btn">Continue Shopping</button>
        </div>
      </div>
    `

        document.body.appendChild(confirmationCard)

        // Add event listeners
        const closeBtn = confirmationCard.querySelector(".close-confirmation")
        closeBtn.addEventListener("click", () => {
          confirmationCard.classList.add("fade-out")
          setTimeout(() => {
            confirmationCard.remove()
          }, 300)
        })

        const viewCartBtn = confirmationCard.querySelector(".view-cart-btn")
        viewCartBtn.addEventListener("click", () => {
          confirmationCard.remove()
          // Open cart panel if it exists
          const cartPanel = document.getElementById("cartPanel")
          if (cartPanel) {
            closeAllPanels() // Close any other panels first
            cartPanel.style.display = "block"
            cartPanel.classList.add("active")
            if (overlay) {
              overlay.style.display = "block"
              overlay.classList.add("active")
            }
          } else {
            console.error("Cart panel not found")
          }
        })

        const checkoutBtn = confirmationCard.querySelector(".checkout-btn")
        checkoutBtn.addEventListener("click", () => {
          confirmationCard.remove()
          console.log("Checkout button clicked, redirecting to booking page")
          // Set flag to create booking on page load
          sessionStorage.setItem("justCheckedOut", "true")
          // Redirect to booking page
          window.location.href = "/booking"
        })

        const continueShoppingBtn = confirmationCard.querySelector(".continue-shopping-btn")
        continueShoppingBtn.addEventListener("click", () => {
          confirmationCard.classList.add("fade-out")
          setTimeout(() => {
            confirmationCard.remove()
          }, 300)
        })

        // Add CSS for confirmation card
        if (!document.querySelector("#order-confirmation-styles")) {
          const style = document.createElement("style")
          style.id = "order-confirmation-styles"
          style.textContent = `
                <div>
                    <i class="fas fa-${icon}" style="color: ${type === "success" ? "#4caf50" : type === "error" ? "#f44336" : "#ff5e62"}; font-size: 20px; margin-right: 10px;"></i>
                </div>
                <div style="flex: 1;">
                    <h4>${title}</h4>
                    <p>${message}</p>
                </div>
                <button class="toast-close">&times;</button>
            
                toast.innerHTML = 
            <div>
                <i class="fas fa-${icon}" style="color: ${type === "success" ? "#4caf50" : type === "error" ? "#f44336" : "#ff5e62"}; font-size: 20px; margin-right: 10px;"></i>
            </div>
            <div style="flex: 1;">
                <h4>${title}</h4>
                <p>${message}</p>
                ${price ? `<p style="font-weight: 600; color: #ff5e62; margin-top: 5px;">${price}</p>` : ""}
            </div>
            <button class="toast-close">&times;</button>
        `;





          // Add to container
          toastContainer.appendChild(toast);

          // Add close button functionality
          const closeButton = toast.querySelector(".toast-close");
          closeButton.addEventListener("click", () => {
            toast.remove();
          });

          // Auto remove after 5 seconds
          setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => {
              toast.remove();
            }, 300);
          }, 5000);
        }

        // Initialize favorite buttons
        const favoriteButtons = document.querySelectorAll(".favorite-btn");
        favoriteButtons.forEach((button) => {
          button.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const icon = this.querySelector("i");
            if (icon.classList.contains("far")) {

              icon.classList.remove("far")
              icon.classList.add("fas")
              saveFavorite(productId, productName, productImage, productPrice, productDescription)
              showToast("Added to Favorites", "Item added to your favorites!", "success")

              // Add notification
              if (window.addNotification) {
                window.addNotification("Added to Favorites", `${productName} has been added to your favorites.`, "info")
              }

              // Add heart beat animation
              icon.style.animation = "heartBeat 0.5s ease-in-out"
              setTimeout(() => {
                icon.style.animation = ""
              }, 500)
            } else {
              icon.classList.remove("fas")
              icon.classList.add("far")
              removeFavorite(productId)
              showToast("Removed from Favorites", "Item removed from your favorites", "info")

              // Add notification
              if (window.addNotification) {
                window.addNotification(
                  "Removed from Favorites",
                  `${productName} has been removed from your favorites.`,
                  "info",
                )
              }
            }
          })
        })


