<div id="alert-boxes-container">
    <?php 
    $products = Database::getInstance()->getAllProducts();
    foreach ($products as $product): 
    ?>
    <div id="<?php echo $product['id']; ?>-alert" class="alert-box">
        <button class="close-btn" onclick="closeAlert('<?php echo $product['id']; ?>')">×</button>
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <h4><?php echo $product['name']; ?></h4>
        <p><?php echo $product['description']; ?></p>
        <p>Enjoy our delicious <?php echo $product['name']; ?> - a perfect treat for any time of day!</p>
    </div>
    <?php endforeach; ?>
</div>

