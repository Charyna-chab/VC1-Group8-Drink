<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<section class="content">
    <!-- Discount banner -->
    <div class="discount-banner">
        <div class="banner-content">
            <h2>Get Discount Voucher Up To 20%</h2>
            <p>Use code: <strong>BOBA20</strong> at checkout</p>
            <button class="btn-primary">Get Voucher</button>
        </div>
        <img src="/assets/image/discount-banner.png" alt="Discount 20-50%">
    </div>

    <!-- New Drinks Collection Section -->
    <div class="new-drinks-collection">
        <h3>New Drinks Collection</h3>
        <div class="new-drinks-grid">
            <?php if (empty($newDrinks)): ?>
                <div class="no-new-drinks">
                    <p>No new drinks available at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($newDrinks as $drink): ?>
                    <div class="new-drink-card" data-id="<?php echo $drink['id']; ?>">
                        <div class="new-drink-image">
                            <img src="<?php echo $drink['image']; ?>" alt="<?php echo $drink['name']; ?>">
                        </div>
                        <div class="new-drink-content">
                            <h4><?php echo $drink['name']; ?></h4>
                            <p class="price">$<?php echo number_format($drink['price'], 2); ?></p>
                            <p class="description">New arrival!</p>
                            <button class="btn-primary order-btn" data-product-id="<?php echo $drink['id']; ?>">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Category Section -->
    <div class="category-section">
        <div class="category-list">
            <div class="category-item active" data-category="all">All</div>
            <div class="category-item" data-category="milk-tea">Milk Tea</div>
            <div class="category-item" data-category="fruit-tea">Fruit Tea</div>
            <div class="category-item" data-category="smoothie">Smoothies</div>
            <div class="category-item" data-category="coffee">Coffee</div>
            <div class="category-item" data-category="snacks">Snacks</div>
        </div>
        <div class="search-container">
            <input type="text" id="productSearch" placeholder="Search for your favorite drink...">
            <i class="fas fa-search"></i>
        </div>
    </div>

    <!-- Popular Drinks Button -->
    <div class="popular-drinks-button">
        <button class="btn-primary" style="width: 12%;" id="showPopularDrinks">Popular Drinks</button>
    </div>

    <!-- Popular Drinks Section -->
    <div class="popular-drinks" id="popularDrinksSection" style="display: none;">
        <h3>Popular Drinks</h3>
        <div class="dishes-list" id="popularDishesContainer">
            <!-- Dynamic Popular Drinks List -->
            <!-- Example of a popular drink card -->
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/strawberry-smoothie.png" alt="Strawberry Smoothie">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Strawberry Smoothie</h4>
                    <p class="description">Top seller this week!</p>
                    <div class="product-price">$4.99</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="9">Add to Cart</button>
                </div>
            </div>
            <!-- No popular drinks message -->
            <div id="noPopularDrinksMessage" style="display: none;">No popular drinks available at the moment.</div>
        </div>
    </div>

    <!-- Popular dishes section -->
    <div class="popular-dishes">
        <h3>Popular Drinks & Snacks</h3>
        <div class="dishes-list" id="dishes-container">
            <!-- Product Cards (Dynamic Product List) -->
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/images/products/strawberry-smoothie.jpg" alt="Strawberry Smoothie">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Strawberry Smoothie</h4>
                    <p class="description">Delicious strawberry smoothie with a creamy texture.</p>
                    <div class="product-price">$4.99</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="9">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/mango-smoothie.png" alt="Mango Smoothie">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Mango Smoothie</h4>
                    <p class="description">A refreshing mango smoothie for your hot day.</p>
                    <div class="product-price">$5.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="10">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/image/products/classic-milk-tea.png" alt="Classic Milk Tea">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Classic Milk Tea</h4>
                    <p class="description">Our signature milk tea with premium black tea and creamy milk.</p>
                    <div class="product-price">$4.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="1">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/image/products/taro-milk-tea.png" alt="Taro Milk Tea">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Taro Milk Tea</h4>
                    <p class="description">Creamy taro flavor blended with our premium milk tea.</p>
                    <div class="product-price">$5.00</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="2">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/images/products/matcha-latte.jpg" alt="Matcha Latte">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Matcha Latte</h4>
                    <p class="description">Premium Japanese matcha powder with fresh milk.</p>
                    <div class="product-price">$5.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="3">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/image/products/brown-sugar-boba.png" alt="Brown Sugar Boba Milk">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Brown Sugar Boba Milk</h4>
                    <p class="description">Fresh milk with brown sugar syrup and chewy boba pearls.</p>
                    <div class="product-price">$5.75</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="4">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="fruit-tea">
                <div class="product-image">
                    <img src="/assets/image/products/strawberry-tea.png" alt="Strawberry Fruit Tea">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Strawberry Fruit Tea</h4>
                    <p class="description">Refreshing tea with fresh strawberry puree and fruit bits.</p>
                    <div class="product-price">$4.75</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="5">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="fruit-tea">
                <div class="product-image">
                    <img src="/assets/image/products/mango-tea.png" alt="Mango Fruit Tea">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Mango Fruit Tea</h4>
                    <p class="description">Tropical mango flavor blended with our premium tea.</p>
                    <div class="product-price">$4.75</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="6">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="coffee">
                <div class="product-image">
                    <img src="/assets/image/products/caramel-macchiato.png" alt="Caramel Macchiato">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Caramel Macchiato</h4>
                    <p class="description">Espresso with steamed milk and caramel syrup.</p>
                    <div class="product-price">$4.75</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="14">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="snacks">
                <div class="product-image">
                    <img src="/assets/image/products/egg-waffles.png" alt="Egg Waffles">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Egg Waffles</h4>
                    <p class="description">Crispy on the outside, fluffy on the inside Hong Kong style egg waffles.</p>
                    <div class="product-price">$4.00</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="17">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="snacks">
                <div class="product-image">
                    <img src="/assets/image/products/popcorn-chicken.png" alt="Popcorn Chicken">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Popcorn Chicken</h4>
                    <p class="description">Crispy Taiwanese-style popcorn chicken with special seasoning.</p>
                    <div class="product-price">$5.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="18">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/avocado-smoothie.png" alt="Avocado Smoothie">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Avocado Smoothie</h4>
                    <p class="description">Creamy avocado smoothie with fresh avocado and milk.</p>
                    <div class="product-price">$6.00</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="11">Order Now</button>
                </div>
            </div>
            
            <!-- No products found message -->
            <div id="no-product-message" style="display: none;">No products found matching your search.</div>
        </div>
    </div>
