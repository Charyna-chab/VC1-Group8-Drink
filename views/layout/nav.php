<?php
$navLink = [
    ['name' => 'User', 'href' => '/user'],
    ['name' => 'Category', 'href' => '/categories'],
    ['name' => 'Product', 'href' => '/product'],
    ['name' => 'department', 'href' => '/departments'],
    ['name' => 'employee', 'href' => '/employees'],
]
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MVC PROJECT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <?php foreach ($navLink as $link): ?>
                    <a class="nav-link" href="<?= $link['href'] ?>"><?= $link['name'] ?></a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</nav>