</section>

<!-- Order Modal -->
<div class="modal-overlay" id="orderModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Customize Your Drink</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="product-details">
                <img src="/placeholder.svg?height=100&width=100" alt="" class="modal-product-image">
                <div class="modal-product-info">
                    <h4 class="modal-product-name"></h4>
                    <p class="modal-product-description"></p>
                    <div class="modal-product-price"></div>
                </div>
            </div>
            
            <hr class="modal-divider">
            
            <form id="customizeForm">
                <input type="hidden" name="product_id" id="product_id">
                
                <div class="form-group">
                    <label>Size</label>
                    <div class="option-buttons size-buttons">
                        <label class="option-button">
                            <input type="radio" name="size" value="small" data-price="0">
                            <span>Small</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="medium" data-price="0.50" checked>
                            <span>Medium</span>
                            <small>+$0.50</small>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="large" data-price="1.00">
                            <span>Large</span>
                            <small>+$1.00</small>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Sugar Level</label>
                    <div class="option-buttons sugar-buttons">
                        <label class="option-button">
                            <input type="radio" name="sugar" value="0">
                            <span>0%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="30">
                            <span>30%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="50" checked>
                            <span>50%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="70">
                            <span>70%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="100">
                            <span>100%</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Ice Level</label>
                    <div class="option-buttons ice-buttons">
                        <label class="option-button">
                            <input type="radio" name="ice" value="0">
                            <span>No Ice</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="ice" value="30">
                            <span>Less Ice</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="ice" value="100" checked>
                            <span>Regular Ice</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Toppings <span class="optional">(Optional, +$0.75 each)</span></label>
                    <div class="toppings-grid">
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="1" data-price="0.75">
                            <span>Boba Pearls</span>
                            <small>+$0.75</small>
                        </label>
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="2" data-price="0.75">
                            <span>Grass Jelly</span>
                            <small>+$0.75</small>
                        </label>
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="3" data-price="0.75">
                            <span>Pudding</span>
                            <small>+$0.75</small>
                        </label>
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="4" data-price="0.75">
                            <span>Aloe Vera</span>
                            <small>+$0.75</small>
                        </label>
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="5" data-price="1.00">
                            <span>Cheese Foam</span>
                            <small>+$1.00</small>
                        </label>
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="6" data-price="1.00">
                            <span>Fresh Fruit</span>
                            <small>+$1.00</small>
                        </label>
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="7" data-price="0.75">
                            <span>Red Bean</span>
                            <small>+$0.75</small>
                        </label>
                        <label class="topping-option">
                            <input type="checkbox" name="toppings[]" value="8" data-price="0.75">
                            <span>Coconut Jelly</span>
                            <small>+$0.75</small>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Special Instructions <span class="optional">(Optional)</span></label>
                    <textarea name="instructions" placeholder="Any special requests?"></textarea>
                </div>
                
                <div class="quantity-control">
                    <label>Quantity</label>
                    <div class="quantity-buttons">
                        <button type="button" class="quantity-btn minus-btn">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" value="1" min="1" max="10">
                        <button type="button" class="quantity-btn plus-btn">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="total-price">
                    <span>Total:</span>
                    <span class="price-value">$0.00</span>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" id="cancelOrder">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div class="toast-container" id="toastContainer"></div>

</main>

<script src="/assets/js/welcome.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popularDrinksSection = document.getElementById('popularDrinksSection');
        const popularDishesContainer = document.getElementById('popularDishesContainer');
        const noPopularDrinksMessage = document.getElementById('noPopularDrinksMessage');

        function updatePopularDrinks(drink) {
            // Check if the drink is already in the popular drinks list
            const existingDrink = popularDishesContainer.querySelector(`[data-id="${drink.id}"]`);
            if (existingDrink) {
                return;
            }

            // Create a new drink card
            const drinkCard = document.createElement('div');
            drinkCard.classList.add('product-card');
            drinkCard.setAttribute('data-id', drink.id);
            drinkCard.setAttribute('data-category', drink.category);
            drinkCard.innerHTML = `
                <div class="product-image">
                    <img src="${drink.image}" alt="${drink.name}">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>${drink.name}</h4>
                    <p class="description">${drink.description}</p>
                    <div class="product-price">$${drink.price.toFixed(2)}</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="${drink.id}">Order Now</button>
                </div>
            `;

            // Add the new drink card to the popular drinks container
            popularDishesContainer.appendChild(drinkCard);

            // Show the popular drinks section if it was hidden
            popularDrinksSection.style.display = 'block';
            noPopularDrinksMessage.style.display = 'none';
        }

        // Event listeners for adding to favorites and orders
        document.querySelectorAll('.favorite-btn, .order-btn').forEach(button => {
            button.addEventListener('click', function() {
                const drinkId = this.getAttribute('data-product-id');
                const drink = {
                    id: drinkId,
                    name: this.closest('.product-card').querySelector('h4').textContent,
                    image: this.closest('.product-card').querySelector('img').src,
                    description: this.closest('.product-card').querySelector('.description').textContent,
                    price: parseFloat(this.closest('.product-card').querySelector('.product-price').textContent.replace('$', '')),
                    category: this.closest('.product-card').getAttribute('data-category')
                };
                updatePopularDrinks(drink);
            });
        });
    });
</script>